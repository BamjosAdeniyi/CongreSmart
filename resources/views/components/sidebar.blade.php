<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-[260px] bg-[var(--sidebar)]
           border-r border-[var(--sidebar-border)]
           p-4 z-50 transition-transform duration-300
           -translate-x-full lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex items-center space-x-3 mb-8 px-2">
        <img src="{{ asset('images/sda-logo.png') }}" class="h-10 w-10" />
        <div>
            <h1 class="font-semibold text-lg">CongreSmart</h1>
            <p class="text-xs text-[var(--muted-foreground)]">Church Management</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="space-y-1">
        <?php
            $links = [
                ['Dashboard', 'dashboard', 'bi bi-speedometer2'],
                // ['Members', 'members.index', 'bi bi-people'],
                // ['Sabbath School', 'school.index', 'bi bi-book'],
                // ['Finance', 'finance.index', 'bi bi-cash-stack'],
                // ['Reports', 'reports.index', 'bi bi-file-earmark-text'],
                // ['Notifications', 'notifications.index', 'bi bi-bell'],
                // ['Settings', 'settings.index', 'bi bi-gear'],
            ];
        ?>

        @foreach ($links as [$label, $routeName, $icon])
            <a href="{{ route($routeName) }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                       hover:bg-[var(--sidebar-accent)]
                       hover:text-[var(--sidebar-accent-foreground)]
                       {{ request()->routeIs($routeName) ? 'bg-[var(--sidebar-accent)] font-semibold' : '' }}">
                <i class="{{ $icon }} text-lg"></i>
                {{ $label }}
            </a>
        @endforeach
    </nav>

</aside>
