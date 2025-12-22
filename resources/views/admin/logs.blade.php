<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">System Logs</h1>
                <p class="text-sm md:text-base text-gray-500">Monitor system activity and troubleshoot issues</p>
            </div>
            <button onclick="refreshLogs()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
            </button>
        </div>

        {{-- Log Filters --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="logLevel" class="block text-sm font-medium text-gray-700 mb-2">Log Level</label>
                    <select id="logLevel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Levels</option>
                        <option value="emergency">Emergency</option>
                        <option value="alert">Alert</option>
                        <option value="critical">Critical</option>
                        <option value="error">Error</option>
                        <option value="warning">Warning</option>
                        <option value="notice">Notice</option>
                        <option value="info">Info</option>
                        <option value="debug">Debug</option>
                    </select>
                </div>
                <div>
                    <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" id="dateFrom" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" id="dateTo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-end">
                    <button onclick="filterLogs()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- Logs Display --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Logs</h2>
            </div>
            <div id="logsContainer" class="max-h-96 overflow-y-auto">
                <div class="divide-y divide-gray-200">
                    @php
                        $logFiles = glob(storage_path('logs/*.log'));
                        $logs = [];

                        if (!empty($logFiles)) {
                            $latestLogFile = end($logFiles);
                            if (file_exists($latestLogFile)) {
                                $logContent = file_get_contents($latestLogFile);
                                $logLines = array_reverse(explode("\n", trim($logContent)));
                                $logs = array_slice($logLines, 0, 50); // Show last 50 entries
                            }
                        }
                    @endphp

                    @forelse($logs as $log)
                        @php
                            // Parse log line (Laravel log format)
                            preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $log, $matches);
                            if ($matches) {
                                $timestamp = $matches[1];
                                $environment = $matches[2];
                                $level = $matches[3];
                                $message = $matches[4];
                            } else {
                                $timestamp = 'Unknown';
                                $level = 'unknown';
                                $message = $log;
                            }
                        @endphp
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(strtolower($level) === 'error') bg-red-100 text-red-800
                                            @elseif(strtolower($level) === 'warning') bg-yellow-100 text-yellow-800
                                            @elseif(strtolower($level) === 'info') bg-blue-100 text-blue-800
                                            @elseif(strtolower($level) === 'debug') bg-gray-100 text-gray-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ strtoupper($level) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $timestamp }}</span>
                                    </div>
                                    <p class="text-sm text-gray-900">{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No logs found</h3>
                            <p class="text-sm">System logs will appear here when available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Log Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Logs</p>
                        <p class="text-2xl font-bold text-blue-600">{{ count($logs) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Errors</p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ count(array_filter($logs, function($log) { return stripos($log, '.ERROR:') !== false; })) }}
                        </p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Warnings</p>
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ count(array_filter($logs, function($log) { return stripos($log, '.WARNING:') !== false; })) }}
                        </p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Info</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ count(array_filter($logs, function($log) { return stripos($log, '.INFO:') !== false; })) }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshLogs() {
            location.reload();
        }

        function filterLogs() {
            // Basic filtering - in a real implementation, this would use AJAX
            const level = document.getElementById('logLevel').value.toLowerCase();
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            const logEntries = document.querySelectorAll('#logsContainer > div > div');

            logEntries.forEach(entry => {
                let show = true;

                if (level) {
                    const entryLevel = entry.querySelector('.inline-flex').textContent.toLowerCase();
                    if (!entryLevel.includes(level)) {
                        show = false;
                    }
                }

                if (dateFrom || dateTo) {
                    const entryDate = entry.querySelector('.text-gray-500').textContent.split(' ')[0];
                    if (dateFrom && entryDate < dateFrom) show = false;
                    if (dateTo && entryDate > dateTo) show = false;
                }

                entry.style.display = show ? 'block' : 'none';
            });
        }
    </script>
</x-app-layout>