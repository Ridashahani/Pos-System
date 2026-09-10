<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

<link rel="stylesheet" href="{{ asset('css/pos.css') }}"> 
    @stack('styles')

</head>

<body>

    <!-- Sidebar -->
    <x-sidebar />
    <main class="main-content">
        @yield('content')
    </main>

</body>

</html>