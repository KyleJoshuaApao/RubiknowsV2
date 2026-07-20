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
        <link rel="icon" type="image/png" href="/LOGO.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|roboto-slab:600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] antialiased text-gray-900 bg-gray-50 flex items-center justify-center min-h-screen relative overflow-hidden">

        <!-- Elegant Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-500 opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -left-20 w-72 h-72 bg-gray-400 opacity-10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full sm:max-w-md bg-white/80 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-200 p-8 sm:p-10 relative z-10 mx-4">
            <!-- Centered Logo -->
            <div class="flex justify-center mb-8">
                <a href="/" class="inline-block transform transition duration-300 hover:scale-105">
                    <x-application-logo />
                </a>
            </div>

            <div class="mb-8 text-center">
                <h2 class="text-xl font-semibold text-gray-800 tracking-tight">Admin Portal</h2>
                <p class="text-sm text-gray-500 mt-1">Sign in to manage your content.</p>
            </div>

            <!-- Login Form -->
            <div class="w-full">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
