@php
    $user = auth()->user();
    if (!$user) {
        return; // Don't render sidebar if user is not authenticated
    }
    $userRole = $user->role ?? 'pastor';

    // Define menu items with their roles
    $menuItems = [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'roles' => ['pastor', 'clerk', 'welfare', 'superintendent', 'coordinator', 'financial', 'ict']],
        ['id' => 'members', 'label' => 'Members', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'roles' => ['pastor', 'clerk', 'welfare', 'ict']],
        ['id' => 'sabbath-school', 'label' => 'Sabbath School', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'roles' => ['pastor', 'superintendent', 'coordinator', 'welfare', 'ict']],
        ['id' => 'finance', 'label' => 'Finance', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'roles' => ['pastor', 'financial', 'ict']],
        ['id' => 'reports', 'label' => 'Reports', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'roles' => ['pastor', 'clerk', 'superintendent', 'financial', 'ict']],
        ['id' => 'notifications', 'label' => 'Notifications', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'roles' => ['pastor', 'clerk', 'welfare', 'superintendent', 'coordinator', 'financial', 'ict']],
        ['id' => 'settings', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'roles' => ['ict', 'pastor']],
    ];

    // Filter menu items based on user role
    $accessibleItems = array_filter($menuItems, function($item) use ($userRole) {
        return in_array($userRole, $item['roles']);
    });

    $currentPage = request()->segment(1) ?? 'dashboard';
@endphp

{{-- Desktop Sidebar --}}
<aside class="hidden md:flex w-64 bg-white border-r border-gray-200 h-screen flex-col fixed left-0 top-0 z-40">
    {{-- Logo Section --}}
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center p-1">
                <img src="{{ asset('images/sda-logo.png') }}" alt="SDA Logo" class="w-8 h-8 object-contain" />
            </div>
            <div>
                <h1 class="text-lg font-semibold">CongreSmart</h1>
                <p class="text-xs text-gray-500">Church Management</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        @foreach($accessibleItems as $item)
            @php
                $isActive = ($currentPage === $item['id']) ||
                           (request()->routeIs($item['id'] . '.*')) ||
                           (request()->routeIs('dashboard.*') && $item['id'] === 'dashboard');
                $routeName = $item['id'] === 'dashboard' ? 'dashboard' : $item['id'] . '.index';
            @endphp
            @php
                try {
                    $routeUrl = route($routeName);
                } catch (\Exception $e) {
                    $routeUrl = url('/' . $item['id']);
                }
            @endphp
            <a href="{{ $routeUrl }}"
               class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ $isActive ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                </svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>

{{-- Mobile Sidebar (Sheet/Drawer) --}}
<div id="mobile-sidebar" class="md:hidden fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300">
    <div class="flex flex-col h-full">
        {{-- Logo Section --}}
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center p-1">
                    <img src="{{ asset('images/sda-logo.png') }}" alt="SDA Logo" class="w-6 h-6 object-contain" />
                </div>
                <div>
                    <h1 class="text-lg font-semibold">CongreSmart</h1>
                    <p class="text-xs text-gray-500">Church Management</p>
                </div>
            </div>
            <button onclick="toggleMobileSidebar()" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @foreach($accessibleItems as $item)
                @php
                    $isActive = ($currentPage === $item['id']) ||
                               (request()->routeIs($item['id'] . '.*')) ||
                               (request()->routeIs('dashboard.*') && $item['id'] === 'dashboard');
                    $routeName = $item['id'] === 'dashboard' ? 'dashboard' : $item['id'] . '.index';
                @endphp
                @php
                    try {
                        $routeUrl = route($routeName);
                    } catch (\Exception $e) {
                        $routeUrl = url('/' . $item['id']);
                    }
                @endphp
                <a href="{{ $routeUrl }}"
                   onclick="toggleMobileSidebar()"
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ $isActive ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</div>

{{-- Mobile Overlay --}}
<div id="mobile-overlay" class="md:hidden fixed inset-0 bg-black/50 z-40 hidden" onclick="toggleMobileSidebar()"></div>

<script>
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('mobile-overlay');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
</script>
