<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Financial Reports</h1>
                <p class="text-sm md:text-base text-gray-500">Analyze church income and expenditures</p>
            </div>
            <form method="GET" action="{{ route('finance.reports') }}" class="flex items-center gap-2">
                <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 text-sm">
                <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 text-sm">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">Filter</button>
            </form>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4">Income vs. Expense</h2>
                <canvas id="incomeExpenseChart"></canvas>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4">Category Breakdown</h2>
                <canvas id="categoryBreakdownChart"></canvas>
            </div>
        </div>

        {{-- Financial Summary --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Summary for Period</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-sm font-medium text-green-800">Total Income</p>
                    <p class="text-2xl font-bold text-green-600">₦{{ number_format($chartData['income'], 2) }}</p>
                </div>
                <div class="p-4 bg-red-50 rounded-lg">
                    <p class="text-sm font-medium text-red-800">Total Expense</p>
                    <p class="text-2xl font-bold text-red-600">₦{{ number_format($chartData['expense'], 2) }}</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">Net Balance</p>
                    <p class="text-2xl font-bold text-blue-600">₦{{ number_format($chartData['income'] - $chartData['expense'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Member Totals --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Top Contributions by Member</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4 font-medium">Member</th>
                                <th class="text-right py-3 px-4 font-medium">Total Amount</th>
                                <th class="text-right py-3 px-4 font-medium"># of Contributions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($memberTotals as $total)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-4 px-4">{{ $total['member_name'] ?? 'Unknown Member' }}</td>
                                    <td class="py-4 px-4 text-right font-semibold">₦{{ number_format($total['total'], 2) }}</td>
                                    <td class="py-4 px-4 text-right">{{ $total['count'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-8 text-gray-500">No contributions found for this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartData = @json($chartData);

            // Income vs Expense Chart
            const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
            new Chart(incomeExpenseCtx, {
                type: 'bar',
                data: {
                    labels: ['Income', 'Expense'],
                    datasets: [{
                        label: 'Amount (₦)',
                        data: [chartData.income, chartData.expense],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.2)',
                            'rgba(239, 68, 68, 0.2)'
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Category Breakdown Chart
            const categoryCtx = document.getElementById('categoryBreakdownChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: chartData.category_breakdown.map(c => c.name),
                    datasets: [{
                        label: 'Contribution by Category',
                        data: chartData.category_breakdown.map(c => c.total),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.5)',
                            'rgba(16, 185, 129, 0.5)',
                            'rgba(239, 68, 68, 0.5)',
                            'rgba(245, 158, 11, 0.5)',
                            'rgba(139, 92, 246, 0.5)',
                            'rgba(236, 72, 153, 0.5)',
                        ],
                        hoverOffset: 4
                    }]
                }
            });
        });
    </script>
</x-app-layout>
