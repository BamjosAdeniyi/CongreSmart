<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Transfer Management</h1>
                <p class="text-sm md:text-base text-gray-500">Manage member transfers between classes and churches</p>
            </div>
            <button onclick="openTransferModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Initiate Transfer
            </button>
        </div>

        {{-- Transfer Requests --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Transfer Requests</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $transferredMembers = \App\Models\Member::where('membership_status', 'transferred')->with('sabbathClass')->get();
                    @endphp
                    @forelse($transferredMembers as $member)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</h3>
                                    <p class="text-sm text-gray-600">From: {{ $member->sabbathClass?->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="approveTransfer('{{ $member->member_id }}')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Approve
                                </button>
                                <button onclick="rejectTransfer('{{ $member->member_id }}')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Reject
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Transfer Requests</h3>
                            <p class="text-gray-600">All transfer requests have been processed.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Transfer History --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Transfer History</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $recentTransfers = \App\Models\Member::where('membership_status', 'active')
                            ->where('updated_at', '>=', now()->subDays(30))
                            ->with('sabbathClass')
                            ->orderBy('updated_at', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    @forelse($recentTransfers as $member)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</h3>
                                    <p class="text-sm text-gray-600">Current Class: {{ $member->sabbathClass?->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $member->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-600">No recent transfers.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Transfer Modal --}}
    <div id="transferModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Initiate Transfer</h3>
                    <form id="transferForm">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Member</label>
                                <select name="member_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" required>
                                    <option value="">Choose a member...</option>
                                    @php
                                        $activeMembers = \App\Models\Member::where('membership_status', 'active')->orderBy('first_name')->get();
                                    @endphp
                                    @foreach($activeMembers as $member)
                                        <option value="{{ $member->member_id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Type</label>
                                <select name="transfer_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" required>
                                    <option value="class">Between Classes</option>
                                    <option value="church">To Another Church</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                                <textarea name="reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Reason for transfer..."></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="closeTransferModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTransferModal() {
            document.getElementById('transferModal').classList.remove('hidden');
        }

        function closeTransferModal() {
            document.getElementById('transferModal').classList.add('hidden');
        }

        function approveTransfer(memberId) {
            if (confirm('Are you sure you want to approve this transfer?')) {
                // Implement approval logic
                alert('Transfer approved for member: ' + memberId);
            }
        }

        function rejectTransfer(memberId) {
            if (confirm('Are you sure you want to reject this transfer?')) {
                // Implement rejection logic
                alert('Transfer rejected for member: ' + memberId);
            }
        }

        document.getElementById('transferForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Implement form submission
            alert('Transfer request submitted');
            closeTransferModal();
        });
    </script>
</x-app-layout>