<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CongreSmart') }} - Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-[var(--background)] text-[var(--foreground)] px-4">

    <div class="w-full max-w-md">

        {{-- Logo + Title --}}
        <div class="flex flex-col items-center text-center mb-8">
            <img 
                src="{{ asset('images/sda-logo.png') }}" 
                alt="SDA Logo"
                class="h-20 w-20 object-contain mb-4"
            />

            <h1 class="text-3xl font-bold tracking-tight">CongreSmart</h1>
            <p class="text-sm text-[var(--muted-foreground)]">Church Management</p>
        </div>

        {{-- Card Wrapper --}}
        <div class="bg-[var(--card)] border border-[var(--border)] rounded-lg shadow-md p-6">
            {{ $slot }}
        </div>

    </div>

</body>

</html>
