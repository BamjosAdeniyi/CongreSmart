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
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg assigned-member-item" data-member-id="{{ $member->member_id }}" data-member-name="{{ strtolower($member->first_name . ' ' . $member->last_name) }}">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->member_id }}" checked
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded assigned-checkbox">
                                <div>
                                    <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="removeMember('{{ $member->member_id }}')" class="text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4" id="no-assigned-members">No members currently assigned to this class.</p>
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
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 available-member-item" data-member-id="{{ $member->member_id }}" data-member-name="{{ strtolower($member->first_name . ' ' . $member->last_name) }}">
                            <input type="checkbox" name="member_ids[]" value="{{ $member->member_id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded available-checkbox">
                            <div>
                                <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4" id="no-available-members">No available members to assign.</p>
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
            const noAssignedMembers = document.getElementById('no-assigned-members');
            const noAvailableMembers = document.getElementById('no-available-members');

            function updateCounts() {
                const assignedCount = assignedMembersList.querySelectorAll('.assigned-member-item').length;
                const availableCount = availableMembersList.querySelectorAll('.available-member-item').length;

                assignedMembersCount.textContent = assignedCount;
                availableMembersCount.textContent = availableCount;

                if (assignedCount === 0) {
                    if (!noAssignedMembers) {
                        const p = document.createElement('p');
                        p.id = 'no-assigned-members';
                        p.className = 'text-gray-500 text-center py-4';
                        p.textContent = 'No members currently assigned to this class.';
                        assignedMembersList.appendChild(p);
                    }
                } else {
                    noAssignedMembers?.remove();
                }

                if (availableCount === 0) {
                    if (!noAvailableMembers) {
                        const p = document.createElement('p');
                        p.id = 'no-available-members';
                        p.className = 'text-gray-500 text-center py-4';
                        p.textContent = 'No available members to assign.';
                        availableMembersList.appendChild(p);
                    }
                } else {
                    noAvailableMembers?.remove();
                }
            }

            window.removeMember = function(memberId) {
                const assignedItem = assignedMembersList.querySelector(`.assigned-member-item[data-member-id="${memberId}"]`);
                if (assignedItem) {
                    const checkbox = assignedItem.querySelector('.assigned-checkbox');
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.name = 'unassigned_member_ids[]'; // Change name to prevent submission if not re-added
                    }
                    availableMembersList.appendChild(assignedItem);
                    assignedItem.classList.remove('assigned-member-item', 'bg-gray-50');
                    assignedItem.classList.add('available-member-item', 'border', 'border-gray-200', 'hover:bg-gray-50');
                    // Change the button to an "Add" button or remove it
                    const removeButton = assignedItem.querySelector('button');
                    if (removeButton) removeButton.remove();
                    updateCounts();
                }
            };

            // Add member from available to assigned
            availableMembersList.addEventListener('change', function(event) {
                if (event.target.classList.contains('available-checkbox') && event.target.checked) {
                    const memberId = event.target.value;
                    const availableItem = event.target.closest('.available-member-item');
                    if (availableItem) {
                        const checkbox = availableItem.querySelector('.available-checkbox');
                        if (checkbox) {
                            checkbox.name = 'member_ids[]'; // Revert name for submission
                        }
                        assignedMembersList.appendChild(availableItem);
                        availableItem.classList.remove('available-member-item', 'border', 'border-gray-200', 'hover:bg-gray-50');
                        availableItem.classList.add('assigned-member-item', 'bg-gray-50');

                        // Add back the remove button
                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.onclick = () => window.removeMember(memberId);
                        removeButton.className = 'text-red-600 hover:text-red-800';
                        removeButton.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                  </svg>`;
                        availableItem.appendChild(removeButton);
                        updateCounts();
                    }
                }
            });


            memberSearch.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                availableMembersList.querySelectorAll('.available-member-item').forEach(function(item) {
                    const memberName = item.dataset.memberName;
                    if (memberName.includes(searchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            updateCounts(); // Initial count update
        });
    </script>