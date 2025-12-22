<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Veritas CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .bg-brand-green { background-color: #114629; }
        .text-brand-green { color: #114629; }
    </style>
</head>
<body class="bg-gray-50 h-screen w-full flex overflow-hidden">
    <!-- Left Side - Image/Branding -->
    <div class="hidden lg:flex w-1/2 bg-brand-green items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491827/Vuna-1971.jpg-_k99bco.jpg')] bg-cover bg-center opacity-20"></div>
        <div class="relative z-10 text-white text-center px-12 max-w-2xl">
            <h1 class="text-5xl font-bold mb-6 tracking-tight">Veritas University</h1>
            <p class="text-xl text-green-100 leading-relaxed font-light">
                Welcome to the Staff Content Management System. <br>
                Securely manage academic resources, news, and administrative content.
            </p>
        </div>
        <!-- Decoration -->
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-green-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-green-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white relative">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center lg:text-left">
                <span class="bg-green-100 text-brand-green text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Staff Access</span>
                <h2 class="mt-4 text-3xl font-bold text-gray-900 tracking-tight">Sign in to your account</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your staff credentials to access the dashboard.
                </p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('status'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('staff.login') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition duration-150 ease-in-out placeholder-gray-400"
                                placeholder="staff@veritas.edu.ng">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition duration-150 ease-in-out placeholder-gray-400"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900 cursor-pointer">Remember me</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-brand-green hover:text-green-800 transition-colors">Forgot password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-brand-green hover:bg-[#0d3821] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-300 group-hover:text-green-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Sign in Securely
                    </button>
                </div>
            </form>

            <div class="mt-8 border-t border-gray-100 pt-6 text-center">
                <p class="text-sm text-gray-500">
                    Are you a student?
                    <a href="{{ route('student.login') }}" class="font-bold text-brand-green hover:text-green-800 transition-colors ml-1">
                        Go to Student Portal &rarr;
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="absolute bottom-4 w-full text-center">
             <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Veritas University. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
