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
                <h3 class="text-lg font-semibold mb-4">Currently Assigned Members ({{ $assignedMembers->count() }})</h3>
                <div class="space-y-2">
                    @forelse($assignedMembers as $member)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" checked
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <div>
                                    <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="removeMember({{ $member->id }})" class="text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No members currently assigned to this class.</p>
                    @endforelse
                </div>
            </div>

            {{-- Available Members --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Available Members ({{ $availableMembers->count() }})</h3>
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @forelse($availableMembers as $member)
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div>
                                <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $member->email }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No available members to assign.</p>
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
        function removeMember(memberId) {
            // Uncheck the member
            const checkbox = document.querySelector(`input[value="${memberId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
        }
    </script>
</x-app-layout>