<nav class="text-sm text-gray-500 mb-1">
    <ol class="flex items-center gap-2">
        <li><a href="{{ route('dashboard') }}" class="hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-medium">
            {{ $title ?? '' }}
        </li>
    </ol>
</nav>
