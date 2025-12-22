<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veritas CMS</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

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
            overflow: hidden; /* Prevent body scroll for app-like layout */
        }
        .sidebar-gradient {
            background: radial-gradient(circle at center, #114629 0%, #092c19 100%);
        }

        /* Layout Styles */
        #sidebar-wrapper {
            height: 100vh; /* Full height */
            width: 280px;
            margin-left: 0;
            transition: margin .25s ease-out;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto; /* Sidebar scrolls internally */
            background: radial-gradient(circle at center, #114629 0%, #092c19 100%); /* Applied directly to wrapper */
        }

        #page-content-wrapper {
            margin-left: 280px;
            transition: margin .25s ease-out;
            width: calc(100% - 280px);
            height: 100vh; /* Full height */
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Wrapper doesn't scroll */
            position: relative; /* Context for absolute navbar */
        }

        /* Main content area that scrolls */
        #main-scroll-container {
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding-top: 80px; /* Space for fixed navbar */
        }

        /* Glassmorphism Navbar */
        .glass-header {
            background-color: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: absolute; /* Overlay content */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1020;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                margin-left: -280px;
            }
            #page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }

            /* Overlay when sidebar is active on mobile */
            #wrapper.toggled #page-content-wrapper::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1030;
                cursor: pointer;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            @include('partials.staff.sidebar')
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Navbar -->
            @include('partials.staff.navbar')

            <!-- Main Content Scrollable Area -->
            <div id="main-scroll-container">
                <main class="flex-grow-1 p-4">
                    @yield('content')
                </main>

                <!-- Footer -->
                @include('partials.staff.footer')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('sidebarToggle');
            const wrapper = document.getElementById('wrapper');

            if(toggleButton) {
                toggleButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }

            // Close sidebar when clicking overlay (pseudo-element click handling via document)
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && wrapper.classList.contains('toggled')) {
                    // Check if click is outside sidebar and toggle button
                    const sidebar = document.getElementById('sidebar-wrapper');
                    const toggle = document.getElementById('sidebarToggle');

                    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                        wrapper.classList.remove('toggled');
                    }
                }
            });
        });
    </script>
</body>
</html>
