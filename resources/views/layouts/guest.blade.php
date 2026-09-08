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
        
        <!-- Left Panel: Brand & Animation -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#f8f9fc] overflow-hidden items-center justify-center">
            <!-- Animated Light Grid -->
            <div class="absolute inset-0 bg-grid-pattern opacity-40 animate-grid-pan pointer-events-none"></div>
            
            <!-- Floating Elements / Orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-brand-500/10 rounded-full blur-[80px] animate-pulse-soft"></div>
            <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-blue-500/10 rounded-full blur-[100px] animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <div class="relative z-10 max-w-lg px-12 text-center animate-slide-up">
                <!-- Large Logo -->
                <div class="flex justify-center mb-10">
                    <div class="w-32 h-32  bg-white shadow-2xl shadow-brand-500/10 flex items-center justify-center transform transition duration-500 hover:scale-105 border border-gray-100">
                        <img src="{{ asset('RK3.png') }}" alt="RubiKnows Logo" class="w-24 h-24 object-contain">
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight font-['Roboto_Slab'] mb-4">
                    Engineering <span class="text-brand-500">Excellence</span>
                </h1>
                <p class="text-lg text-gray-500 leading-relaxed">
                    Welcome to the central command portal. Manage your projects, review client inquiries, and oversee your portfolio with precision.
                </p>
                
                <!-- Decorative animated dots -->
                <div class="mt-12 flex justify-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-bounce"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-300 animate-bounce" style="animation-delay: 0.2s"></span>
                </div>
            </div>
        </div>

        <!-- Right Panel: Form Area -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative bg-white">
            <!-- Mobile Background Elements (hidden on desktop) -->
            <div class="absolute inset-0 lg:hidden overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-[60px]"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/5 rounded-full blur-[60px]"></div>
            </div>

            <div class="w-full max-w-md relative z-10 animate-fade-in">
                <!-- Mobile Logo (hidden on desktop) -->
                <div class="flex justify-center mb-10 lg:hidden">
                    <a href="/" class="inline-block transform transition duration-300 hover:scale-105">
                        <img src="{{ asset('RK3.png') }}" alt="RubiKnows" class="w-16 object-contain">
                    </a>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight font-['Roboto_Slab']">
                        Admin Portal
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm">
                        Sign in to access your dashboard and manage content.
                    </p>
                </div>

                <!-- Form Slot -->
                <div class="bg-white lg:bg-transparent p-8 lg:p-0  lg:rounded-none shadow-xl lg:shadow-none border border-gray-100 lg:border-none">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <div class="mt-12 text-center lg:text-left text-xs text-gray-400">
                    &copy; {{ date('Y') }} RubiKnows Engineering. All rights reserved.
                </div>
            </div>
        </div>
    </body>
</html>
