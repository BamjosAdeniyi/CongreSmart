<?php

namespace App\Http\Controllers;

use App\Models\SabbathSchoolClass;
use App\Models\Member;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\NotificationsController;

class SabbathSchoolController extends Controller
{
    public function index()
    {
        $query = SabbathSchoolClass::with(['coordinator', 'members' => function($q) {
                $q->where('membership_status', '!=', 'transferred');
            }])
            ->withCount(['members' => function($q) {
                $q->where('membership_status', '!=', 'transferred');
            }]);

        // If user is coordinator, only show their class
        if (Auth::user()->role === 'coordinator') {
            $query->where('coordinator_id', Auth::id());
        }

        $classes = $query->orderBy('name')->get();

        $totalMembers = Member::where('membership_status', '!=', 'transferred')->count();
        $totalAttendance = AttendanceRecord::whereDate('date', today())->count();

        // Get coordinators for modal (only for superintendent)
        $coordinators = [];
        if (Auth::user()->role === 'superintendent') {
            $coordinators = \App\Models\User::where('role', 'coordinator')
                ->where('active', true)
                ->orderBy('first_name')
                ->get();
        }

        return view('sabbath-school.index', compact('classes', 'totalMembers', 'totalAttendance', 'coordinators'));
    }

    public function create()
    {
        // Only superintendent can create classes
        if (Auth::user()->role !== 'superintendent') {
            abort(403, 'You are not authorized to perform this action.');
        }

        $coordinators = \App\Models\User::where('role', 'coordinator')
            ->where('active', true)
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.create', compact('coordinators'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $class = SabbathSchoolClass::create([
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'coordinator_id' => $request->coordinator_id,
                'active' => true,
                'created_by' => Auth::id(),
            ]);

            // Notify
            $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            NotificationsController::notify(
                'Sabbath School Class Created',
                "$userName created a new class: {$class->name}",
                'success',
                null,
                route('sabbath-school.show', $class)
            );
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class created successfully.');
    }

    public function show(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can view
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $class->load(['coordinator', 'members' => function($q) {
            $q->where('membership_status', '!=', 'transferred');
        }, 'attendance']);

        $attendanceStats = [
            'total_sessions' => $class->attendance()->distinct('date')->count(),
            'average_attendance' => round($class->attendance()->where('present', true)->count() / max($class->attendance()->distinct('date')->count(), 1), 1),
            'last_attendance' => $class->attendance()->latest('date')->first(),
        ];

        return view('sabbath-school.show', compact('class', 'attendanceStats'));
    }

    public function edit(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can edit
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $coordinators = \App\Models\User::where('role', 'coordinator')
            ->where('active', true)
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.edit', compact('class', 'coordinators'));
    }

    public function update(Request $request, SabbathSchoolClass $class)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_id' => 'required|exists:users,id',
            'active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $class) {
            $class->update([
                'name' => $request->name,
                'description' => $request->description,
                'coordinator_id' => $request->coordinator_id,
                'active' => $request->has('active'),
                'updated_by' => Auth::id(),
            ]);

            // Notify
            $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            NotificationsController::notify(
                'Sabbath School Class Updated',
                "$userName updated the class: {$class->name}",
                'info',
                null,
                route('sabbath-school.show', $class)
            );
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class updated successfully.');
    }

    public function destroy(SabbathSchoolClass $class)
    {
        // Only superintendent can delete classes
        if (Auth::user()->role !== 'superintendent') {
            abort(403, 'You are not authorized to perform this action.');
        }

        // Check if class has members
        if ($class->members()->count() > 0) {
            return back()->with('error', 'Cannot delete class with active members. Please reassign all members first.');
        }

        $class->delete();

        // Notify
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        NotificationsController::notify(
            'Sabbath School Class Deleted',
            "$userName deleted the class: {$class->name}",
            'warning'
        );

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class deleted successfully.');
    }

    public function attendance(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can take attendance
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $members = $class->members()->where('membership_status', '!=', 'transferred')->orderBy('first_name')->get();
        $today = today();

        // Eager load existing attendance for the given date to check presence
        $existingAttendance = AttendanceRecord::where('class_id', $class->id)
            ->whereDate('date', $today)
            ->pluck('present', 'member_id');

        return view('sabbath-school.attendance', compact('class', 'members', 'existingAttendance'));
    }

    public function getAttendanceDataForDate(Request $request, SabbathSchoolClass $class)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format.'], 400);
        }

        $attendanceData = AttendanceRecord::where('class_id', $class->id)
            ->whereDate('date', $request->date)
            ->pluck('present', 'member_id');

        return response()->json($attendanceData);
    }

    public function storeAttendance(Request $request, SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can store attendance
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'present_members' => 'nullable|array',
            'present_members.*' => 'exists:members,member_id',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $class) {
            // Delete existing attendance for this class and date
            AttendanceRecord::where('class_id', $class->id)
                ->whereDate('date', $request->date)
                ->delete();

            // Get all members in the class, excluding transferred ones
            $classMembers = $class->members()->where('membership_status', '!=', 'transferred')->pluck('member_id')->toArray();
            $presentMembers = $request->present_members ?? [];

            // Record attendance for each member
            foreach ($classMembers as $memberId) {
                AttendanceRecord::create([
                    'id' => (string) Str::uuid(),
                    'member_id' => $memberId,
                    'class_id' => $class->id,
                    'date' => $request->date,
                    'present' => in_array($memberId, $presentMembers),
                    'notes' => $request->notes,
                    'marked_by' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('sabbath-school.show', $class)
            ->with('success', 'Attendance recorded successfully.');
    }

    public function reports()
    {
        $classes = SabbathSchoolClass::with('attendance')->get();

        $reports = $classes->map(function ($class) {
            $attendanceRecords = $class->attendance;
            $totalSessions = $attendanceRecords->unique('date')->count();
            $averageAttendance = $totalSessions > 0 ? round($attendanceRecords->where('present', true)->count() / $totalSessions, 1) : 0;
            $totalPresentMembers = $attendanceRecords->where('present', true)->count();

            return [
                'class' => $class,
                'total_sessions' => $totalSessions,
                'average_attendance' => $averageAttendance,
                'total_attendance' => $totalPresentMembers, // Corrected from 'present_count'
                'attendance_rate' => ($totalSessions > 0 && $class->members()->where('membership_status', '!=', 'transferred')->count() > 0) ?
                    round(($totalPresentMembers / ($totalSessions * $class->members()->where('membership_status', '!=', 'transferred')->count())) * 100, 1) : 0,
            ];
        });

        return view('sabbath-school.reports', compact('reports'));
    }

    public function assignMembers(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can assign members
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $assignedMembers = $class->members()->where('membership_status', '!=', 'transferred')->get();
        $availableMembers = Member::where('membership_status', '!=', 'transferred')
            ->whereNull('sabbath_school_class_id')
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.assign-members', compact('class', 'assignedMembers', 'availableMembers'));
    }

    public function updateMemberAssignments(Request $request, SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can update assignments
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $validator = Validator::make($request->all(), [
            'member_ids' => 'array',
            'member_ids.*' => 'exists:members,member_id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($request, $class) {
            // Remove all current assignments
            Member::where('sabbath_school_class_id', $class->id)->update(['sabbath_school_class_id' => null]);

            // Add new assignments
            if ($request->member_ids) {
                Member::whereIn('member_id', $request->member_ids)->update(['sabbath_school_class_id' => $class->id]);
            }
        });

        return redirect()->route('sabbath-school.show', $class)
            ->with('success', 'Member assignments updated successfully.');
    }
}
