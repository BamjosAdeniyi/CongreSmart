<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Pastor Dashboard</h1>
            <p class="text-gray-500">Overview of church activities and statistics</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Members --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Total Members</h3>
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="px-6 pb-6">
                    <div class="text-2xl font-semibold">{{ number_format($totalMembers ?? 156) }}</div>
                    <p class="text-xs text-gray-500 mt-1">+3 this month</p>
                </div>
            </div>

            {{-- Average Attendance --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Avg. Attendance</h3>
                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="px-6 pb-6">
                    <div class="text-2xl font-semibold">{{ $attendancePercent ?? 88 }}%</div>
                    <p class="text-xs text-gray-500 mt-1">+5% from last month</p>
                </div>
            </div>

            {{-- Monthly Income --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Monthly Income</h3>
                    <svg class="h-4 w-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="px-6 pb-6">
                    <div class="text-2xl font-semibold">₦{{ number_format($monthlyIncome ?? 31000) }}</div>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->format('F Y') }}</p>
                </div>
            </div>

            {{-- Alerts --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Alerts</h3>
                    <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="px-6 pb-6">
                    <div class="text-2xl font-semibold">{{ ($alerts['three_consecutive_absence']->count() ?? 0) + ($alerts['upcoming_birthdays']->count() ?? 0) }}</div>
                    <p class="text-xs text-gray-500 mt-1">Requires attention</p>
                </div>
            </div>
        </div>

        {{-- Charts and Widgets --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Attendance Trend Chart --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6">
                    <h3 class="text-lg font-semibold">Attendance Trend</h3>
                </div>
                <div class="px-6 pb-6">
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <p class="text-sm">Chart will be implemented with Chart.js</p>
                    </div>
                </div>
            </div>

            {{-- Financial Breakdown --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6">
                    <h3 class="text-lg font-semibold">Financial Breakdown</h3>
                </div>
                <div class="px-6 pb-6">
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <p class="text-sm">Chart will be implemented with Chart.js</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alerts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Alerts --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6">
                    <h3 class="text-lg font-semibold">Recent Alerts</h3>
                </div>
                <div class="px-6 pb-6">
                    <div class="space-y-4">
                        @if(isset($alerts['three_consecutive_absence']) && $alerts['three_consecutive_absence']->isNotEmpty())
                            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">{{ $alerts['three_consecutive_absence']->count() }} members absent for 3+ weeks</p>
                                    <p class="text-xs text-gray-500">Requires pastoral visit</p>
                                </div>
                            </div>
                        @endif
                        @if(isset($alerts['upcoming_birthdays']) && $alerts['upcoming_birthdays']->isNotEmpty())
                            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">{{ $alerts['upcoming_birthdays']->count() }} upcoming birthdays this week</p>
                                    <p class="text-xs text-gray-500">Consider celebration</p>
                                </div>
                            </div>
                        @endif
                        @if((!isset($alerts['three_consecutive_absence']) || $alerts['three_consecutive_absence']->isEmpty()) && (!isset($alerts['upcoming_birthdays']) || $alerts['upcoming_birthdays']->isEmpty()))
                            <p class="text-sm text-gray-500">No alerts at this time</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl border border-gray-200 flex flex-col gap-6">
                <div class="px-6 pt-6">
                    <h3 class="text-lg font-semibold">Quick Actions</h3>
                </div>
                <div class="px-6 pb-6">
                    <div class="space-y-2">
                        @php
                            try {
                                $reportsUrl = route('reports.index');
                            } catch (\Exception $e) {
                                $reportsUrl = url('/reports');
                            }
                            try {
                                $membersUrl = route('members.index');
                            } catch (\Exception $e) {
                                $membersUrl = url('/members');
                            }
                        @endphp
                        <a href="{{ $reportsUrl }}" class="w-full text-left p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors block">
                            <p class="text-sm font-medium">View Financial Reports</p>
                            <p class="text-xs text-gray-500">See detailed income and expenses</p>
                        </a>
                        <a href="{{ $membersUrl }}" class="w-full text-left p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors block">
                            <p class="text-sm font-medium">Member Directory</p>
                            <p class="text-xs text-gray-500">Access complete member list</p>
                        </a>
                        <a href="{{ $reportsUrl }}" class="w-full text-left p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors block">
                            <p class="text-sm font-medium">Attendance Reports</p>
                            <p class="text-xs text-gray-500">View detailed attendance statistics</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
