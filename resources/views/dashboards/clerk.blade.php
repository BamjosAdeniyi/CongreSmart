<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Church Clerk Dashboard</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage member records and registrations</p>
            </div>
            <a href="{{ route('members.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Member
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Members</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalMembers) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Members</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($activeMembers) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New This Month</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($newMembersThisMonth) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Upcoming Birthdays</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $upcomingBirthdays->count() }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Members --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Members</h2>
                    <a href="{{ route('members.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                        View All
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentMembers as $member)
                        <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">{{ $member->first_name }} {{ $member->last_name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Joined {{ $member->membership_date->format('M j, Y') }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($member->membership_status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                {{ ucfirst($member->membership_status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent members</p>
                    @endforelse
                </div>
            </div>

            {{-- Upcoming Birthdays --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upcoming Birthdays</h2>
                    <a href="{{ route('members.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                        View All
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($upcomingBirthdays as $member)
                        <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">{{ $member->first_name }} {{ $member->last_name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('M j') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($member->date_of_birth)->age }} years old</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No upcoming birthdays</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('members.create') }}" class="w-full text-left p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition-colors block">
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Add Member</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Register new member</p>
                </a>

                <a href="{{ route('members.index') }}" class="w-full text-left p-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 rounded-lg transition-colors block">
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">View Members</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Browse member list</p>
                </a>

                <a href="{{ route('members.transfers') }}" class="w-full text-left p-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 rounded-lg transition-colors block">
                    <p class="text-sm font-medium text-purple-800 dark:text-purple-300">Transfer Requests</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Manage transfers</p>
                </a>

                <a href="{{ route('reports.members') }}" class="w-full text-left p-3 bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/40 rounded-lg transition-colors block">
                    <p class="text-sm font-medium text-orange-800 dark:text-orange-300">Reports</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Generate reports</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
