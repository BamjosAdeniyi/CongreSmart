<x-app-layout>
    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg p-4" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                @php
                    try {
                        $backUrl = route('members.index');
                    } catch (\Exception $e) {
                        $backUrl = url('/members');
                    }
                @endphp
                <a href="{{ $backUrl }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl text-gray-900 dark:text-gray-100">{{ $member->full_name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400">{{ $member->family_name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === 'clerk' || auth()->user()->role === 'ict')
                @php
                    try {
                        $editUrl = route('members.edit', $member->member_id);
                    } catch (\Exception $e) {
                        $editUrl = url('/members/' . $member->member_id . '/edit');
                    }
                @endphp
                <a href="{{ $editUrl }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Member
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Profile Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 lg:col-span-1">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold dark:text-gray-200">Profile</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-center">
                        <div class="w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>

                    <div class="text-center">
                        <h2 class="text-lg dark:text-gray-200">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $member->role_in_church ?? 'Member' }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2
                            @if($member->membership_status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                            @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @elseif($member->membership_status === 'transferred') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                            {{ ucfirst($member->membership_status ?? 'active') }}
                        </span>
                    </div>

                    <div class="pt-4 border-t dark:border-gray-700 space-y-3">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="dark:text-gray-300">{{ $member->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate dark:text-gray-300">{{ $member->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="dark:text-gray-300">{{ $member->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 lg:col-span-2">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold dark:text-gray-200">Quick Stats</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-600 dark:text-gray-500">Member Since</span>
                            </div>
                            <p class="text-sm text-gray-900 dark:text-gray-600">
                                {{ $member->membership_date ? \Carbon\Carbon::parse($member->membership_date)->format('M Y') : 'N/A' }}
                            </p>
                        </div>

                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-xs text-gray-600 dark:text-gray-500">Attendance</span>
                            </div>
                            <p class="text-sm text-gray-900 dark:text-gray-600">
                                @php
                                    $totalAttendance = $member->attendance->count();
                                    $presentCount = $member->attendance->where('present', true)->count();
                                    $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;
                                @endphp
                                {{ $attendanceRate }}%
                            </p>
                        </div>

                        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-600 dark:text-gray-500">Age</span>
                            </div>
                            <p class="text-sm text-gray-900 dark:text-gray-600">
                                {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->age : 'N/A' }} years
                            </p>
                        </div>

                        <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-600 dark:text-gray-500">Total Contributions</span>
                            </div>
                            <p class="text-sm text-gray-900 dark:text-gray-600">
                                @php
                                    $totalContributions = $member->contributions->sum('amount');
                                @endphp
                                ₦{{ number_format($totalContributions, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex">
                    <button class="tab-button active px-6 py-4 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400" onclick="showTab('info')">
                        Personal Information
                    </button>
                    <button class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" onclick="showTab('membership')">
                        Membership Details
                    </button>
                    <button class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" onclick="showTab('attendance')">
                        Attendance History
                    </button>
                </nav>
            </div>

            {{-- Personal Information Tab --}}
            <div id="info-tab" class="tab-content p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">First Name</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->first_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Last Name</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->last_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Family Name</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->family_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Gender</label>
                        <p class="text-sm mt-1 capitalize dark:text-gray-200">{{ $member->gender }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</label>
                        <p class="text-sm mt-1 dark:text-gray-200">
                            {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Phone Number</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Email Address</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Address</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Membership Details Tab --}}
            <div id="membership-tab" class="tab-content hidden p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Membership Type</label>
                        <p class="text-sm mt-1 capitalize dark:text-gray-200">{{ $member->membership_type ?? 'community' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Membership Category</label>
                        <p class="text-sm mt-1 capitalize dark:text-gray-200">
                            {{ $member->membership_category === 'university-student' ? 'University Student' : ($member->membership_category ?? 'adult') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Membership Status</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($member->membership_status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @elseif($member->membership_status === 'transferred') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300
                                @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                {{ ucfirst($member->membership_status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Role in Church</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->role_in_church ?? 'Member' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Membership Date</label>
                        <p class="text-sm mt-1 dark:text-gray-200">
                            {{ $member->membership_date ? \Carbon\Carbon::parse($member->membership_date)->format('F j, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Baptism Status</label>
                        <p class="text-sm mt-1 capitalize dark:text-gray-200">{{ str_replace('-', ' ', $member->baptism_status ?? 'not-baptized') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">Sabbath School Class</label>
                        <p class="text-sm mt-1 dark:text-gray-200">{{ $member->sabbathClass ? $member->sabbathClass->name : 'Not assigned' }}</p>
                    </div>
                </div>
            </div>

            {{-- Attendance History Tab --}}
            <div id="attendance-tab" class="tab-content hidden p-6">
                <div class="border dark:border-gray-700 rounded-lg overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Class</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($member->attendance ?? [] as $record)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ \Carbon\Carbon::parse($record->date)->format('M j, Y') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $record->sabbathClass ? $record->sabbathClass->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($record->present) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                            {{ $record->present ? 'Present' : 'Absent' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No attendance records found for this member.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'dark:text-blue-400', 'border-blue-600', 'dark:border-blue-400');
                btn.classList.add('text-gray-500', 'dark:text-gray-400');
            });
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            // Add active class to clicked button
            event.target.classList.add('active', 'text-blue-600', 'dark:text-blue-400', 'border-blue-600', 'dark:border-blue-400');
            event.target.classList.remove('text-gray-500', 'dark:text-gray-400');
        }
    </script>
</x-app-layout>
