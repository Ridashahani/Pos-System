<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

    @vite('resources/css/app.css')
    @stack('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">

    <!-- Sidebar -->
    <x-sidebar />

    <div class="flex flex-col flex-1 min-h-screen ml-[280px]">
        <!-- Header -->
        <x-header />

        <!-- Main Content -->
        <main class="main-content flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>

        <!-- Footer -->
        <x-footer />
    </div>

</body>

</html>
