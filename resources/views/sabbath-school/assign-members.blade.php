<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('sabbath-school.show', $class) }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Assign Members - {{ $class->name }}</h1>
                <p class="text-gray-600">Manage member assignments for this class</p>
            </div>
        </div>

        <form method="POST" action="{{ route('sabbath-school.assign-members.update', $class) }}" class="space-y-6">
            @csrf

            {{-- Assigned Members --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Currently Assigned Members (<span id="assigned-members-count">{{ $assignedMembers->count() }}</span>)</h3>
                <div class="space-y-2" id="assigned-members-list">
                    @forelse($assignedMembers as $member)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg member-item" data-member-id="{{ $member->member_id }}" data-member-name="{{ strtolower($member->first_name . ' ' . $member->last_name) }}">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->member_id }}" checked
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded assigned-checkbox">
                                <div>
                                    <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="removeMember('{{ $member->member_id }}')" class="text-red-600 hover:text-red-800 remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="empty-state-msg text-gray-500 text-center py-4">No members currently assigned to this class.</p>
                    @endforelse
                </div>
            </div>

            {{-- Available Members --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Available Members (<span id="available-members-count">{{ $availableMembers->count() }}</span>)</h3>
                <div class="mb-4">
                    <input type="text" id="member-search" placeholder="Search available members..."
                           class="w-full px-3 py-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm">
                </div>
                <div class="space-y-2 max-h-96 overflow-y-auto" id="available-members-list">
                    @forelse($availableMembers as $member)
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 member-item" data-member-id="{{ $member->member_id }}" data-member-name="{{ strtolower($member->first_name . ' ' . $member->last_name) }}">
                            <input type="checkbox" name="member_ids[]" value="{{ $member->member_id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded available-checkbox">
                            <div>
                                <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="empty-state-msg text-gray-500 text-center py-4">No available members to assign.</p>
                    @endforelse
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('sabbath-school.show', $class) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Assignments
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const assignedMembersList = document.getElementById('assigned-members-list');
            const availableMembersList = document.getElementById('available-members-list');
            const memberSearch = document.getElementById('member-search');
            const assignedMembersCount = document.getElementById('assigned-members-count');
            const availableMembersCount = document.getElementById('available-members-count');

            function updateCounts() {
                const assignedCount = assignedMembersList.querySelectorAll('.member-item').length;
                const availableCount = availableMembersList.querySelectorAll('.member-item').length;

                assignedMembersCount.textContent = assignedCount;
                availableMembersCount.textContent = availableCount;

                // Handle empty states
                toggleEmptyState(assignedMembersList, assignedCount, 'No members currently assigned to this class.');
                toggleEmptyState(availableMembersList, availableCount, 'No available members to assign.');
            }

            function toggleEmptyState(list, count, message) {
                let emptyMsg = list.querySelector('.empty-state-msg');
                if (count === 0) {
                    if (!emptyMsg) {
                        emptyMsg = document.createElement('p');
                        emptyMsg.className = 'empty-state-msg text-gray-500 text-center py-4';
                        emptyMsg.textContent = message;
                        list.appendChild(emptyMsg);
                    }
                } else if (emptyMsg) {
                    emptyMsg.remove();
                }
            }

            function createRemoveButton(memberId) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'text-red-600 hover:text-red-800 remove-btn';
                button.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>`;
                button.onclick = () => moveMemberToAvailable(memberId);
                return button;
            }

            function moveMemberToAssigned(memberItem) {
                const memberId = memberItem.dataset.memberId;
                const checkbox = memberItem.querySelector('input[type="checkbox"]');

                checkbox.checked = true;
                checkbox.className = 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded assigned-checkbox';

                memberItem.classList.remove('available-member-item', 'border', 'border-gray-200', 'hover:bg-gray-50');
                memberItem.classList.add('assigned-member-item', 'bg-gray-50');

                // Add remove button if it doesn't exist
                if (!memberItem.querySelector('.remove-btn')) {
                    memberItem.appendChild(createRemoveButton(memberId));
                }

                assignedMembersList.appendChild(memberItem);
                updateCounts();
            }

            function moveMemberToAvailable(memberId) {
                const memberItem = document.querySelector(`.member-item[data-member-id="${memberId}"]`);
                if (memberItem) {
                    const checkbox = memberItem.querySelector('input[type="checkbox"]');
                    checkbox.checked = false;
                    checkbox.className = 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded available-checkbox';

                    memberItem.classList.remove('assigned-member-item', 'bg-gray-50');
                    memberItem.classList.add('available-member-item', 'border', 'border-gray-200', 'hover:bg-gray-50');

                    const removeBtn = memberItem.querySelector('.remove-btn');
                    if (removeBtn) removeBtn.remove();

                    availableMembersList.appendChild(memberItem);
                    updateCounts();
                }
            }

            // Global exposure for the remove button's onclick
            window.removeMember = moveMemberToAvailable;

            // Handle checkbox changes in available list
            availableMembersList.addEventListener('change', function(event) {
                if (event.target.type === 'checkbox' && event.target.checked) {
                    const memberItem = event.target.closest('.member-item');
                    if (memberItem) {
                        moveMemberToAssigned(memberItem);
                    }
                }
            });

            // Handle checkbox changes in assigned list (unchecking moves to available)
            assignedMembersList.addEventListener('change', function(event) {
                if (event.target.type === 'checkbox' && !event.target.checked) {
                    const memberItem = event.target.closest('.member-item');
                    if (memberItem) {
                        moveMemberToAvailable(memberItem.dataset.memberId);
                    }
                }
            });

            // Search functionality
            memberSearch.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                availableMembersList.querySelectorAll('.member-item').forEach(function(item) {
                    const memberName = item.dataset.memberName;
                    item.style.display = memberName.includes(searchValue) ? '' : 'none';
                });
            });

            // Initialization: ensure all checkboxes have name="member_ids[]"
            document.querySelectorAll('input[name="member_ids[]"]').forEach(cb => {
                // Ensure they are correctly categorized initially
                const item = cb.closest('.member-item');
                if (cb.checked) {
                    item.classList.add('assigned-member-item');
                } else {
                    item.classList.add('available-member-item');
                }
            });

            updateCounts();
        });
    </script>
</x-app-layout>
