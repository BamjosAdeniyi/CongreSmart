<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SabbathSchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with(['sabbathClass']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('membership_status', $request->status);
        }

        $members = $query->paginate(20);

        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sabbathClasses = SabbathSchoolClass::where('active', true)->get();

        return view('members.create', compact('sabbathClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'membership_type' => 'required|in:community,student',
            'membership_category' => 'required|in:adult,youth,child,university-student',
            'role_in_church' => 'nullable|string|max:255',
            'baptism_status' => 'required|in:baptized,not-baptized,pending',
            'date_of_baptism' => 'nullable|date|before_or_equal:today|required_if:baptism_status,baptized',
            'membership_date' => 'required|date|before_or_equal:today',
            'sabbath_school_class_id' => 'nullable|exists:sabbath_school_classes,id',
        ]);

        // Generate UUID for member_id
        $validated['member_id'] = (string) Str::uuid();
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Ensure date_of_baptism is set if baptized
        if ($validated['baptism_status'] === 'baptized' && empty($validated['date_of_baptism'])) {
            $validated['date_of_baptism'] = $validated['membership_date'];
        }

        Member::create($validated);

        return redirect()->route('members.index')
                        ->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['sabbathClass', 'attendance' => function($query) {
            $query->orderBy('date', 'desc')->limit(10);
        }, 'contributions' => function($query) {
            $query->orderBy('date', 'desc')->limit(10);
        }]);

        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $sabbathClasses = SabbathSchoolClass::where('active', true)->get();

        return view('members.edit', compact('member', 'sabbathClasses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'membership_type' => 'required|in:community,student',
            'membership_category' => 'required|in:adult,youth,child,university-student',
            'role_in_church' => 'nullable|string|max:255',
            'baptism_status' => 'required|in:baptized,not-baptized,pending',
            'date_of_baptism' => 'nullable|date|before_or_equal:today|required_if:baptism_status,baptized',
            'membership_date' => 'required|date|before_or_equal:today',
            'membership_status' => 'required|in:active,inactive,transferred,archived',
            'sabbath_school_class_id' => 'nullable|exists:sabbath_school_classes,id',
        ]);

        $validated['updated_by'] = Auth::id();

        // Ensure date_of_baptism is set if baptized
        if ($validated['baptism_status'] === 'baptized' && empty($validated['date_of_baptism'])) {
            $validated['date_of_baptism'] = $validated['membership_date'];
        }

        $member->update($validated);

        return redirect()->route('members.show', $member)
                        ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        // Check if user has permission to delete
        if (!in_array(Auth::user()->role, ['clerk', 'ict'])) {
            abort(403, 'Unauthorized action.');
        }

        $member->delete();

        return redirect()->route('members.index')
                        ->with('success', 'Member deleted successfully.');
    }
}