<x-app-layout>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 1rem;
            }
            main.flex-1 { overflow-y: visible !important; }
            div.flex-1 { overflow: visible !important; }
            .bg-white { border: none !important; box-shadow: none !important; }
            .rounded-xl { border-radius: 0 !important; }
            .shadow-sm { box-shadow: none !important; }
            .p-6 { padding: 0.5rem !important; }
            table { width: 100%; font-size: 10pt; page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tbody { display: table-row-group; }
            th, td { padding: 4px 8px !important; }
            h1, h2, h3, h4 { page-break-after: avoid; }
            .grid { display: block !important; }
            .grid > div { margin-bottom: 1rem; page-break-inside: avoid; }
        }
    </style>

    <div class="space-y-4 md:space-y-6 print-container">
        <div class="flex items-center justify-between no-print">
            <div class="flex items-center gap-4">
                <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Member Reports</h1>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Comprehensive member statistics and information</p>
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
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Members</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_members']) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Members</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['active_members']) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Inactive Members</p>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($stats['inactive_members']) }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Male/Female Ratio</p>
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

        {{-- Additional Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Baptized Members</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($stats['baptized_members']) }}</p>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Not Baptized</p>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['not_baptized_members']) }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Community Members</p>
                        <p class="text-2xl font-bold text-teal-600">{{ number_format($stats['community_members']) }}</p>
                    </div>
                    <div class="p-3 bg-teal-100 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Student Members</p>
                        <p class="text-2xl font-bold text-pink-600">{{ number_format($stats['student_members']) }}</p>
                    </div>
                    <div class="p-3 bg-pink-100 rounded-lg">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Age Distribution --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold mb-4 dark:text-gray-200">Age Distribution</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($stats['by_age_group'] as $ageGroup => $count)
                    <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $ageGroup }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Members Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 no-print">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold dark:text-gray-200">All Members</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Name</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Gender</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Age</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Sabbath School</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Phone</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($members as $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-4 px-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">{{ $member->first_name }} {{ $member->last_name }}</div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600 dark:text-gray-400">{{ ucfirst($member->gender ?? 'N/A') }}</td>
                                    <td class="py-4 px-4 text-gray-600 dark:text-gray-400">
                                        {{ $member->age ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $member->membership_status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300' }}">
                                            {{ ucfirst($member->membership_status ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600 dark:text-gray-400">
                                        {{ $member->sabbathClass?->name ?? 'Not Assigned' }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-600 dark:text-gray-400">{{ $member->phone ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
