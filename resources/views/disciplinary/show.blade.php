<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('disciplinary.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Disciplinary Record Details</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Viewing record for {{ $record->member->full_name }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Member Details</h3>
                    <p><strong>Name:</strong> {{ $record->member->full_name }}</p>
                    <p><strong>Email:</strong> {{ $record->member->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $record->member->phone ?? 'N/A' }}</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Offense Details</h3>
                    <p><strong>Type:</strong> {{ $record->offense_type }}</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $record->offense_description }}</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Discipline Details</h3>
                    <p><strong>Type:</strong> {{ $record->discipline_type }}</p>
                    <p><strong>Duration:</strong> {{ $record->start_date->format('F j, Y') }} - {{ $record->end_date ? $record->end_date->format('F j, Y') : 'Ongoing' }}</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Record Details</h3>
                    <p><strong>Status:</strong> <span class="capitalize px-2 py-1 text-xs rounded-full {{ $record->status === 'active' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">{{ $record->status }}</span></p>
                    <p><strong>Recorded By:</strong> {{ $record->recorder->name ?? 'N/A' }}</p>
                    <p><strong>Approved By:</strong> {{ $record->approver->name ?? 'N/A' }}</p>
                    <p><strong>Date Recorded:</strong> {{ $record->created_at->format('F j, Y') }}</p>
                    @if($record->notes)
                        <p><strong>Notes:</strong> {{ $record->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
