<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\AttendanceRecord;
use App\Models\Contribution;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function pastor(Request $request)
    {
        // Cache keys and short TTL
        $ttl = now()->addSeconds(30);

        // Total members (A: count ALL members)
        $totalMembers = Cache::remember('dashboard.total_members', 30, fn() => Member::count());

        // Attendance (A: overall attendance %)
        [$presentCount, $totalRecords] = Cache::remember('dashboard.attendance_counts', 30, function () {
            $present = AttendanceRecord::where('present', 1)->count();
            $total  = AttendanceRecord::count();
            return [$present, $total];
        });
        $attendancePercent = $totalRecords > 0 ? round(($presentCount / $totalRecords) * 100, 1) : 0;

        // Monthly income (A: sum all contributions for current month)
        $now = Carbon::now();
        $monthlyIncome = Cache::remember("dashboard.monthly_income_{$now->format('Ym')}", 30, function () use ($now) {
            return Contribution::whereYear('date', $now->year)
                               ->whereMonth('date', $now->month)
                               ->sum('amount');
        });

        // Alerts:
        // 1) 3 consecutive absences (SQL recommended, fallback below)
        $threeMissing = Cache::remember('dashboard.alerts.3_consecutive_absence', 30, function () {
            // Prefer DB window function approach (MySQL 8+/MariaDB 10.2+):
            $sql = <<<SQL
SELECT member_id
FROM (
  SELECT 
    member_id,
    present,
    ROW_NUMBER() OVER (PARTITION BY member_id ORDER BY date DESC) rn
  FROM attendance_records
) t
WHERE t.rn <= 3
GROUP BY member_id
HAVING COUNT(*) = 3 AND SUM(present) = 0
SQL;
            try {
                $rows = DB::select(DB::raw($sql));
                return array_map(fn($r) => $r->member_id, $rows);
            } catch (\Throwable $e) {
                // Fallback to PHP method (less efficient)
                $members = AttendanceRecord::select('member_id')
                    ->groupBy('member_id')
                    ->pluck('member_id');

                $matches = [];
                foreach ($members as $memberId) {
                    $lastThree = AttendanceRecord::where('member_id', $memberId)
                                  ->orderByDesc('date')
                                  ->limit(3)
                                  ->pluck('present')
                                  ->toArray();
                    if (count($lastThree) === 3 && array_sum($lastThree) === 0) {
                        $matches[] = $memberId;
                    }
                }
                return $matches;
            }
        });

        // 2) Upcoming birthdays (next 7 days)
        $upcomingBirthdays = Cache::remember('dashboard.alerts.upcoming_birthdays', 30, function () {
            $today = Carbon::today();
            $end   = $today->copy()->addDays(7);

            // Works across year boundary by comparing month/day
            return Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
                $today->format('m-d'), 
                $end->format('m-d')
            ])->get(['member_id', 'first_name', 'last_name', 'date_of_birth']);
        });

        $alerts = [
            'three_consecutive_absence' => Member::whereIn('member_id', $threeMissing)->get(['member_id','first_name','last_name']),
            'upcoming_birthdays' => $upcomingBirthdays,
        ];

        return view('dashboards.pastor', compact(
            'totalMembers',
            'attendancePercent',
            'monthlyIncome',
            'alerts'
        ));
    }
}
