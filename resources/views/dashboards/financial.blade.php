<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Financial Secretary Dashboard</h1>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage and track church finances</p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Contributions</p>
                        <p class="text-2xl font-bold text-green-600">₦{{ number_format($totalContributions, 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-bold text-blue-600">₦{{ number_format($monthlyContributions, 2) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Categories</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $categories->count() }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Recent Transactions</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $recentContributions->count() }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 20v-5h-5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h5v-5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 4h-5v5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories & Recent Contributions --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Category Totals</h2>
                    <a href="{{ route('finance.categories') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                        Manage Categories
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($categories as $category)
                        <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">{{ $category->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->contributions_count }} contributions</p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-gray-900 dark:text-gray-200">₦{{ number_format($category->contributions_sum_amount, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No categories found</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Contributions</h2>
                    <a href="{{ route('finance.contributions') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                        Record Contributions
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentContributions as $contribution)
                        <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">{{ $contribution->member?->name ?? 'N/A' }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contribution->category?->name ?? 'N/A' }} - {{ $contribution->date->format('M j, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-gray-900 dark:text-gray-200">₦{{ number_format($contribution->amount, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent contributions</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
