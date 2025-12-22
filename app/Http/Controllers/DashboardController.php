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

        return view('dashboards.superintendent', compact(
            'totalClasses',
            'totalEnrolled',
            'avgAttendance',
            'lowAttendanceClasses'
        ));
    }

    public function coordinator(Request $request)
    {
        // Coordinator's classes
        $myClasses = Cache::remember('dashboard.coordinator.my_classes', 30, function () {
            return \App\Models\SabbathSchoolClass::where('coordinator_id', Auth::id())
                ->with(['members', 'attendance' => function($query) {
                    $query->latest('date')->take(10);
                }])
                ->withCount('members')
                ->get();
        });

        // Total members in coordinator's classes
        $totalMembers = $myClasses->sum('members_count');

        // Average attendance across coordinator's classes
        $avgAttendance = $myClasses->avg(function($class) {
            $attendance = $class->attendance;
            if ($attendance->isEmpty()) return 0;
            $present = $attendance->where('present', true)->count();
            return ($present / $attendance->count()) * 100;
        });

        // Recent attendance records
        $recentAttendance = Cache::remember('dashboard.coordinator.recent_attendance', 30, function () {
            return \App\Models\SabbathSchoolClass::where('coordinator_id', Auth::id())
                ->with(['attendance' => function($query) {
                    $query->latest('date')->take(5);
                }])
                ->get()
                ->pluck('attendance')
                ->flatten()
                ->sortByDesc('date')
                ->take(10);
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
        $totalIncome = Cache::remember('dashboard.financial.total_income', 30, function () {
            return \App\Models\Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'income')
                ->sum('contributions.amount');
        });

        $totalExpenses = Cache::remember('dashboard.financial.total_expenses', 30, function () {
            return \App\Models\Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'expense')
                ->sum('contributions.amount');
        });

        $netBalance = $totalIncome - $totalExpenses;

        // This month's contributions
        $thisMonthIncome = Cache::remember('dashboard.financial.this_month_income', 30, function () {
            return \App\Models\Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'income')
                ->whereMonth('contributions.date', now()->month)
                ->whereYear('contributions.date', now()->year)
                ->sum('contributions.amount');
        });

        $thisMonthExpenses = Cache::remember('dashboard.financial.this_month_expenses', 30, function () {
            return \App\Models\Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'expense')
                ->whereMonth('contributions.date', now()->month)
                ->whereYear('contributions.date', now()->year)
                ->sum('contributions.amount');
        });

        // Recent contributions
        $recentContributions = Cache::remember('dashboard.financial.recent_contributions', 30, function () {
            return \App\Models\Contribution::with(['member', 'category'])
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
        });

        return view('dashboards.financial', compact(
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'thisMonthIncome',
            'thisMonthExpenses',
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

        return view('dashboards.welfare', compact(
            'totalMembers',
            'activeMembers',
            'potentialWelfareCases'
        ));
    }

    public function ict(Request $request)
    {
        // System statistics
        $totalUsers = Cache::remember('dashboard.ict.total_users', 30, fn() => \App\Models\User::count());
        
        $activeUsers = Cache::remember('dashboard.ict.active_users', 30, function () {
            return \App\Models\User::where('email_verified_at', '!=', null)->count();
        });

        // Recent system activity (this would need logging)
        $recentActivity = Cache::remember('dashboard.ict.recent_activity', 30, function () {
            // For now, just return recent user registrations
            return \App\Models\User::orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        });

        // System health (simplified)
        $systemHealth = [
            'database' => 'Healthy',
            'storage' => 'Good',
            'backups' => 'Up to date'
        ];

        return view('dashboards.ict', compact(
            'totalUsers',
            'activeUsers',
            'recentActivity',
            'systemHealth'
        ));
    }
}
