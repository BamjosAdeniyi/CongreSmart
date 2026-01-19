@props(['birthdays'])

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col gap-6">
    <div class="px-6 pt-6">
        <h3 class="text-lg font-semibold dark:text-gray-200">Birthdays This Week</h3>
    </div>
    <div class="px-6 pb-6">
        @if($birthdays->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">No birthdays this week.</p>
        @else
            <div class="space-y-4">
                @foreach($birthdays as $member)
                    <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex-shrink-0">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->full_name }}" class="w-10 h-10 text-gray-400 dark:text-gray-300 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-200 dark:bg-blue-700 flex items-center justify-center text-blue-700 dark:text-blue-200 font-bold">
                                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-500 truncate">
                                {{ $member->full_name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Turns {{ $member->age + 1 }} on {{ \Carbon\Carbon::parse($member->date_of_birth)->format('M d') }}
                            </p>
                        </div>
                        @if(\Carbon\Carbon::parse($member->date_of_birth)->format('m-d') === now()->format('m-d'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                Today!
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
