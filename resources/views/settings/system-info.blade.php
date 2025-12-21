<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('settings.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">System Information</h1>
                <p class="text-gray-600">Technical details about your CongreSmart installation</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- PHP Information --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    PHP Information
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Version:</span>
                        <span class="font-medium">{{ $systemInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Memory Limit:</span>
                        <span class="font-medium">{{ ini_get('memory_limit') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Max Execution Time:</span>
                        <span class="font-medium">{{ ini_get('max_execution_time') }}s</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Upload Max Size:</span>
                        <span class="font-medium">{{ ini_get('upload_max_filesize') }}</span>
                    </div>
                </div>
            </div>

            {{-- Laravel Information --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Laravel Information
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Version:</span>
                        <span class="font-medium">{{ $systemInfo['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Environment:</span>
                        <span class="font-medium">{{ ucfirst($systemInfo['environment']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Timezone:</span>
                        <span class="font-medium">{{ $systemInfo['timezone'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Debug Mode:</span>
                        <span class="font-medium">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                </div>
            </div>

            {{-- Database Information --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                    </svg>
                    Database Information
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Connection:</span>
                        <span class="font-medium">{{ ucfirst($systemInfo['database_connection']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Host:</span>
                        <span class="font-medium">{{ config('database.connections.mysql.host') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Database:</span>
                        <span class="font-medium">{{ config('database.connections.mysql.database') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Charset:</span>
                        <span class="font-medium">{{ config('database.connections.mysql.charset') }}</span>
                    </div>
                </div>
            </div>

            {{-- Cache & Session --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                    Cache & Session
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cache Driver:</span>
                        <span class="font-medium">{{ ucfirst($systemInfo['cache_driver']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Session Driver:</span>
                        <span class="font-medium">{{ ucfirst($systemInfo['session_driver']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Session Lifetime:</span>
                        <span class="font-medium">{{ config('session.lifetime') }} minutes</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Queue Driver:</span>
                        <span class="font-medium">{{ config('queue.default') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Server Information --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
                Server Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Server Software:</span>
                        <span class="font-medium">{{ $systemInfo['server_software'] ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Server OS:</span>
                        <span class="font-medium">{{ PHP_OS }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Server Time:</span>
                        <span class="font-medium">{{ now()->format('M j, Y H:i:s T') }}</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Peak Memory:</span>
                        <span class="font-medium">{{ round(memory_get_peak_usage() / 1024 / 1024, 2) }} MB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Current Memory:</span>
                        <span class="font-medium">{{ round(memory_get_usage() / 1024 / 1024, 2) }} MB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Uptime:</span>
                        <span class="font-medium">{{ round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }}s</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- System Health --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">System Health</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-2">✓</div>
                    <div class="text-sm font-medium text-gray-900">Database</div>
                    <div class="text-xs text-gray-600">Connected</div>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-2">✓</div>
                    <div class="text-sm font-medium text-gray-900">Cache</div>
                    <div class="text-xs text-gray-600">Working</div>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-2">✓</div>
                    <div class="text-sm font-medium text-gray-900">Sessions</div>
                    <div class="text-xs text-gray-600">Active</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>