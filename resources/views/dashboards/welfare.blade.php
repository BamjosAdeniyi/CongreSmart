<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Welfare Secretary Dashboard</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Support and care for church members</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Cases</p>
                        <p class="text-2xl font-bold text-red-600">{{ $activeCases }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Members Helped</p>
                        <p class="text-2xl font-bold text-green-600">{{ $membersHelped }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Assistance Types</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $assistanceTypes }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $monthlyAssistance }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="#"
                   class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-200">New Case</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create welfare case</p>
                    </div>
                </a>

                <a href="#"
                   class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-200">Provide Aid</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Record assistance</p>
                    </div>
                </a>

                <a href="#"
                   class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-200">View Cases</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage welfare cases</p>
                    </div>
                </a>

                <a href="#"
                   class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-200">Reports</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Welfare reports</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Active Cases --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Active Welfare Cases</h2>
                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                    View All Cases
                </a>
            </div>

            @if($activeCases > 0)
                <div class="space-y-4">
                    {{-- Placeholder for active cases - in real implementation, this would loop through actual cases --}}
                    <div class="border border-red-200 bg-red-50 dark:border-red-900/40 dark:bg-red-900/20 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-200">Medical Assistance Needed</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">John Doe - Hospital bills and medication support</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Created: 2 days ago</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                                Urgent
                            </span>
                        </div>
                    </div>

                    <div class="border border-yellow-200 bg-yellow-50 dark:border-yellow-900/40 dark:bg-yellow-900/20 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-200">Food Support</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Jane Smith - Temporary food assistance</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Created: 1 week ago</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300">
                                Medium
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Active Cases</h3>
                    <p class="text-gray-600 dark:text-gray-400">All welfare cases have been resolved. Great work!</p>
                </div>
            @endif
        </div>

        {{-- Recent Assistance --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Assistance Provided</h2>
                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                    View All
                </a>
            </div>

            <div class="space-y-3">
                {{-- Placeholder for recent assistance records --}}
                <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-200">Medical Support</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">John Doe - Hospital bill assistance</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 dark:text-gray-200">$500.00</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">2 days ago</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-200">Food Basket</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Jane Smith - Monthly food support</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 dark:text-gray-200">$150.00</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">1 week ago</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-200">Utility Assistance</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bob Johnson - Electricity bill help</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 dark:text-gray-200">$200.00</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">2 weeks ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
