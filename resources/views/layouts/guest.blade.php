<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CongreSmart') }} - Login</title>

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4">

    <div class="w-full max-w-md">

        {{-- Logo + Title --}}
        <div class="flex flex-col items-center text-center mb-8">
            <img
                src="{{ asset('images/sda-logo.png') }}"
                alt="SDA Logo"
                class="h-20 w-20 object-contain mb-4"
            />

            <h1 class="text-3xl font-bold tracking-tight">CongreSmart</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Church Management</p>
        </div>

        {{-- Card Wrapper --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-6">
            {{ $slot }}
        </div>

    </div>

</body>

</html>
