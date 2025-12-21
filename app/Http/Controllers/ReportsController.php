<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Contribution;
use App\Models\FinancialCategory;
use App\Models\AttendanceRecord;
use App\Models\SabbathSchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $stats = [
            'total_members' => Member::count(),
            'active_members' => Member::where('membership_status', 'active')->count(),
            'total_contributions' => Contribution::sum('amount'),
            'this_month_contributions' => Contribution::whereMonth('contribution_date', now()->month)
                ->whereYear('contribution_date', now()->year)
                ->sum('amount'),
            'total_classes' => SabbathSchoolClass::count(),
            'total_attendance_records' => AttendanceRecord::count(),
        ];

        return view('reports.index', compact('stats'));
    }

    public function members()
    {
        $members = Member::with(['sabbathSchoolClass'])
            ->orderBy('first_name')
            ->get();

        $stats = [
            'total_members' => $members->count(),
            'active_members' => $members->where('membership_status', 'active')->count(),
            'inactive_members' => $members->where('membership_status', 'inactive')->count(),
            'by_gender' => [
                'male' => $members->where('gender', 'male')->count(),
                'female' => $members->where('gender', 'female')->count(),
            ],
            'by_age_group' => $this->getAgeGroupStats($members),
        ];

        return view('reports.members', compact('members', 'stats'));
    }

    public function attendance()
    {
        $classes = SabbathSchoolClass::with(['attendanceRecords' => function($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        $attendanceStats = $classes->map(function ($class) {
            $records = $class->attendanceRecords;
            $totalSessions = $records->count();

            return [
                'class' => $class,
                'total_sessions' => $totalSessions,
                'average_attendance' => $totalSessions > 0 ? round($records->avg('present_count'), 1) : 0,
                'total_present' => $records->sum('present_count'),
                'attendance_rate' => $totalSessions > 0 ?
                    round(($records->sum('present_count') / ($totalSessions * $class->members()->count())) * 100, 1) : 0,
                'recent_sessions' => $records->take(5),
            ];
        });

        return view('reports.attendance', compact('attendanceStats'));
    }

    public function financial()
    {
        $contributions = Contribution::with(['member', 'category'])
            ->orderBy('contribution_date', 'desc')
            ->get();

        $financialStats = [
            'total_income' => $contributions->where('category.category_type', 'income')->sum('amount'),
            'total_expenses' => $contributions->where('category.category_type', 'expense')->sum('amount'),
            'net_balance' => $contributions->where('category.category_type', 'income')->sum('amount') -
                           $contributions->where('category.category_type', 'expense')->sum('amount'),
            'this_month_income' => $contributions->where('category.category_type', 'income')
                ->whereMonth('contribution_date', now()->month)
                ->whereYear('contribution_date', now()->year)
                ->sum('amount'),
            'this_month_expenses' => $contributions->where('category.category_type', 'expense')
                ->whereMonth('contribution_date', now()->month)
                ->whereYear('contribution_date', now()->year)
                ->sum('amount'),
        ];

        $categoryBreakdown = FinancialCategory::with(['contributions' => function($query) {
            $query->selectRaw('financial_category_id, SUM(amount) as total_amount')
                  ->groupBy('financial_category_id');
        }])->get()->map(function ($category) {
            return [
                'name' => $category->name,
                'type' => $category->category_type,
                'total' => $category->contributions->sum('total_amount') ?? 0,
            ];
        });

        return view('reports.financial', compact('contributions', 'financialStats', 'categoryBreakdown'));
    }

    private function getAgeGroupStats($members)
    {
        $ageGroups = [
            '0-12' => 0,
            '13-18' => 0,
            '19-30' => 0,
            '31-50' => 0,
            '51-70' => 0,
            '71+' => 0,
        ];

        foreach ($members as $member) {
            if ($member->date_of_birth) {
                $age = now()->diffInYears($member->date_of_birth);

                if ($age <= 12) $ageGroups['0-12']++;
                elseif ($age <= 18) $ageGroups['13-18']++;
                elseif ($age <= 30) $ageGroups['19-30']++;
                elseif ($age <= 50) $ageGroups['31-50']++;
                elseif ($age <= 70) $ageGroups['51-70']++;
                else $ageGroups['71+']++;
            }
        }

        return $ageGroups;
    }
}