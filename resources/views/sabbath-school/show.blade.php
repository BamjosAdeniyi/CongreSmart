<x-app-layout>
    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('sabbath-school.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $class->name }}</h1>
                    <p class="text-gray-600">{{ $class->description }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('sabbath-school.edit', $class) }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    Edit Class
                </a>
                <a href="{{ route('sabbath-school.assign-members', $class) }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Assign Members
                </a>
                <a href="{{ route('sabbath-school.attendance', $class) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Take Attendance
                </a>
            </div>
        </div>

        {{-- Class Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Coordinator</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $class->coordinator?->first_name }} {{ $class->coordinator?->last_name }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Members</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $class->members->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-600">Meeting Time</p>
                        <p class="text-lg font-semibold text-gray-900">{{ ucfirst($class->meeting_day) }}</p>
                        <p class="text-sm text-gray-600">{{ $class->meeting_time }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Attendance</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $attendanceStats['average_attendance'] }}</p>
                        <p class="text-sm text-gray-600">per session</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Members List --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Class Members</h2>
                        <a href="{{ route('sabbath-school.assign-members', $class) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Manage Members
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($class->members->count() > 0)
                        <div class="space-y-3">
                            @foreach($class->members as $member)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $member->phone ?? 'No phone' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($member->membership_status === 'active') bg-green-100 text-green-800
                                            @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($member->membership_status ?? 'unknown') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p>No members assigned to this class yet.</p>
                            <p class="text-sm mt-1">Assign members to get started.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Attendance --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Recent Attendance</h2>
                        <a href="{{ route('sabbath-school.attendance', $class) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Take Attendance
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($class->attendance->count() > 0)
                        <div class="space-y-3">
                            @php
                                $attendanceByDate = $class->attendance->groupBy(function($record) {
                                    return $record->date->format('Y-m-d');
                                })->sortKeysDesc()->take(10);
                            @endphp
                            @foreach($attendanceByDate as $date => $records)
                                @php
                                    $totalMembers = $class->members->count();
                                    $presentCount = $records->where('present', true)->count();
                                @endphp
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-medium">{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</h4>
                                        <p class="text-sm text-gray-600">{{ $presentCount }} of {{ $totalMembers }} present</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($totalMembers > 0 && ($presentCount / $totalMembers) >= 0.8) bg-green-100 text-green-800
                                            @elseif($totalMembers > 0 && ($presentCount / $totalMembers) >= 0.6) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $totalMembers > 0 ? round(($presentCount / $totalMembers) * 100) : 0 }}%
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p>No attendance records yet.</p>
                            <p class="text-sm mt-1">Start taking attendance for this class.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Location Info --}}
        @if($class->location)
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4">Location</h2>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-gray-900">{{ $class->location }}</span>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
