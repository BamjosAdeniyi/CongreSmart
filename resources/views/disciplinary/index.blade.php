<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Disciplinary Records</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage active disciplinary actions</p>
            </div>
            <a href="{{ route('disciplinary.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Record
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($records as $record)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $record->member->full_name }}</h3>
                        <a href="{{ route('disciplinary.show', $record) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p><strong class="text-gray-600 dark:text-gray-400">Offense:</strong> {{ Str::limit($record->offense_type, 50) }}</p>
                        <p><strong class="text-gray-600 dark:text-gray-400">Action:</strong> {{ Str::limit($record->discipline_type, 50) }}</p>
                        <p><strong class="text-gray-600 dark:text-gray-400">Duration:</strong> {{ $record->start_date->format('M j, Y') }} - {{ $record->end_date ? $record->end_date->format('M j, Y') : 'Ongoing' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Active Records</h3>
                    <p class="text-gray-600 dark:text-gray-400">There are no active disciplinary records at this time.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
