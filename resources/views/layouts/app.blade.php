<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CongreSmart' }} - {{ config('app.name', 'Church Management') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 h-full">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden md:ml-64">
            {{-- Navbar --}}
            <x-navbar :title="$title ?? ''" />

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
