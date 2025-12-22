<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unauthorized Action</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                    403
                </div>

                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                    You are not authorized to perform this action.
                </div>
            </div>
            <div class="mt-8 text-center">
                <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 underline">Go Back</a>
                <span class="text-gray-400 mx-2">|</span>
                <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 underline">Go to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
