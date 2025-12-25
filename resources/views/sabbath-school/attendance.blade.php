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

        {{-- General Error Display --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
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
                               value="{{ old('date', today()->format('Y-m-d')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror" required>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <input type="text" id="notes" name="notes"
                               value="{{ old('notes') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                               placeholder="Optional notes about this session">
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
                                               id="member_{{ $member->member_id }}"
                                               name="present_members[]"
                                               value="{{ $member->member_id }}"
                                               {{ ($existingAttendance->get($member->member_id)) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div>
                                            <label for="member_{{ $member->member_id }}" class="font-medium cursor-pointer">
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
                    {{ $existingAttendance->isNotEmpty() ? 'Update Attendance' : 'Record Attendance' }}
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

        document.getElementById('date').addEventListener('change', function() {
            const date = this.value;
            const classId = '{{ $class->id }}';
            const url = `/sabbath-school/${classId}/attendance/data?date=${date}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const checkboxes = document.querySelectorAll('input[name="present_members[]"]');
                    checkboxes.forEach(checkbox => {
                        const memberId = checkbox.value;
                        checkbox.checked = !!data[memberId];
                    });
                })
                .catch(error => console.error('Error fetching attendance data:', error));
        });
    </script>
</x-app-layout>
