<x-app-layout>
    <h1 class="text-2xl font-bold">Pastor Dashboard</h1>
    @extends('layouts.app')

    @section('content')
    <div class="container mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded shadow">
        <h3 class="text-sm text-gray-500">Total Members</h3>
        <div class="mt-2 text-3xl font-semibold">{{ number_format($totalMembers) }}</div>
        </div>

        <div class="bg-white p-6 rounded shadow">
        <h3 class="text-sm text-gray-500">Avg. Attendance</h3>
        <div class="mt-2 text-3xl font-semibold">{{ $attendancePercent }}%</div>
        </div>

        <div class="bg-white p-6 rounded shadow">
        <h3 class="text-sm text-gray-500">Monthly Income</h3>
        <div class="mt-2 text-3xl font-semibold">₦{{ number_format($monthlyIncome) }}</div>
        </div>
    </div>

    {{-- Alerts --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow">
        <h4 class="font-semibold">3 Consecutive Absences</h4>
        @if ($alerts['three_consecutive_absence']->isEmpty())
            <p class="text-sm text-gray-500 mt-2">None</p>
        @else
            <ul class="mt-2">
            @foreach ($alerts['three_consecutive_absence'] as $m)
                <li>{{ $m->first_name }} {{ $m->last_name }}</li>
            @endforeach
            </ul>
        @endif
        </div>

        <div class="bg-white p-4 rounded shadow">
        <h4 class="font-semibold">Upcoming Birthdays (7 days)</h4>
        @if ($alerts['upcoming_birthdays']->isEmpty())
            <p class="text-sm text-gray-500 mt-2">None</p>
        @else
            <ul class="mt-2">
            @foreach ($alerts['upcoming_birthdays'] as $m)
                <li>{{ $m->first_name }} {{ $m->last_name }} — {{ \Carbon\Carbon::parse($m->date_of_birth)->format('M j') }}</li>
            @endforeach
            </ul>
        @endif
        </div>
    </div>

    {{-- Put charts here (Chart.js or other) --}}
    </div>
    @endsection

</x-app-layout>
