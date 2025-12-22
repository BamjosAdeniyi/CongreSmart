<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Member Reports</h1>
                <p class="text-sm md:text-base text-gray-500">Comprehensive member statistics and information</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Members</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_members']) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Members</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['active_members']) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Inactive Members</p>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($stats['inactive_members']) }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Male/Female Ratio</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['by_gender']['male'] }}/{{ $stats['by_gender']['female'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Age Distribution --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Age Distribution</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($stats['by_age_group'] as $ageGroup => $count)
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $count }}</div>
                        <div class="text-sm text-gray-600">{{ $ageGroup }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Members Table --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">All Members</h2>
                    <button onclick="exportMembers()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Name</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Gender</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Age</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Sabbath School</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Phone</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($members as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">{{ ucfirst($member->gender ?? 'N/A') }}</td>
                                    <td class="py-4 px-4 text-gray-600">
                                        {{ $member->date_of_birth ? max(0, now()->diffInYears($member->date_of_birth)) : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $member->membership_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($member->membership_status ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">
                                        {{ $member->sabbathClass?->name ?? 'Not Assigned' }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">{{ $member->phone ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportMembers() {
            // In a real implementation, this would trigger a download
            alert('Export functionality would generate a member report');
        }
    </script>
</x-app-layout>