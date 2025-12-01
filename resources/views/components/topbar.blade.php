<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

    {{-- Page Title --}}
    <div>
        <h2 class="text-xl font-semibold text-[var(--foreground)]">
            {{ $title ?? 'Dashboard' }}
        </h2>
    </div>

    {{-- User Info --}}
    <div class="flex items-center gap-4">

        <div class="text-right">
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-xs text-[var(--muted-foreground)] capitalize">
                {{ auth()->user()->role }}
            </p>
        </div>

        <img
            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
            class="w-10 h-10 rounded-full border border-gray-300 object-cover"
        >

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-3 py-1 text-sm text-red-600 border border-red-600 rounded-md hover:bg-red-50">
                Logout
            </button>
        </form>
    </div>

</header>
