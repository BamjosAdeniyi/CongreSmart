<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'CongreSmart' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[var(--background)] text-[var(--foreground)]">

    {{-- Mobile Sidebar Overlay --}}
    <div id="mobile-overlay"
        class="fixed inset-0 bg-black/40 z-40 hidden"
        onclick="toggleSidebar()">
    </div>

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- Main Content --}}
    <div class="lg:ml-[260px] min-h-screen transition-all">
        
        {{-- Topbar --}}
        <x-topbar :title="$title ?? ''" />

        {{-- Page Content --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
