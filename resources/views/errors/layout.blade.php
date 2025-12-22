<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Veritas CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .bg-brand-green { background-color: #114629; }
        .text-brand-green { color: #114629; }
        .bg-brand-gold { background-color: #ffc107; }
        .text-brand-gold { color: #ffc107; }
    </style>
</head>
<body class="bg-gray-50 h-screen w-full flex items-center justify-center p-4 overflow-hidden relative">
    
    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-2 bg-brand-green"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="max-w-lg w-full text-center relative z-10 bg-white p-8 md:p-12 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
        <!-- Icon Wrapper -->
        <div class="mb-6 flex justify-center">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center">
                @yield('icon')
            </div>
        </div>
        
        <h1 class="text-6xl font-bold text-brand-green mb-2 tracking-tighter">@yield('code')</h1>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">@yield('message')</h2>
        <p class="text-gray-500 mb-8 leading-relaxed px-4">@yield('description')</p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-3">
            @yield('actions')
            
            @unless(View::hasSection('hide_home'))
            <a href="{{ url('/') }}" class="px-6 py-2.5 rounded-full bg-brand-green text-white font-medium hover:bg-green-900 transition-all shadow-lg shadow-green-900/20 hover:shadow-green-900/30 flex items-center justify-center gap-2">
                <i class="fa-solid fa-house text-sm"></i>
                Back to Home
            </a>
            @endunless
        </div>
    </div>

    <div class="absolute bottom-6 text-center w-full text-gray-400 text-xs">
        &copy; {{ date('Y') }} Veritas University. All rights reserved.
    </div>
</body>
</html>
