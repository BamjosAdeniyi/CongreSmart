@php
    $user = auth()->user();
    if (!$user) {
        return; // Don't render navbar if user is not authenticated
    }
    $roleLabels = [
        'pastor' => 'Pastor/Elder',
        'clerk' => 'Church Clerk',
        'welfare' => 'Welfare Leader',
        'superintendent' => 'SS Superintendent',
        'coordinator' => 'SS Coordinator',
        'financial' => 'Financial Secretary',
        'ict' => 'ICT Administrator',
    ];
    $userRoleLabel = $roleLabels[$user->role ?? 'pastor'] ?? 'User';

    // Get display name
    $displayName = $user->role === 'pastor' ? 'Pastor ' . $user->first_name : $user->first_name;

    // Get unread notification count
    $notificationCount = \App\Http\Controllers\NotificationsController::getUnreadCount();
@endphp

<header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        {{-- Mobile Menu Button --}}
        <button onclick="toggleMobileSidebar()" class="md:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div>
            <h2 class="text-base md:text-lg text-gray-800 dark:text-gray-200">Welcome, {{ $displayName }}!</h2>
            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">{{ $userRoleLabel }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2 md:gap-4">
        {{-- Notifications --}}
        @php
            try {
                $notificationsUrl = route('notifications.index');
            } catch (\Exception $e) {
                $notificationsUrl = url('/notifications');
            }
        @endphp
        <a href="{{ $notificationsUrl }}" class="relative p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if($notificationCount > 0)
                <span class="absolute -top-1 -right-1 {{ $notificationCount > 9 ? 'w-6 h-5' : 'w-5 h-5' }} flex items-center justify-center p-0 bg-red-500 text-white text-xs rounded-full min-w-[20px]">
                    {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                </span>
            @endif
        </a>

        {{-- User Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center overflow-hidden border border-white">
                    @if($user->avatar ?? false)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover" />
                    @else
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                </div>
                <span class="hidden sm:inline text-sm font-medium dark:text-gray-300">{{ $displayName }}</span>
                <svg class="w-4 h-4 hidden sm:inline text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-medium dark:text-gray-200">My Account</p>
                </div>
                @php
                    try {
                        $profileUrl = route('profile.edit');
                    } catch (\Exception $e) {
                        $profileUrl = url('/profile');
                    }
                @endphp
                <a href="{{ $profileUrl }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile</span>
                </a>
                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
