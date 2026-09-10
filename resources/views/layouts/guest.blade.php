<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @if(request()->routeIs('login'))
                Admin Login | RubiKnows
            @elseif(request()->routeIs('register'))
                Register | RubiKnows
            @elseif(request()->routeIs('password.request'))
                Forgot Password | RubiKnows
            @else
                RubiKnows
            @endif
        </title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('LOGO.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|roboto-slab:600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white flex min-h-screen selection:bg-brand-500 selection:text-white">

        <!-- Left Panel: Brand -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#f8f9fc] overflow-hidden">
            <!-- Subtle Animated Grid -->
            <div class="absolute inset-0 bg-grid-pattern opacity-20 pointer-none"></div>

            <div class="relative z-10 flex h-full w-full flex-col items-center justify-center px-8 pt-16 pb-24 text-center">
                <!-- Logo -->
                <div class="mb-10">
                    <div class="w-36 h-36 bg-transparent flex items-center justify-center">
                        <img src="{{ asset('RK3.png') }}" alt="RubiKnows Logo" class="w-28 h-28 object-contain">
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight font-['Roboto_Slab'] mb-2">
                    Engineering <span class="text-brand-500">Excellence</span>
                </h1>
                <p class="max-w-xl text-lg text-gray-500 leading-relaxed mb-6">
                    Secure access to your engineering projects and portfolio management tools.
                </p>
            </div>
        </div>

        <!-- Right Panel: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md space-y-8">
                <!-- Mobile Logo (hidden on desktop) -->
                <div class="flex justify-center mb-6 lg:hidden">
                    <a href="/" class="inline-block transform transition duration-300 hover:scale-105">
                        <img src="{{ asset('RK3.png') }}" alt="RubiKnows" class="w-16 object-contain">
                    </a>
                </div>

                <div class="text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Welcome Back
                    </h2>
                    <p class="text-gray-600 mb-4">
                        Sign in to continue to RubiKnows Admin Portal
                    </p>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-8">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} RubiKnows Engineering. All rights reserved.
                </div>
            </div>
        </div>
    </body>
</html>