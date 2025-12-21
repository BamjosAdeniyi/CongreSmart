<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div>
            <h1 class="text-xl md:text-2xl text-gray-900">Record Contributions</h1>
            <p class="text-sm md:text-base text-gray-500">Enter member contributions by category</p>
        </div>

        <form method="POST" action="{{ route('finance.contributions.store') }}" class="space-y-6">
            @csrf

            {{-- Contribution Details --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Contribution Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="date" class="text-sm font-medium">Date <span class="text-red-500">*</span></label>
                            <input
                                id="date"
                                name="date"
                                type="date"
                                value="{{ old('date', date('Y-m-d')) }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('date')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Grand Total</label>
                            <div class="flex items-center gap-2 p-2 bg-green-50 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-lg" id="grand-total">₦0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg mt-4">
                        <p class="text-sm">
                            Enter contribution amounts in the table below. Leave cells empty for no contribution. Totals are calculated automatically.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Contribution Entry --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Contribution Entry</h2>
                </div>
                <div class="p-6">
                    <div class="border rounded-lg overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="sticky left-0 bg-white px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Member Name</th>
                                    @forelse($categories ?? [] as $category)
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">
                                            {{ $category->name }}
                                        </th>
                                    @empty
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">
                                            Tithe
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">
                                            Offering
                                        </th>
                                    @endforelse
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($members ?? [] as $member)
                                    <tr>
                                        <td class="sticky left-0 bg-white px-4 py-4 whitespace-nowrap">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $member->family_name }}</p>
                                            </div>
                                        </td>
                                        @forelse($categories ?? [['id' => 1, 'name' => 'Tithe'], ['id' => 2, 'name' => 'Offering']] as $category)
                                            <td class="px-4 py-4 text-center">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    name="contributions[{{ $member->id }}][{{ $category['id'] ?? $category->id }}]"
                                                    class="w-24 px-2 py-1 text-center rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm contribution-input"
                                                    data-member-id="{{ $member->id }}"
                                                    data-category-id="{{ $category['id'] ?? $category->id }}"
                                                />
                                            </td>
                                        @empty
                                            <td class="px-4 py-4 text-center">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    name="contributions[{{ $member->id }}][1]"
                                                    class="w-24 px-2 py-1 text-center rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm contribution-input"
                                                    data-member-id="{{ $member->id }}"
                                                    data-category-id="1"
                                                />
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00"
                                                    name="contributions[{{ $member->id }}][2]"
                                                    class="w-24 px-2 py-1 text-center rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm contribution-input"
                                                    data-member-id="{{ $member->id }}"
                                                    data-category-id="2"
                                                />
                                            </td>
                                        @endforelse
                                        <td class="px-4 py-4 text-right">
                                            <span class="text-sm member-total" data-member-id="{{ $member->id }}">₦0.00</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            No members found. <a href="{{ route('members.create') }}" class="text-blue-600 hover:text-blue-900">Add members first</a>.
                                        </td>
                                    </tr>
                                @endforelse
                                <tr class="bg-gray-50">
                                    <td class="sticky left-0 bg-gray-50 px-4 py-4">
                                        <span class="text-sm font-medium">Category Totals</span>
                                    </td>
                                    @forelse($categories ?? [['id' => 1], ['id' => 2]] as $category)
                                        <td class="px-4 py-4 text-center">
                                            <span class="text-sm category-total" data-category-id="{{ $category['id'] ?? $category->id }}">₦0.00</span>
                                        </td>
                                    @empty
                                        <td class="px-4 py-4 text-center">
                                            <span class="text-sm category-total" data-category-id="1">₦0.00</span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="text-sm category-total" data-category-id="2">₦0.00</span>
                                        </td>
                                    @endforelse
                                    <td class="px-4 py-4 text-right">
                                        <span class="text-sm font-medium" id="table-grand-total">₦0.00</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                        @php
                            try {
                                $cancelUrl = route('finance.index');
                            } catch (\Exception $e) {
                                $cancelUrl = url('/finance');
                            }
                        @endphp
                        <a href="{{ $cancelUrl }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-medium transition-colors text-center w-full sm:w-auto">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Save Contributions
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contributionInputs = document.querySelectorAll('.contribution-input');
            const grandTotalElement = document.getElementById('grand-total');
            const tableGrandTotalElement = document.getElementById('table-grand-total');

            function updateTotals() {
                let grandTotal = 0;
                const memberTotals = {};
                const categoryTotals = {};

                // Reset totals
                document.querySelectorAll('.member-total').forEach(el => {
                    el.textContent = '₦0.00';
                });
                document.querySelectorAll('.category-total').forEach(el => {
                    el.textContent = '₦0.00';
                });

                // Calculate totals
                contributionInputs.forEach(input => {
                    const memberId = input.dataset.memberId;
                    const categoryId = input.dataset.categoryId;
                    const value = parseFloat(input.value) || 0;

                    if (!memberTotals[memberId]) memberTotals[memberId] = 0;
                    if (!categoryTotals[categoryId]) categoryTotals[categoryId] = 0;

                    memberTotals[memberId] += value;
                    categoryTotals[categoryId] += value;
                    grandTotal += value;
                });

                // Update member totals
                Object.keys(memberTotals).forEach(memberId => {
                    const element = document.querySelector(`.member-total[data-member-id="${memberId}"]`);
                    if (element) {
                        element.textContent = `₦${memberTotals[memberId].toFixed(2)}`;
                    }
                });

                // Update category totals
                Object.keys(categoryTotals).forEach(categoryId => {
                    const element = document.querySelector(`.category-total[data-category-id="${categoryId}"]`);
                    if (element) {
                        element.textContent = `₦${categoryTotals[categoryId].toFixed(2)}`;
                    }
                });

                // Update grand totals
                grandTotalElement.textContent = `₦${grandTotal.toFixed(2)}`;
                tableGrandTotalElement.textContent = `₦${grandTotal.toFixed(2)}`;
            }

            contributionInputs.forEach(input => {
                input.addEventListener('input', updateTotals);
            });

            updateTotals(); // Initial calculation
        });
    </script>
</x-app-layout>