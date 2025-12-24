<x-app-layout>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 1rem;
            }
            main.flex-1 { overflow-y: visible !important; }
            div.flex-1 { overflow: visible !important; }
            .bg-white { border: none !important; box-shadow: none !important; }
            .rounded-xl { border-radius: 0 !important; }
            .p-6 { padding: 0.5rem !important; }
            table { width: 100%; font-size: 10pt; page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tbody { display: table-row-group; }
            th, td { padding: 4px 8px !important; }
            h1, h2, h3, h4 { page-break-after: avoid; }
            .grid { display: block !important; }
            .grid > div { margin-bottom: 1rem; page-break-inside: avoid; }
        }
    </style>

    <div class="space-y-4 md:space-y-6 print-container">
        <div class="flex items-center justify-between no-print">
            <div class="flex items-center gap-4">
                <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl text-gray-900">Financial Reports</h1>
                    <p class="text-sm md:text-base text-gray-500">Track church income and expenditures</p>
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
            <h2 class="text-xl">Financial Summary Report</h2>
            <p class="text-sm text-gray-500">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>
        </div>

        {{-- Financial Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Income</p>
                        <p class="text-2xl font-bold text-green-600">₦{{ number_format($financialStats['total_income'], 2) }}</p>
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
                        <p class="text-2xl font-bold text-red-600">₦{{ number_format($financialStats['total_expenses'], 2) }}</p>
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
                        <p class="text-2xl font-bold {{ $financialStats['net_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ₦{{ number_format(abs($financialStats['net_balance']), 2) }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">This Month</p>
                        <p class="text-2xl font-bold text-purple-600">₦{{ number_format($financialStats['this_month_income'], 2) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Category Breakdown --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Category Breakdown</h2>
            @if(count($categoryBreakdown) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categoryBreakdown as $category)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full {{ $category['type'] === 'income' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <div>
                                    <div class="font-medium">{{ $category['name'] }}</div>
                                    <div class="text-sm text-gray-600">{{ ucfirst($category['type']) }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">₦{{ number_format($category['total'], 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <p>No financial data available</p>
                    <p class="text-sm mt-1">Start recording contributions to see financial reports.</p>
                </div>
            @endif
        </div>

        {{-- Recent Contributions --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200 no-print">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Recent Contributions</h2>
                </div>
            </div>
            <div class="p-6">
                @if(count($contributions) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-medium text-gray-900">Date</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-900">Member</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-900">Category</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-900">Type</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-900">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($contributions as $contribution)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-4 text-gray-600">
                                            {{ $contribution->date?->format('M j, Y') ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="font-medium text-gray-900">
                                                {{ $contribution->member?->first_name }} {{ $contribution->member?->last_name }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-600">
                                            {{ $contribution->category?->name }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $contribution->category?->category_type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($contribution->category?->category_type ?? 'unknown') }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-right font-semibold">
                                            ₦{{ number_format($contribution->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-500 py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No contributions found</h3>
                        <p class="text-sm">Start recording contributions in the Finance section to see financial reports.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
