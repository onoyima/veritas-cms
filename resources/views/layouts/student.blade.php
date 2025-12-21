<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Veritas University') }} - Student Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f5f5f5;
        }
        .sidebar-gradient {
            background: radial-gradient(circle at center, #114629 0%, #092c19 100%);
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        @include('partials.student.sidebar')

        <div class="flex-grow-1 d-flex flex-column min-vh-100 overflow-hidden">
            <!-- Navbar -->
            @include('partials.student.navbar')

            <!-- Main Content -->
            <main class="flex-grow-1 overflow-auto bg-light p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
