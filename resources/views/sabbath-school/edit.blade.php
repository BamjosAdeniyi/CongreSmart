<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('sabbath-school.show', $class) }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Sabbath School Class</h1>
                <p class="text-gray-600">Update class information</p>
            </div>
        </div>

        <form method="POST" action="{{ route('sabbath-school.update', $class) }}" class="bg-white rounded-xl border border-gray-200 p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Class Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $class->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Young Adults Class" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Brief description of the class">{{ old('description', $class->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="coordinator_id" class="block text-sm font-medium text-gray-700 mb-2">Coordinator *</label>
                    <select id="coordinator_id" name="coordinator_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('coordinator_id') border-red-500 @enderror" required>
                        <option value="">Select a coordinator</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('coordinator_id', $class->coordinator_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('coordinator_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="meeting_day" class="block text-sm font-medium text-gray-700 mb-2">Meeting Day *</label>
                        <select id="meeting_day" name="meeting_day"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('meeting_day') border-red-500 @enderror" required>
                            <option value="">Select day</option>
                            <option value="Friday" {{ old('meeting_day', $class->meeting_day) == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ old('meeting_day', $class->meeting_day) == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ old('meeting_day', $class->meeting_day) == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                        @error('meeting_day')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meeting_time" class="block text-sm font-medium text-gray-700 mb-2">Meeting Time *</label>
                        <input type="time" id="meeting_time" name="meeting_time" value="{{ old('meeting_time', $class->meeting_time) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('meeting_time') border-red-500 @enderror" required>
                        @error('meeting_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $class->location) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror"
                           placeholder="e.g., Main Sanctuary, Room 101">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="active" name="active" value="1" {{ old('active', $class->active) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-900">
                        Active class
                    </label>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Update Class
                    </button>
                    <a href="{{ route('sabbath-school.show', $class) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>