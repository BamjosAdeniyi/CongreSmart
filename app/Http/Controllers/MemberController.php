<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
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
    public function store(MemberStoreRequest $request)
    {
        $validated = $request->validated();

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
            $query->with('class')->orderBy('date', 'desc')->limit(10);
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
    public function update(MemberUpdateRequest $request, Member $member)
    {
        $validated = $request->validated();

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