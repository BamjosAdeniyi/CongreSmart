<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Sabbath School Coordinator Dashboard</h1>
                <p class="text-sm md:text-base text-gray-500">Manage your Sabbath School classes</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">My Classes</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $myClasses->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Members</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalMembers) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg. Attendance</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($avgAttendance, 1) }}%</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Recent Sessions</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $recentAttendance->count() }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- My Classes --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">My Classes</h2>
                <a href="{{ route('sabbath-school.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    View All Classes
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($myClasses as $class)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $class->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $class->meeting_day }} at {{ $class->meeting_time }}</p>
                            </div>
                            @if($class->active)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Members:</span>
                                <span class="font-medium">{{ $class->members_count }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Location:</span>
                                <span class="font-medium">{{ $class->location ?? 'Not set' }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('sabbath-school.show', $class) }}"
                               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm font-medium text-center transition-colors">
                                View Details
                            </a>
                            <a href="{{ route('sabbath-school.attendance', $class) }}"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium text-center transition-colors">
                                Take Attendance
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Assigned</h3>
                        <p class="text-gray-600">You haven't been assigned as coordinator for any classes yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Attendance --}}
        @if($recentAttendance->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent Attendance</h2>
                <a href="{{ route('reports.attendance') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    View Reports
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentAttendance->take(5) as $record)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $record->member?->first_name }} {{ $record->member?->last_name }}</h4>
                            <p class="text-sm text-gray-600">{{ $record->class?->name }} - {{ $record->date?->format('M j, Y') }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($record->present) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $record->present ? 'Present' : 'Absent' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
