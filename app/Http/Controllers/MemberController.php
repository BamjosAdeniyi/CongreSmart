<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Controllers\NotificationsController;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\Member;
use App\Models\SabbathSchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\MemberTransfer;
use Illuminate\Support\Facades\DB;

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

        // Sorting functionality
        $sortColumn = $request->get('sort_by', 'first_name');
        $sortDirection = $request->get('sort_order', 'asc');

        $allowedSortColumns = [
            'first_name',
            'date_of_birth',
            'membership_type',
            'membership_category',
            'baptism_status'
        ];

        if (in_array($sortColumn, $allowedSortColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('first_name', 'asc');
        }

        $members = $query->paginate(20)->withQueryString();

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

        $member = Member::create($validated);

        NotificationsController::notify(
            'New Member Registered',
            "{$member->full_name} has been successfully added to the system by " . Auth::user()->name . ".",
            'success',
            null,
            route('members.show', $member)
        );

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
        $member->update($request->validated());

        NotificationsController::notify(
            'Member Record Updated',
            "The details for {$member->full_name} have been updated by " . Auth::user()->name . ".",
            'info',
            null,
            route('members.show', $member)
        );

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
            abort(403, 'You are not authorized to perform this action.');
        }

        $member->delete();

        return redirect()->route('members.index')
                        ->with('success', 'Member deleted successfully.');
    }

    /**
     * Handle member transfer.
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'member_id' => 'required|uuid|exists:members,member_id',
            'transfer_type' => 'required|string|in:class,church',
            'direction' => 'required|string|in:from,to',
            'church_name' => 'nullable|string|max:255',
            'to_class_id' => 'nullable|exists:sabbath_school_classes,id',
            'transfer_date' => 'required|date',
            'reason' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $member = Member::where('member_id', $request->member_id)->firstOrFail();

        DB::beginTransaction();
        try {
            $transfer = MemberTransfer::create([
                'member_id' => $member->member_id,
                'transfer_type' => $request->transfer_type,
                'status' => 'pending', // By default pending
                'direction' => $request->direction,
                'church_name' => $request->church_name,
                'from_class_id' => $member->sabbath_school_class_id,
                'to_class_id' => $request->to_class_id,
                'transfer_date' => $request->transfer_date,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'processed_by' => Auth::id(),
            ]);

            // Auto-complete if it's just a class transfer for now, or if directed by business logic
            if ($request->transfer_type === 'class') {
                $transfer->update(['status' => 'completed']);
                $member->update(['sabbath_school_class_id' => $request->to_class_id]);
                DB::commit();
                return response()->json(['message' => 'Member successfully transferred between classes.', 'status' => 'success']);
            }

            // For church transfers, we keep it pending until approved (as per the prototype/current UI)
            NotificationsController::notify(
                'New Transfer Request',
                "A church transfer has been requested for {$member->full_name} by " . Auth::user()->name . ".",
                'warning',
                null,
                route('members.transfers')
            );
            DB::commit();
            return response()->json(['message' => 'Transfer request submitted and is pending approval.', 'status' => 'info']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to process transfer: ' . $e->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Approve or reject a member transfer.
     */
    public function updateTransfer(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,rejected',
        ]);

        $transfer = MemberTransfer::findOrFail($id);
        $member = $transfer->member;

        DB::beginTransaction();
        try {
            $transfer->update([
                'status' => $request->status,
                'processed_by' => Auth::id(),
            ]);

            if ($request->status === 'completed') {
                if ($transfer->transfer_type === 'church') {
                    if ($transfer->direction === 'to') {
                        $member->update(['membership_status' => 'transferred']);
                    } else {
                        $member->update(['membership_status' => 'active']);
                    }
                } else {
                    $member->update(['sabbath_school_class_id' => $transfer->to_class_id]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Transfer request ' . $request->status . ' successfully.', 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update transfer: ' . $e->getMessage(), 'status' => 'error'], 500);
        }
    }
}
