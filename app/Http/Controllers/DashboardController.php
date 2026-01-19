<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\AttendanceRecord;
use App\Models\Contribution;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getUpcomingBirthdays()
    {
        $today = Carbon::today();
        $end   = $today->copy()->addDays(7);

        // Works across year boundary by comparing month/day
        return Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
            $today->format('m-d'),
            $end->format('m-d')
        ])->get(['member_id', 'first_name', 'last_name', 'date_of_birth', 'photo']);
    }

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
            return $this->getUpcomingBirthdays();
        });

        $alerts = [
            'three_consecutive_absence' => Member::whereIn('member_id', $threeMissing)->get(['member_id','first_name','last_name']),
            'upcoming_birthdays' => $upcomingBirthdays,
        ];

        // Chart data for Attendance Trend (last 12 months)
        $attendanceTrend = Cache::remember('dashboard.attendance_trend', 30, function () {
            $data = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $present = AttendanceRecord::where('present', 1)
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->count();
                $data[] = [
                    'month' => $date->format('M Y'),
                    'attendance' => $present
                ];
            }
            return $data;
        });

        // Chart data for Financial Breakdown
        $financialBreakdown = Cache::remember('dashboard.financial_breakdown', 30, function () {
            return \App\Models\FinancialCategory::with(['contributions' => function ($query) {
                $query->selectRaw('category_id, SUM(amount) as total')
                      ->groupBy('category_id');
            }])->get()->map(function ($category) {
                return [
                    'category' => $category->name,
                    'amount' => $category->contributions->sum('total')
                ];
            })->filter(function ($item) {
                return $item['amount'] > 0;
            })->values();
        });

        return view('dashboards.pastor', compact(
            'totalMembers',
            'attendancePercent',
            'monthlyIncome',
            'alerts',
            'attendanceTrend',
            'financialBreakdown',
            'upcomingBirthdays'
        ));
    }

    public function clerk(Request $request)
    {
        // Cache keys and short TTL
        $ttl = now()->addSeconds(30);

        // Total members
        $totalMembers = Cache::remember('dashboard.clerk.total_members', 30, fn() => Member::count());

        // Active members
        $activeMembers = Cache::remember('dashboard.clerk.active_members', 30, fn() =>
            Member::where('membership_status', 'active')->count()
        );

        // New members this month
        $newMembersThisMonth = Cache::remember('dashboard.clerk.new_this_month', 30, function () {
            return Member::whereMonth('membership_date', now()->month)
                        ->whereYear('membership_date', now()->year)
                        ->count();
        });

        // Upcoming birthdays (next 30 days)
        $upcomingBirthdays = Cache::remember('dashboard.clerk.upcoming_birthdays', 30, function () {
            return Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
                now()->format('m-d'),
                now()->addDays(30)->format('m-d')
            ])->select('first_name', 'last_name', 'date_of_birth')
              ->orderByRaw("DATE_FORMAT(date_of_birth, '%m-%d')")
              ->limit(5)
              ->get();
        });

        // Recent members (last 5 added)
        $recentMembers = Cache::remember('dashboard.clerk.recent_members', 30, function () {
            return Member::orderBy('membership_date', 'desc')
                        ->select('first_name', 'last_name', 'membership_date', 'membership_status')
                        ->limit(5)
                        ->get();
        });

        return view('dashboards.clerk', compact(
            'totalMembers',
            'activeMembers',
            'newMembersThisMonth',
            'upcomingBirthdays',
            'recentMembers'
        ));
    }

    public function superintendent(Request $request)
    {
        // Sabbath School statistics
        $totalClasses = Cache::remember('dashboard.superintendent.total_classes', 30, function () {
            return \App\Models\SabbathSchoolClass::count();
        });

        $totalEnrolled = Cache::remember('dashboard.superintendent.total_enrolled', 30, function () {
            return \App\Models\SabbathSchoolClass::withCount('members')->get()->sum('members_count');
        });

        // Average attendance for Sabbath School
        $avgAttendance = Cache::remember('dashboard.superintendent.avg_attendance', 30, function () {
            $totalPresent = \App\Models\AttendanceRecord::where('present', true)->count();
            $totalRecords = \App\Models\AttendanceRecord::count();
            return $totalRecords > 0 ? round(($totalPresent / $totalRecords) * 100, 1) : 0;
        });

        // Classes with low attendance (< 70%)
        $lowAttendanceClasses = Cache::remember('dashboard.superintendent.low_attendance', 30, function () {
            return \App\Models\SabbathSchoolClass::with(['attendance' => function($query) {
                $query->latest('date')->take(5);
            }])->get()->filter(function($class) {
                if ($class->attendance->isEmpty()) return false;
                $present = $class->attendance->where('present', true)->count();
                $total = $class->attendance->count();
                $rate = $total > 0 ? ($present / $total) * 100 : 0;
                return $rate < 70;
            })->take(3);
        });

        // Upcoming birthdays (next 7 days)
        $upcomingBirthdays = Cache::remember('dashboard.superintendent.upcoming_birthdays', 30, function () {
            return $this->getUpcomingBirthdays();
        });

        return view('dashboards.superintendent', compact(
            'totalClasses',
            'totalEnrolled',
            'avgAttendance',
            'lowAttendanceClasses',
            'upcomingBirthdays'
        ));
    }

    public function coordinator(Request $request)
    {
        $myClassIds = Cache::remember('dashboard.coordinator.my_class_ids', 30, function () {
            return \App\Models\SabbathSchoolClass::where('coordinator_id', Auth::id())->pluck('id');
        });

        $myClasses = Cache::remember('dashboard.coordinator.my_classes', 30, function () use ($myClassIds) {
            return \App\Models\SabbathSchoolClass::whereIn('id', $myClassIds)
                ->withCount('members')
                ->get();
        });

        $totalMembers = $myClasses->sum('members_count');

        $avgAttendance = Cache::remember('dashboard.coordinator.avg_attendance', 30, function () use ($myClassIds) {
            $totalRecords = AttendanceRecord::whereIn('class_id', $myClassIds)->count();
            if ($totalRecords === 0) return 0;
            $presentRecords = AttendanceRecord::whereIn('class_id', $myClassIds)->where('present', true)->count();
            return round(($presentRecords / $totalRecords) * 100);
        });

        $recentAttendance = Cache::remember('dashboard.coordinator.recent_attendance', 30, function () use ($myClassIds) {
            return AttendanceRecord::whereIn('class_id', $myClassIds)
                ->select('date', DB::raw('SUM(present) as present_count'), DB::raw('COUNT(*) as total_count'))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();
        });

        return view('dashboards.coordinator', compact(
            'myClasses',
            'totalMembers',
            'avgAttendance',
            'recentAttendance'
        ));
    }

    public function financial(Request $request)
    {
        // Financial statistics
        $totalContributions = Cache::remember('dashboard.financial.total_contributions', 30, fn() => Contribution::sum('amount'));
        $monthlyContributions = Cache::remember('dashboard.financial.monthly_contributions', 30, fn() => Contribution::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount'));

        $categories = Cache::remember('dashboard.financial.categories', 30, function () {
            return \App\Models\FinancialCategory::withCount('contributions')
                ->withSum('contributions', 'amount')
                ->get();
        });

        $recentContributions = Cache::remember('dashboard.financial.recent_contributions', 30, function () {
            return Contribution::with(['member', 'category'])
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
        });

        return view('dashboards.financial', compact(
            'totalContributions',
            'monthlyContributions',
            'categories',
            'recentContributions'
        ));
    }

    public function welfare(Request $request)
    {
        // Similar to clerk but focused on welfare aspects
        $totalMembers = Cache::remember('dashboard.welfare.total_members', 30, fn() => Member::count());

        $activeMembers = Cache::remember('dashboard.welfare.active_members', 30, fn() =>
            Member::where('membership_status', 'active')->count()
        );

        // Members who might need welfare assistance (based on some criteria)
        $potentialWelfareCases = Cache::remember('dashboard.welfare.potential_cases', 30, function () {
            // This could be based on various criteria - for now, just return recent inactive members
            return Member::where('membership_status', 'inactive')
                        ->orderBy('updated_at', 'desc')
                        ->limit(5)
                        ->get();
        });

        // Upcoming birthdays (next 7 days)
        $upcomingBirthdays = Cache::remember('dashboard.welfare.upcoming_birthdays', 30, function () {
            return $this->getUpcomingBirthdays();
        });

        // Define placeholder variables
        $activeCases = 0;
        $membersHelped = 0;
        $assistanceTypes = 0;
        $monthlyAssistance = 0;

        return view('dashboards.welfare', compact(
            'totalMembers',
            'activeMembers',
            'potentialWelfareCases',
            'activeCases',
            'membersHelped',
            'assistanceTypes',
            'monthlyAssistance',
            'upcomingBirthdays'
        ));
    }

    public function ict(Request $request)
    {
        // System statistics
        $totalUsers = Cache::remember('dashboard.ict.total_users', 30, fn() => \App\Models\User::count());

        $activeUsers = Cache::remember('dashboard.ict.active_users', 30, function () {
            return \App\Models\User::where('email_verified_at', '!=', null)->count();
        });

        // For demo purposes, simulate active sessions
        $activeSessions = Cache::remember('dashboard.ict.active_sessions', 30, fn() => rand(5, 15));

        // Recent system activity
        $recentActivity = Cache::remember('dashboard.ict.recent_activity', 30, function () {
            return \App\Models\User::orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        });

        // System health percentage
        $systemHealth = 95; // Simulated

        // Pending tasks
        $pendingTasks = Cache::remember('dashboard.ict.pending_tasks', 30, fn() => rand(0, 5));

        return view('dashboards.ict', compact(
            'totalUsers',
            'activeUsers',
            'activeSessions',
            'recentActivity',
            'systemHealth',
            'pendingTasks'
        ));
    }
}
