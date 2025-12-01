<x-guest-layout>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email --}}
        <div class="space-y-1">
            <label for="email" class="text-sm font-medium">Email</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}"
                   required 
                   autofocus
                   class="w-full px-3 py-2 rounded-[var(--radius)]
                          border border-[var(--border)]
                          bg-[var(--input-background)]
                          focus:ring-2 focus:ring-[var(--primary)] focus:outline-none
                          text-[var(--foreground)]">
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <label for="password" class="text-sm font-medium">Password</label>
            <input id="password" 
                   name="password" 
                   type="password" 
                   required
                   class="w-full px-3 py-2 rounded-[var(--radius)]
                          border border-[var(--border)]
                          bg-[var(--input-background)]
                          focus:ring-2 focus:ring-[var(--primary)] focus:outline-none
                          text-[var(--foreground)]">
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" 
                       class="h-4 w-4 rounded border-[var(--border)]">
                <span>Remember me</span>
            </label>

            <a href="{{ route('password.request') }}"
               class="text-[var(--primary)] hover:underline">
                Forgot password?
            </a>
        </div>

        {{-- Login Button --}}
        <button type="submit"
                class="w-full py-2 rounded-[var(--radius)]
                       bg-[var(--primary)] text-[var(--primary-foreground)]
                       font-semibold hover:bg-opacity-90 transition">
            Log in
        </button>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mt-2 text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

    </form>

</x-guest-layout>
