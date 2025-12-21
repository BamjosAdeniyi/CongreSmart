<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('sabbath-school.show', $class) }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Take Attendance</h1>
                    <p class="text-gray-600">{{ $class->name }} - {{ $class->meeting_day }} {{ $class->meeting_time }}</p>
                </div>
            </div>
        </div>

        @if($existingAttendance)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Attendance already taken today</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Attendance for {{ $existingAttendance->date->format('M j, Y') }} has already been recorded.
                            You can update it below or create a new record for a different date.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('sabbath-school.attendance.store', $class) }}" class="bg-white rounded-xl border border-gray-200 p-6">
            @csrf

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                        <input type="date" id="date" name="date"
                               value="{{ $existingAttendance ? $existingAttendance->date->format('Y-m-d') : today()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror" required>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <input type="text" id="notes" name="notes"
                               value="{{ $existingAttendance ? $existingAttendance->notes : '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                               placeholder="Optional notes about this session">
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Mark Attendance</h3>
                        <div class="flex gap-2">
                            <button type="button" onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-900">Select All</button>
                            <button type="button" onclick="selectNone()" class="text-sm text-gray-600 hover:text-gray-900">Select None</button>
                        </div>
                    </div>

                    @if($members->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($members as $member)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox"
                                               id="member_{{ $member->id }}"
                                               name="present_members[]"
                                               value="{{ $member->id }}"
                                               {{ $existingAttendance && in_array($member->id, json_decode($existingAttendance->present_members, true)) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div>
                                            <label for="member_{{ $member->id }}" class="font-medium cursor-pointer">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </label>
                                            @if($member->phone)
                                                <p class="text-sm text-gray-600">{{ $member->phone }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($member->membership_status === 'active') bg-green-100 text-green-800
                                        @elseif($member->membership_status === 'inactive') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($member->membership_status ?? 'unknown') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p>No members assigned to this class.</p>
                            <p class="text-sm mt-1">Assign members to the class before taking attendance.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('sabbath-school.show', $class) }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors"
                        {{ $members->count() == 0 ? 'disabled' : '' }}>
                    {{ $existingAttendance ? 'Update Attendance' : 'Record Attendance' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function selectAll() {
            const checkboxes = document.querySelectorAll('input[name="present_members[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = true);
        }

        function selectNone() {
            const checkboxes = document.querySelectorAll('input[name="present_members[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
        }
    </script>
</x-app-layout>