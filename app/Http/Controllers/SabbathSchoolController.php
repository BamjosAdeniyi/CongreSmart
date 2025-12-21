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
        $classes = SabbathSchoolClass::with(['coordinator', 'members'])
            ->withCount('members')
            ->orderBy('name')
            ->get();

        $totalMembers = Member::count();
        $totalAttendance = AttendanceRecord::whereDate('date', today())->count();

        return view('sabbath-school.index', compact('classes', 'totalMembers', 'totalAttendance'));
    }

    public function create()
    {
        $teachers = Member::where('role_in_church', 'teacher')
            ->orWhere('role_in_church', 'superintendent')
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:members,id',
            'meeting_day' => 'required|in:saturday,sunday',
            'meeting_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
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
                'meeting_day' => $request->meeting_day,
                'meeting_time' => $request->meeting_time,
                'location' => $request->location,
                'active' => true,
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class created successfully.');
    }

    public function show(SabbathSchoolClass $class)
    {
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
        $teachers = Member::where('role_in_church', 'teacher')
            ->orWhere('role_in_church', 'superintendent')
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, SabbathSchoolClass $class)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_id' => 'required|exists:members,id',
            'meeting_day' => 'required|in:saturday,sunday',
            'meeting_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
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
                'meeting_day' => $request->meeting_day,
                'meeting_time' => $request->meeting_time,
                'location' => $request->location,
                'active' => $request->has('active'),
                'updated_by' => Auth::id(),
            ]);
        });

        return redirect()->route('sabbath-school.index')
            ->with('success', 'Sabbath School class updated successfully.');
    }

    public function destroy(SabbathSchoolClass $class)
    {
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
        $assignedMembers = $class->members()->pluck('id')->toArray();
        $availableMembers = Member::whereNotIn('id', $assignedMembers)
            ->orderBy('first_name')
            ->get();

        return view('sabbath-school.assign-members', compact('class', 'assignedMembers', 'availableMembers'));
    }

    public function updateMemberAssignments(Request $request, SabbathSchoolClass $class)
    {
        $validator = Validator::make($request->all(), [
            'member_ids' => 'array',
            'member_ids.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($request, $class) {
            // Remove all current assignments
            $class->members()->detach();

            // Add new assignments
            if ($request->member_ids) {
                $class->members()->attach($request->member_ids, [
                    'assigned_at' => now(),
                    'assigned_by' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('sabbath-school.show', $class)
            ->with('success', 'Member assignments updated successfully.');
    }
}