<?php

namespace App\Http\Controllers;

use App\Models\SabbathSchoolClass;
use App\Models\Member;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SabbathSchoolController extends Controller
{
    public function index()
    {
        $query = SabbathSchoolClass::with(['coordinator', 'members'])
            ->withCount('members');

        // If user is coordinator, only show their class
        if (Auth::user()->role === 'coordinator') {
            $query->where('coordinator_id', Auth::id());
        }

        $classes = $query->orderBy('name')->get();

        $totalMembers = Member::count();
        $totalAttendance = AttendanceRecord::whereDate('date', today())->count();

        // Get coordinators for modal (only for superintendent)
        $coordinators = [];
        if (Auth::user()->role === 'superintendent') {
            $coordinators = \App\Models\User::where('role', 'coordinator')
                ->where('active', true)
                ->orderBy('name')
                ->get();
        }

        return view('sabbath-school.index', compact('classes', 'totalMembers', 'totalAttendance', 'coordinators'));
    }

    public function create()
    {
        // Only superintendent can create classes
        if (Auth::user()->role !== 'superintendent') {
            abort(403, 'Unauthorized');
        }

        $coordinators = \App\Models\User::where('role', 'coordinator')
            ->where('active', true)
            ->orderBy('name')
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
            SabbathSchoolClass::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'coordinator_id' => $request->coordinator_id,
                'active' => true,
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class created successfully.');
    }

    public function show(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can view
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $class->load(['coordinator', 'members', 'attendance']);

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
            abort(403, 'Unauthorized');
        }

        $coordinators = \App\Models\User::where('role', 'coordinator')
            ->where('active', true)
            ->orderBy('name')
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
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class updated successfully.');
    }

    public function destroy(SabbathSchoolClass $class)
    {
        // Only superintendent can delete classes
        if (Auth::user()->role !== 'superintendent') {
            abort(403, 'Unauthorized');
        }

        // Check if class has members
        if ($class->members()->count() > 0) {
            return back()->with('error', 'Cannot delete class with active members. Please remove all members first.');
        }

        $class->delete();

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class deleted successfully.');
    }

    public function attendance(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can take attendance
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $members = $class->members()->orderBy('first_name')->get();
        $today = today();

        // Check if attendance already taken today
        $existingAttendance = AttendanceRecord::where('class_id', $class->id)
            ->whereDate('date', $today)
            ->first();

        return view('sabbath-school.attendance', compact('class', 'members', 'existingAttendance'));
    }

    public function storeAttendance(Request $request, SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can store attendance
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'present_members' => 'required|array',
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

            // Get all members in the class
            $classMembers = $class->members()->pluck('member_id')->toArray();

            // Record attendance for each member
            foreach ($classMembers as $memberId) {
                AttendanceRecord::create([
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'member_id' => $memberId,
                    'class_id' => $class->id,
                    'date' => $request->date,
                    'present' => in_array($memberId, $request->present_members),
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
            $totalSessions = $attendanceRecords->distinct('date')->count();
            $averageAttendance = $totalSessions > 0 ? round($attendanceRecords->where('present', true)->count() / $totalSessions, 1) : 0;
            $totalAttendance = $attendanceRecords->sum('present_count');

            return [
                'class' => $class,
                'total_sessions' => $totalSessions,
                'average_attendance' => $averageAttendance,
                'total_attendance' => $totalAttendance,
                'attendance_rate' => $totalSessions > 0 ? round(($totalAttendance / ($totalSessions * $class->members()->count())) * 100, 1) : 0,
            ];
        });

        return view('sabbath-school.reports', compact('reports'));
    }

    public function assignMembers(SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can assign members
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $assignedMembers = $class->members;
        $availableMembers = Member::where('sabbath_school_class_id', '!=', $class->id)
            ->orWhereNull('sabbath_school_class_id')
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.assign-members', compact('class', 'assignedMembers', 'availableMembers'));
    }

    public function updateMemberAssignments(Request $request, SabbathSchoolClass $class)
    {
        // Only superintendent or the class coordinator can update assignments
        if (Auth::user()->role !== 'superintendent' && $class->coordinator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'member_ids' => 'array',
            'member_ids.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($request, $class) {
            // Remove all current assignments
            Member::where('sabbath_school_class_id', $class->id)->update(['sabbath_school_class_id' => null]);

            // Add new assignments
            if ($request->member_ids) {
                Member::whereIn('id', $request->member_ids)->update(['sabbath_school_class_id' => $class->id]);
            }
        });

        return redirect()->route('sabbath-school.show', $class)
            ->with('success', 'Member assignments updated successfully.');
    }
}