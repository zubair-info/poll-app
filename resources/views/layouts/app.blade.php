<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Poll App' }}</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-indigo-600 text-white p-4 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Poll App</h1>
            <nav class="space-x-4">
                <a href="/" class="hover:underline">Home</a>
                <a href="/admin/polls" class="hover:underline">Admin</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-gray-700 p-4 text-center">
        &copy; {{ date('Y') }} Poll App. All rights reserved.
    </footer>

    @livewireScripts
</body>

</html>
