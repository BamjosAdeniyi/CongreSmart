<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Finance Management</h1>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage contributions, categories, and financial reports</p>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                try {
                    $contributionsUrl = route('finance.contributions');
                } catch (\Exception $e) {
                    $contributionsUrl = url('/finance/contributions');
                }
                try {
                    $categoriesUrl = route('finance.categories');
                } catch (\Exception $e) {
                    $categoriesUrl = url('/finance/categories');
                }
                try {
                    $reportsUrl = route('finance.reports');
                } catch (\Exception $e) {
                    $reportsUrl = url('/finance/reports');
                }
            @endphp

            <a href="{{ $contributionsUrl }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold dark:text-gray-200">Record Contributions</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Enter member contributions</p>
                    </div>
                </div>
            </a>

            <a href="{{ $categoriesUrl }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold dark:text-gray-200">Financial Categories</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage contribution types</p>
                    </div>
                </div>
            </a>

            <a href="{{ $reportsUrl }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold dark:text-gray-200">Financial Reports</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View income and expense reports</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Recent Contributions --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold dark:text-gray-200">Recent Contributions</h2>
            </div>
            <div class="p-6">
                @if($recentContributions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-3 px-4 font-medium dark:text-gray-300">Date</th>
                                    <th class="text-left py-3 px-4 font-medium dark:text-gray-300">Member</th>
                                    <th class="text-left py-3 px-4 font-medium dark:text-gray-300">Category</th>
                                    <th class="text-right py-3 px-4 font-medium dark:text-gray-300">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentContributions as $contribution)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-4 px-4 dark:text-gray-300">{{ $contribution->date->format('M j, Y') }}</td>
                                        <td class="py-4 px-4 dark:text-gray-300">{{ $contribution->member?->first_name }} {{ $contribution->member?->last_name }}</td>
                                        <td class="py-4 px-4 dark:text-gray-300">{{ $contribution->category?->name ?? 'N/A' }}</td>
                                        <td class="py-4 px-4 text-right font-semibold dark:text-gray-200">₦{{ number_format($contribution->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>No contributions recorded yet.</p>
                        <p class="text-sm mt-1">Start by <a href="{{ $contributionsUrl }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">recording contributions</a>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
