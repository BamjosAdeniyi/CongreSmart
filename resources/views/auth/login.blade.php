<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CongreSmart - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 p-4">
    <div class="w-full max-w-md bg-white rounded-xl border border-gray-200 shadow-lg">
        <div class="p-6 space-y-1 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-15 h-15 rounded-full flex items-center justify-center">
                    <img src="{{ asset('images/sda-logo.png') }}" alt="SDA Logo" class="w-14 h-14 object-contain" />
                </div>
            </div>
            <h1 class="text-2xl font-semibold">CongreSmart</h1>
            <p class="text-sm text-gray-500">Intelligent Church Membership & Attendance Management</p>
        </div>

        <div class="px-6 pb-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <input id="email"
                               name="email"
                               type="email"
                               value="{{ old('email') }}"
                               placeholder="your.email@church.com"
                               required
                               autofocus
                               class="w-full pl-10 pr-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm">
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="••••••••"
                               required
                               class="w-full pl-10 pr-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm">
                    </div>
                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Login Button --}}
                <button type="submit"
                        class="w-full h-9 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors text-sm">
                    Sign In
                </button>
            </form>

            {{-- Demo Accounts Section --}}
            <div class="mt-6">
                <button type="button" onclick="toggleDemoAccounts()" class="w-full h-9 px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-50 transition-colors text-sm font-medium">
                    <span id="demoToggleText">Show</span> Demo Accounts
                </button>
            </div>

            <div id="demoAccounts" class="hidden mt-4 p-4 bg-blue-50 rounded-lg space-y-2">
                <p class="text-sm font-medium mb-2">Demo Accounts:</p>
                <div class="text-xs space-y-2">
                    <div>
                        <span class="text-gray-600 font-medium">Pastor/Elder:</span>
                        <div class="ml-2 mt-1">Email: pastor@church.com</div>
                        <div class="ml-2">Password: pastor123</div>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Church Clerk:</span>
                        <div class="ml-2 mt-1">Email: clerk@church.com</div>
                        <div class="ml-2">Password: clerk123</div>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">SS Superintendent:</span>
                        <div class="ml-2 mt-1">Email: superintendent@church.com</div>
                        <div class="ml-2">Password: super123</div>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">SS Coordinator:</span>
                        <div class="ml-2 mt-1">Email: coordinator1@church.com</div>
                        <div class="ml-2">Password: coord123</div>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Financial Secretary:</span>
                        <div class="ml-2 mt-1">Email: financial@church.com</div>
                        <div class="ml-2">Password: finance123</div>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">ICT Admin:</span>
                        <div class="ml-2 mt-1">Email: ict@church.com</div>
                        <div class="ml-2">Password: ict123</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDemoAccounts() {
            const demoDiv = document.getElementById('demoAccounts');
            const toggleText = document.getElementById('demoToggleText');
            if (demoDiv.classList.contains('hidden')) {
                demoDiv.classList.remove('hidden');
                toggleText.textContent = 'Hide';
            } else {
                demoDiv.classList.add('hidden');
                toggleText.textContent = 'Show';
            }
        }
    </script>
</body>
</html>
