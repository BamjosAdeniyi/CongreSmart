<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pioneer SDA Church Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-900 via-teal-800 to-teal-900">
    {{-- Header --}}
    <header class="bg-white/10 backdrop-blur-sm border-b border-white/20">
        <div class="container mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center p-1">
                        <img src="{{ asset('images/sda-logo.png') }}" alt="Adventist Logo" class="w-8 h-8 object-contain" />
                    </div>
                    <div>
                        <h1 class="text-white text-lg md:text-xl">Pioneer SDA Church</h1>
                        <p class="text-yellow-200 text-xs">Management System</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="bg-yellow-500 text-teal-900 hover:bg-yellow-400 px-4 py-2 rounded-lg font-medium transition-colors">
                    Sign In
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <main class="container mx-auto px-4 md:px-6">
        <div class="py-12 md:py-20 text-center">
            <div class="max-w-3xl mx-auto">
                {{-- SDA Logo --}}
                <div class="mb-8 flex justify-center">
                    <div class="relative">
                        <div class="w-24 h-24 md:w-28 md:h-28 bg-white rounded-2xl flex items-center justify-center border-4 border-yellow-500/50 p-3 shadow-2xl">
                            <img src="{{ asset('images/sda-logo.png') }}" alt="Seventh-day Adventist Logo" class="w-16 h-16 md:w-20 md:h-20 object-contain" />
                        </div>
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-yellow-500 text-teal-900 px-4 py-1 rounded-full text-xs whitespace-nowrap">
                            Seventh-day Adventist
                        </div>
                    </div>
                </div>

                <h2 class="text-3xl md:text-5xl text-white mb-4 md:mb-6">
                    Pioneer Seventh-Day Adventist Church
                </h2>
                <p class="text-lg md:text-xl text-yellow-100 mb-8 md:mb-12">
                    Comprehensive Church Management System
                </p>

                {{-- Features Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6 text-white hover:bg-white/20 transition-colors">
                        <svg class="w-8 h-8 mb-3 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="text-base mb-2">Member Management</h3>
                        <p class="text-sm text-yellow-100">
                            Track member information, baptismal status, and church roles
                        </p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6 text-white hover:bg-white/20 transition-colors">
                        <svg class="w-8 h-8 mb-3 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-base mb-2">Sabbath School</h3>
                        <p class="text-sm text-yellow-100">
                            Manage classes, attendance, and assignments
                        </p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6 text-white hover:bg-white/20 transition-colors">
                        <svg class="w-8 h-8 mb-3 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="text-base mb-2">Financial Tracking</h3>
                        <p class="text-sm text-yellow-100">
                            Record tithes, offerings, and generate financial reports
                        </p>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="inline-block bg-yellow-500 text-teal-900 hover:bg-yellow-400 text-base px-8 py-6 rounded-lg shadow-xl font-medium transition-colors">
                    Access Church System
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="py-8 border-t border-white/20 text-center">
            <p class="text-yellow-100 text-sm">
                &copy; 2025 Pioneer Seventh-Day Adventist Church. All rights reserved.
            </p>
            <p class="text-yellow-200 text-xs mt-2">
                "Keep the Sabbath day holy" - Exodus 20:8
            </p>
        </div>
    </main>
</body>
</html>

