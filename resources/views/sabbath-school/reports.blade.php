<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Sabbath School Reports</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Attendance and performance reports</p>
            </div>
            <button onclick="exportReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Report
            </button>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Classes</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $reports->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sessions</p>
                        <p class="text-2xl font-bold text-green-600">{{ $reports->sum('total_sessions') }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Attendance</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $reports->count() > 0 ? round($reports->avg('average_attendance'), 1) : 0 }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Attendance Rate</p>
                        <p class="text-2xl font-bold text-orange-600">
                            {{ $reports->count() > 0 ? round($reports->avg('attendance_rate'), 1) : 0 }}%
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reports Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold dark:text-gray-200">Class Performance</h2>
            </div>
            <div class="p-6">
                @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                    <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Class Name</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Coordinator</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Sessions</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Avg Attendance</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Total Attendance</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Attendance Rate</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-900 dark:text-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-4 px-4">
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-gray-200">{{ $report['class']->name }}</div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $report['class']->meeting_day }} {{ $report['class']->meeting_time }}</div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $report['class']->coordinator?->first_name }} {{ $report['class']->coordinator?->last_name }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                {{ $report['total_sessions'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="font-medium dark:text-gray-200">{{ $report['average_attendance'] }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="font-medium dark:text-gray-200">{{ $report['total_attendance'] }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($report['attendance_rate'] >= 80) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                                @elseif($report['attendance_rate'] >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                                {{ $report['attendance_rate'] }}%
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($report['class']->active) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                                {{ $report['class']->active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-500 dark:text-gray-400 py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No reports available</h3>
                        <p class="text-sm">Create Sabbath School classes and start taking attendance to see reports.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function exportReport() {
            // In a real implementation, this would trigger a download
            alert('Export functionality would be implemented here');
        }
    </script>
</x-app-layout>
