<header class="h-16 px-6 flex items-center justify-between 
               bg-[var(--card)] border-b border-[var(--border)]">

    {{-- Left: Breadcrumbs + Page Title --}}
    <div>
        <x-breadcrumbs />
        <h1 class="text-xl font-semibold">{{ $title }}</h1>
    </div>

    {{-- Right: Notification + User --}}
    <div class="flex items-center gap-6">

        {{-- Notification Bell --}}
        <button class="relative">
            <i class="bi bi-bell text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 
                        flex items-center justify-center rounded-full">2</span>
        </button>

        {{-- User Avatar --}}
        <div class="flex items-center gap-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                class="h-8 w-8 rounded-full" />
            <div class="text-sm">
                <p class="font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
        </div>

        {{-- Mobile Menu Button --}}
        <button onclick="toggleSidebar()" class="lg:hidden ml-4">
            <i class="bi bi-list text-2xl"></i>
        </button>

    </div>
</header>
