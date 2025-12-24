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

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        {{-- Transfer Requests --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Pending Transfers</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $pendingTransfers = \App\Models\MemberTransfer::where('status', 'pending')->with(['member', 'fromClass', 'toClass'])->get();
                    @endphp
                    @forelse($pendingTransfers as $transfer)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $transfer->member->first_name }} {{ $transfer->member->last_name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst($transfer->transfer_type) }} Transfer
                                        ({{ $transfer->direction === 'from' ? 'Joining from' : 'Leaving to' }}
                                        {{ $transfer->transfer_type === 'church' ? $transfer->church_name : ($transfer->toClass->name ?? 'N/A') }})
                                    </p>
                                    @if($transfer->reason)
                                        <p class="text-xs text-gray-500 mt-1">Reason: {{ $transfer->reason }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="approveTransfer('{{ $transfer->id }}')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Approve
                                </button>
                                <button onclick="rejectTransfer('{{ $transfer->id }}')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Reject
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Transfers</h3>
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
                        $transferHistory = \App\Models\MemberTransfer::where('status', '!=', 'pending')
                            ->with(['member', 'toClass'])
                            ->orderBy('updated_at', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    @forelse($transferHistory as $transfer)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 {{ $transfer->status === 'completed' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                    @if($transfer->status === 'completed')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $transfer->member->first_name }} {{ $transfer->member->last_name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst($transfer->transfer_type) }} transfer to
                                        {{ $transfer->transfer_type === 'church' ? $transfer->church_name : ($transfer->toClass->name ?? 'N/A') }}
                                        - <span class="{{ $transfer->status === 'completed' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($transfer->status) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $transfer->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-600">No transfer history.</p>
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
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Type</label>
                                    <select name="transfer_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" required>
                                        <option value="class">Between Classes</option>
                                        <option value="church">To/From Another Church</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                                    <select name="direction" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                        <option value="to">Leaving to (To)</option>
                                        <option value="from">Joining from (From)</option>
                                    </select>
                                </div>
                            </div>
                            <div id="church-fields" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Church Name</label>
                                <input type="text" name="church_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Enter church name">
                            </div>
                            <div id="class-fields">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Class</label>
                                <select name="to_class_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                    <option value="">Select class...</option>
                                    @php
                                        $classes = \App\Models\SabbathSchoolClass::where('active', true)->get();
                                    @endphp
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Date</label>
                                <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                                <textarea name="reason" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Reason for transfer..."></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Additional notes..."></textarea>
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
        document.addEventListener('DOMContentLoaded', function() {
            const transferModal = document.getElementById('transferModal');
            const transferForm = document.getElementById('transferForm');
            const transferTypeSelect = transferForm.querySelector('select[name="transfer_type"]');
            const churchFields = document.getElementById('church-fields');
            const classFields = document.getElementById('class-fields');

            transferTypeSelect.addEventListener('change', function() {
                if (this.value === 'church') {
                    churchFields.classList.remove('hidden');
                    classFields.classList.add('hidden');
                } else {
                    churchFields.classList.add('hidden');
                    classFields.classList.remove('hidden');
                }
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const transferUrl = '{{ route("members.transfer") }}';

            window.openTransferModal = function() {
                transferModal.classList.remove('hidden');
            }

            window.closeTransferModal = function() {
                transferModal.classList.add('hidden');
            }

            // This part handles the form submission for initiating a transfer
            transferForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const payload = {
                    member_id: formData.get('member_id'),
                    transfer_type: formData.get('transfer_type'),
                    direction: formData.get('direction') || 'to',
                    church_name: formData.get('church_name'),
                    to_class_id: formData.get('to_class_id'),
                    transfer_date: formData.get('transfer_date') || new Date().toISOString().split('T')[0],
                    reason: formData.get('reason'),
                    notes: formData.get('notes')
                };

                if (!payload.member_id || !payload.transfer_type) {
                    alert('Please select a member and transfer type.');
                    return;
                }

                try {
                    const response = await fetch(transferUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        alert(data.message || 'Transfer request submitted successfully!');
                        closeTransferModal();
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to submit transfer request.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred during transfer submission.');
                }
            });

            window.approveTransfer = async function(transferId) {
                if (confirm('Are you sure you want to approve this transfer?')) {
                    try {
                        const response = await fetch(`{{ url('members/transfer') }}/${transferId}/update`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ status: 'completed' })
                        });

                        const data = await response.json();
                        if (response.ok) {
                            alert(data.message || 'Transfer approved!');
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to approve transfer.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred.');
                    }
                }
            }

            window.rejectTransfer = async function(transferId) {
                if (confirm('Are you sure you want to reject this transfer?')) {
                    try {
                        const response = await fetch(`{{ url('members/transfer') }}/${transferId}/update`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ status: 'rejected' })
                        });

                        const data = await response.json();
                        if (response.ok) {
                            alert(data.message || 'Transfer rejected!');
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to reject transfer.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred.');
                    }
                }
            }
        });
    </script>
</x-app-layout>
