<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Financial Reports</h1>
                <p class="text-sm md:text-base text-gray-500">View financial summaries and reports</p>
            </div>
            <div class="flex gap-2">
                <button onclick="exportReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Income</p>
                        <p class="text-2xl font-bold text-green-600">₦{{ number_format($summary['total_income'] ?? 0, 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-600">₦{{ number_format($summary['total_expenses'] ?? 0, 2) }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Net Balance</p>
                        <p class="text-2xl font-bold {{ ($summary['net_balance'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ₦{{ number_format(abs($summary['net_balance'] ?? 0), 2) }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">This Month</p>
                        <p class="text-2xl font-bold text-gray-900">₦{{ number_format($summary['this_month'] ?? 0, 2) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Income vs Expenses Chart --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Income vs Expenses</h3>
                <div class="h-64 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p>Chart visualization would go here</p>
                        <p class="text-sm mt-1">Income: ₦{{ number_format($summary['total_income'] ?? 0, 2) }}</p>
                        <p class="text-sm">Expenses: ₦{{ number_format($summary['total_expenses'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Category Breakdown --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Category Breakdown</h3>
                <div class="space-y-3">
                    @forelse($categoryBreakdown ?? [] as $category)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full {{ $category['type'] === 'income' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <span class="text-sm font-medium">{{ $category['name'] }}</span>
                            </div>
                            <span class="text-sm font-semibold">₦{{ number_format($category['total'], 2) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No contributions found</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Recent Transactions</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentTransactions ?? [] as $transaction)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="p-2 rounded-lg {{ $transaction['category_type'] === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <svg class="w-5 h-5 {{ $transaction['category_type'] === 'income' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ $transaction['member_name'] }}</h4>
                                    <p class="text-sm text-gray-600">{{ $transaction['category_name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction['date'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold {{ $transaction['category_type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction['category_type'] === 'income' ? '+' : '-' }}₦{{ number_format($transaction['amount'], 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p>No recent transactions found.</p>
                        </div>
                    @endforelse
                </div>
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