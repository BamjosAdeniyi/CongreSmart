<x-app-layout>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; background: white; }
            .bg-white { border: none !important; }
            .rounded-xl { border-radius: 0 !important; }
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
                    <h1 class="text-xl md:text-2xl text-gray-900">Attendance Reports</h1>
                    <p class="text-sm md:text-base text-gray-500">Analyze Sabbath School attendance trends</p>
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
            <h2 class="text-xl">Attendance Summary Report</h2>
            <p class="text-sm text-gray-500">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>
        </div>

        {{-- Classes Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($attendanceStats as $stat)
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">{{ $stat['class']->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $stat['class']->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $stat['class']->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Sessions</span>
                            <span class="font-semibold">{{ $stat['total_sessions'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Avg Attendance</span>
                            <span class="font-semibold">{{ $stat['average_attendance'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Present</span>
                            <span class="font-semibold">{{ $stat['total_present'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Attendance Rate</span>
                            <span class="font-semibold {{ $stat['attendance_rate'] >= 80 ? 'text-green-600' : ($stat['attendance_rate'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $stat['attendance_rate'] }}%
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Coordinator:</span> {{ $stat['class']->coordinator?->first_name }} {{ $stat['class']->coordinator?->last_name }}
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Meeting:</span> {{ ucfirst($stat['class']->meeting_day) }} at {{ $stat['class']->meeting_time }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Recent Attendance Records --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Recent Attendance Records</h2>
                    <button onclick="exportAttendance()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>
            <div class="p-6">
                @if(count($attendanceStats) > 0)
                    <div class="space-y-4">
                        @foreach($attendanceStats as $stat)
                            @if(count($stat['recent_sessions']) > 0)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3">{{ $stat['class']->name }}</h4>
                                    <div class="space-y-2">
                                        @foreach($stat['recent_sessions'] as $session)
                                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                                <div class="flex items-center gap-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $session->date->format('M j, Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $session->present_count }} of {{ $session->total_count }} present
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if(($session->present_count / $session->total_count) >= 0.8) bg-green-100 text-green-800
                                                        @elseif(($session->present_count / $session->total_count) >= 0.6) bg-yellow-100 text-yellow-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                        {{ round(($session->present_count / $session->total_count) * 100) }}%
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No attendance records found</h3>
                        <p class="text-sm">Start taking attendance in Sabbath School classes to see reports here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function exportAttendance() {
            // In a real implementation, this would trigger a download
            alert('Export functionality would generate an attendance report');
        }
    </script>
</x-app-layout>
