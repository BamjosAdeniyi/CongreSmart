<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\FinancialCategory;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
    /**
     * Display the finance dashboard.
     */
    public function index()
    {
        $categories = FinancialCategory::where('active', true)->get();

        // Get recent contributions
        $recentContributions = Contribution::with(['member', 'category'])
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return view('finance.index', compact('categories', 'recentContributions'));
    }

    /**
     * Show the contributions form.
     */
    public function listContributions()
    {
        $members = Member::where('membership_status', 'active')
            ->orderBy('first_name')
            ->get();

        $categories = FinancialCategory::where('active', true)
            ->orderBy('name')
            ->get();

        return view('finance.contributions', compact('members', 'categories'));
    }

    /**
     * Show the form for creating a new contribution.
     */
    public function createContribution()
    {
        $members = Member::where('membership_status', 'active')
            ->orderBy('first_name')
            ->get();

        $categories = FinancialCategory::where('active', true)
            ->orderBy('name')
            ->get();

        return view('finance.contributions', compact('members', 'categories'));
    }

    /**
     * Store contributions.
     */
    public function storeContributions(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'contributions' => 'required|array',
        ]);

        $date = $request->date;
        $contributionsData = $request->contributions;
        $recordedBy = Auth::id();

        DB::beginTransaction();

        try {
            foreach ($contributionsData as $memberId => $categories) {
                foreach ($categories as $categoryId => $amount) {
                    $amount = floatval($amount);

                    if ($amount > 0) {
                        Contribution::create([
                            'id' => (string) Str::uuid(),
                            'member_id' => $memberId,
                            'category_id' => $categoryId,
                            'amount' => $amount,
                            'date' => $date,
                            'recorded_by' => $recordedBy,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('finance.contributions')
                            ->with('success', 'Contributions recorded successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to record contributions. Please try again.');
        }
    }

    /**
     * Show financial categories.
     */
    public function categories()
    {
        $categories = FinancialCategory::orderBy('name')->get();

        return view('finance.categories', compact('categories'));
    }

    /**
     * Store a new financial category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:financial_categories,name',
            'description' => 'nullable|string',
            'category_type' => 'required|in:income,expense',
        ]);

        FinancialCategory::create([
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'description' => $request->description,
            'category_type' => $request->category_type,
            'active' => true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('finance.categories')
                        ->with('success', 'Category created successfully.');
    }

    /**
     * Update a financial category.
     */
    public function updateCategory(Request $request, FinancialCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:financial_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'category_type' => 'required|in:income,expense',
            'active' => 'boolean',
        ]);

        $category->update($request->only(['name', 'description', 'category_type', 'active']));

        return redirect()->route('finance.categories')
                        ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a financial category.
     */
    public function destroyCategory(FinancialCategory $category)
    {
        // Check if category has contributions
        if ($category->contributions()->count() > 0) {
            return redirect()->route('finance.categories')
                            ->with('error', 'Cannot delete category with existing contributions.');
        }

        $category->delete();

        return redirect()->route('finance.categories')
                        ->with('success', 'Category deleted successfully.');
    }

    /**
     * Show financial reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get contributions within date range
        $contributions = Contribution::with(['member', 'category'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // Calculate totals by category
        $categoryTotals = $contributions->groupBy('category.name')
            ->map(function ($group) {
                return $group->sum('amount');
            });

        // Calculate member totals
        $memberTotals = $contributions->groupBy('member_id')
            ->map(function ($group) {
                return [
                    'member' => $group->first()->member,
                    'total' => $group->sum('amount'),
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('total');

        $grandTotal = $contributions->sum('amount');

        return view('finance.reports', compact(
            'contributions',
            'categoryTotals',
            'memberTotals',
            'grandTotal',
            'startDate',
            'endDate'
        ));
    }
}
