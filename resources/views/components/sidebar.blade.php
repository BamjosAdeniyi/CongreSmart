<div class="w-64 h-screen bg-[var(--sidebar)] border-r border-[var(--sidebar-border)] flex flex-col">

    {{-- Logo + App Name --}}
    <div class="flex items-center gap-3 px-6 py-6 border-b border-[var(--sidebar-border)]">
        <img src="{{ asset('images/sda-logo.png') }}" alt="SDA Logo" class="h-10 w-10 object-contain">

        <div>
            <h1 class="text-lg font-semibold text-[var(--sidebar-primary)] leading-tight">
                CongreSmart
            </h1>
            <p class="text-xs text-[var(--muted-foreground)]">
                Church Management
            </p>
        </div>
    </div>


    {{-- Menu Links --}}
    <nav class="flex-1 px-4 py-4 space-y-1">

        {{-- Helper: Determine Active --}}
        @php
            function isActiveRoute($route)
            {
                return request()->routeIs($route) ? 'bg-[var(--sidebar-accent)] text-[var(--sidebar-primary)]' : 'text-[var(--sidebar-foreground)]';
            }
        @endphp

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('dashboard') }}">
            📊 <span>Dashboard</span>
        </a>

        <a href="{{ route('members.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('members.*') }}">
            👥 <span>Members</span>
        </a>

        <a href="{{ route('classes.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('classes.*') }}">
            🏫 <span>Sabbath School</span>
        </a>

        <a href="{{ route('attendance.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('attendance.*') }}">
            📅 <span>Attendance</span>
        </a>

        <a href="{{ route('finance.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('finance.*') }}">
            💰 <span>Finance</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('reports.*') }}">
            📄 <span>Reports</span>
        </a>

        @if(auth()->user()->role === 'ict')
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                  hover:bg-[var(--sidebar-accent)] {{ isActiveRoute('admin.users.*') }}">
            🛠 <span>User Management</span>
        </a>
        @endif

    </nav>

</div>
