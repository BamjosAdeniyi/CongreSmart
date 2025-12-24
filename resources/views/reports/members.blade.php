<x-app-layout>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; background: white; }
            .bg-white { border: none !important; }
            .rounded-xl { border-radius: 0 !important; }
            .shadow-sm { shadow: none !important; }
            .p-6 { padding: 0.5rem !important; }
            table { font-size: 10pt; }
            th, td { padding: 4px 8px !important; }
            h1 { font-size: 18pt; margin-bottom: 0.5rem; }
            .grid { display: block !important; }
            .grid > div { margin-bottom: 1rem; page-break-inside: avoid; }
        }
    </style>

    <div class="space-y-4 md:space-y-6">
        <div class="flex items-center justify-between no-print">
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
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4" />
                </svg>
                Print Report
            </button>
        </div>

        <div class="hidden print:block text-center border-b pb-4 mb-6">
            <h1 class="text-2xl font-bold">CongreSmart Church Management</h1>
            <h2 class="text-xl">Member Status Report</h2>
            <p class="text-sm text-gray-500">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>
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
            <div class="p-6 border-b border-gray-200 no-print">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">All Members</h2>
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
                                        {{ $member->age ?? 'N/A' }}
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

</x-app-layout>
