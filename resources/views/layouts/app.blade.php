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


    {{-- <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f8;
        }

        .main-content {
            margin-left: 300px;
            padding: 30px;
            min-height: 100vh;
        }

    </style> --}}

</body>

</html>