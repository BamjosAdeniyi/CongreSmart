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
            'this_month_contributions' => Contribution::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount'),
            'total_classes' => SabbathSchoolClass::count(),
            'total_attendance_records' => AttendanceRecord::distinct('date')->count('date'),
        ];

        return view('reports.index', compact('stats'));
    }

    public function members()
    {
        $members = Member::with(['sabbathClass'])
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
        $classes = SabbathSchoolClass::with(['attendance' => function($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        $attendanceStats = $classes->map(function ($class) {
            $records = $class->attendance;
            $totalSessions = $records->unique('date')->count();
            $memberCount = $class->members()->count();

            return [
                'class' => $class,
                'total_sessions' => $totalSessions,
                'average_attendance' => $totalSessions > 0 ? round($records->where('present', true)->count() / $totalSessions, 1) : 0,
                'total_present' => $records->where('present', true)->count(),
                'attendance_rate' => ($totalSessions > 0 && $memberCount > 0) ?
                    round(($records->where('present', true)->count() / ($totalSessions * $memberCount)) * 100, 1) : 0,
                'recent_sessions' => $records->unique('date')->sortByDesc('date')->take(5),
            ];
        });

        return view('reports.attendance', compact('attendanceStats'));
    }

    public function financial()
    {
        $contributions = Contribution::with(['member', 'category'])
            ->orderBy('date', 'desc')
            ->get();

        $financialStats = [
            'total_income' => Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'income')
                ->sum('contributions.amount'),
            'total_expenses' => Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'expense')
                ->sum('contributions.amount'),
            'net_balance' => Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'income')
                ->sum('contributions.amount') -
                Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'expense')
                ->sum('contributions.amount'),
            'this_month_income' => Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'income')
                ->whereMonth('contributions.date', now()->month)
                ->whereYear('contributions.date', now()->year)
                ->sum('contributions.amount'),
            'this_month_expenses' => Contribution::join('financial_categories', 'contributions.category_id', '=', 'financial_categories.id')
                ->where('financial_categories.category_type', 'expense')
                ->whereMonth('contributions.date', now()->month)
                ->whereYear('contributions.date', now()->year)
                ->sum('contributions.amount'),
        ];

        $categoryBreakdown = FinancialCategory::with(['contributions' => function($query) {
            $query->selectRaw('category_id, SUM(amount) as total_amount')
                  ->groupBy('category_id');
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
            $age = $member->age;
            if ($age !== null) {
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
