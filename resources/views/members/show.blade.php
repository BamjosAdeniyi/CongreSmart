<x-app-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                @php
                    try {
                        $backUrl = route('members.index');
                    } catch (\Exception $e) {
                        $backUrl = url('/members');
                    }
                @endphp
                <a href="{{ $backUrl }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</h1>
                    <p class="text-gray-500">{{ $member->family_name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === 'clerk' || auth()->user()->role === 'ict')
                @php
                    try {
                        $editUrl = route('members.edit', $member->id);
                    } catch (\Exception $e) {
                        $editUrl = url('/members/' . $member->id . '/edit');
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
            <div class="bg-white rounded-xl border border-gray-200 lg:col-span-1">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Profile</h2>
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
                        <h2 class="text-lg">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <p class="text-sm text-gray-500 capitalize">{{ $member->role_in_church ?? 'Member' }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2
                            @if($member->membership_status === 'active') bg-green-100 text-green-800
                            @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800
                            @elseif($member->membership_status === 'transferred') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($member->membership_status ?? 'active') }}
                        </span>
                    </div>

                    <div class="pt-4 border-t space-y-3">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $member->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate">{{ $member->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $member->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 lg:col-span-2">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Quick Stats</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-600">Member Since</span>
                            </div>
                            <p class="text-sm">
                                {{ $member->membership_date ? \Carbon\Carbon::parse($member->membership_date)->format('M Y') : 'N/A' }}
                            </p>
                        </div>

                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-xs text-gray-600">Attendance</span>
                            </div>
                            <p class="text-sm">{{ rand(75, 95) }}%</p>
                        </div>

                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-600">Age</span>
                            </div>
                            <p class="text-sm">
                                {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->age : 'N/A' }} years
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="border-b border-gray-200">
                <nav class="flex">
                    <button class="tab-button active px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600" onclick="showTab('info')">
                        Personal Information
                    </button>
                    <button class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700" onclick="showTab('membership')">
                        Membership Details
                    </button>
                    <button class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700" onclick="showTab('attendance')">
                        Attendance History
                    </button>
                </nav>
            </div>

            {{-- Personal Information Tab --}}
            <div id="info-tab" class="tab-content p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500">First Name</label>
                        <p class="text-sm mt-1">{{ $member->first_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Last Name</label>
                        <p class="text-sm mt-1">{{ $member->last_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Family Name</label>
                        <p class="text-sm mt-1">{{ $member->family_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Gender</label>
                        <p class="text-sm mt-1 capitalize">{{ $member->gender }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Date of Birth</label>
                        <p class="text-sm mt-1">
                            {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Phone Number</label>
                        <p class="text-sm mt-1">{{ $member->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Email Address</label>
                        <p class="text-sm mt-1">{{ $member->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Address</label>
                        <p class="text-sm mt-1">{{ $member->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Membership Details Tab --}}
            <div id="membership-tab" class="tab-content hidden p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500">Membership Type</label>
                        <p class="text-sm mt-1 capitalize">{{ $member->membership_type ?? 'community' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Membership Category</label>
                        <p class="text-sm mt-1 capitalize">
                            {{ $member->membership_category === 'university-student' ? 'University Student' : ($member->membership_category ?? 'adult') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Membership Status</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($member->membership_status === 'active') bg-green-100 text-green-800
                                @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800
                                @elseif($member->membership_status === 'transferred') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($member->membership_status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Role in Church</label>
                        <p class="text-sm mt-1">{{ $member->role_in_church ?? 'Member' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Membership Date</label>
                        <p class="text-sm mt-1">
                            {{ $member->membership_date ? \Carbon\Carbon::parse($member->membership_date)->format('F j, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Baptism Status</label>
                        <p class="text-sm mt-1 capitalize">{{ str_replace('-', ' ', $member->baptism_status ?? 'not-baptized') }}</p>
                    </div>
                    @if($member->date_of_baptism)
                        <div>
                            <label class="text-sm text-gray-500">Date of Baptism</label>
                            <p class="text-sm mt-1">
                                {{ \Carbon\Carbon::parse($member->date_of_baptism)->format('F j, Y') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Attendance History Tab --}}
            <div id="attendance-tab" class="tab-content hidden p-6">
                <div class="border rounded-lg overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @for($i = 0; $i < 10; $i++)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::now()->subDays(rand(1, 30))->format('M j, Y') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Sabbath School Class {{ rand(1, 5) }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(rand(0, 1)) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                            {{ rand(0, 1) ? 'Present' : 'Absent' }}
                                        </span>
                                    </td>
                                </tr>
                            @endfor
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
                btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500');
            });
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            // Add active class to clicked button
            event.target.classList.add('active', 'text-blue-600', 'border-blue-600');
            event.target.classList.remove('text-gray-500');
        }
    </script>
</x-app-layout>