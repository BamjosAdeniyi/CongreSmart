<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaryRecord;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $records = DisciplinaryRecord::with('member')
            ->where('status', 'active')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('disciplinary.index', compact('records'));
    }

    public function create()
    {
        $members = Member::where('membership_status', 'active')->orderBy('first_name')->get();
        return view('disciplinary.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'offense_type' => 'required|string|max:100',
            'offense_description' => 'required|string',
            'discipline_type' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        $record = DisciplinaryRecord::create([
            'discipline_record_id' => (string) Str::uuid(),
            'member_id' => $request->member_id,
            'offense_type' => $request->offense_type,
            'offense_description' => $request->offense_description,
            'discipline_type' => $request->discipline_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'recorded_by' => Auth::id(),
            'status' => 'active',
            'notes' => $request->notes,
        ]);

        return redirect()->route('disciplinary.index')->with('success', 'Disciplinary record created successfully.');
    }

    public function show(DisciplinaryRecord $disciplinary)
    {
        $disciplinary->load('member', 'recorder', 'approver');
        return view('disciplinary.show', ['record' => $disciplinary]);
    }
}
