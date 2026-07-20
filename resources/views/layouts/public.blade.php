<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Dynamic Meta tags from settings -->
        @php
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $companyName = $settings['company_name'] ?? 'RubiKnows';
            $seoDescription = $settings['seo_description'] ?? 'World-class engineering, construction, and consultancy services.';
        @endphp

        <title>{{ isset($title) ? $title . ' | ' . $companyName : $companyName }}</title>
        <meta name="description" content="{{ $seoDescription }}">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/LOGO.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|playfair+display:400,500,600,700,800,900&family=jetbrains+mono:400,500,600&display=swap" rel="stylesheet" />

        <!-- Alpine.js Intersect Plugin -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] antialiased text-brand-500 bg-white selection:bg-brand-500 selection:text-white flex flex-col min-h-screen">

        <!-- Minimalist Preloader -->
        <div id="preloader">
            <div class="preloader-text font-sans tracking-[0.2em] uppercase flex items-center justify-center">
                <span class="font-light text-black">RUBI</span><span class="text-white font-bold">KNOWS</span>
            </div>
            <div class="preloader-bar">
                <div class="preloader-bar-fill" id="preloader-bar-progress"></div>
            </div>
            <div class="preloader-counter" id="preloader-percent-wrapper">000</div>
        </div>

        <script>
        (function() {
            'use strict';
            if (sessionStorage.getItem('rubiknows_preloader_shown') === 'true') {
                document.getElementById('preloader').style.display = 'none';
                return;
            }
            document.body.style.overflow = 'hidden';

            var duration = 1800;
            var startTime = Date.now();
            var percentEl = document.getElementById('preloader-percent-wrapper');
            var barFill = document.getElementById('preloader-bar-progress');

            function tickPercent() {
                var elapsed = Date.now() - startTime;
                var pct = Math.min(100, Math.round((elapsed / duration) * 100));
                if (percentEl) percentEl.textContent = String(pct).padStart(3, '0');
                if (barFill) barFill.style.width = pct + '%';
                if (pct < 100) {
                    requestAnimationFrame(tickPercent);
                }
            }

            window.addEventListener('load', function() {
                var elapsed = Date.now() - startTime;
                var remaining = Math.max(0, duration - elapsed);

                setTimeout(function() {
                    if (percentEl) percentEl.textContent = '100';
                    if (barFill) barFill.style.width = '100%';

                    setTimeout(function() {
                        var loader = document.getElementById('preloader');
                        if (loader) {
                            loader.style.transition = 'opacity 0.5s ease';
                            loader.style.opacity = '0';
                            setTimeout(function() {
                                loader.remove();
                                sessionStorage.setItem('rubiknows_preloader_shown', 'true');
                                document.body.style.overflow = '';
                            }, 500);
                        }
                    }, 200);
                }, remaining);
            });

            requestAnimationFrame(tickPercent);
        })();
        </script>

        <!-- Navigation -->
        <nav x-data="{ open: false }" class="fixed w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/80 transition-all duration-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('public.home') }}" class="flex items-center group">
                            <img src="/LOGO.png" alt="RubiKnows" class="h-10 w-auto object-contain mr-3 transition-transform duration-500 group-hover:scale-105">
                            <span class="text-2xl font-['Inter'] tracking-tight transition-colors duration-500 inline-flex items-center">
                                <span class="font-light text-black">RUBI</span><span class="font-bold text-[#E07B2A]">KNOWS</span>
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <a href="{{ route('public.home') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.home') ? 'text-brand-500 active' : 'text-brand-400' }}">Home</a>
                        <a href="{{ route('public.about') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.about') ? 'text-brand-500 active' : 'text-brand-400' }}">About</a>
                        <a href="{{ route('public.services') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.services') ? 'text-brand-500 active' : 'text-brand-400' }}">Services</a>
                        <a href="{{ route('public.projects') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.projects') ? 'text-brand-500 active' : 'text-brand-400' }}">Project Portfolio</a>
                        <a href="{{ route('public.gallery') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.gallery') ? 'text-brand-500 active' : 'text-brand-400' }}">Media Gallery</a>
                        <a href="{{ route('public.testimonials') }}" class="nav-link-underline text-[13px] font-medium transition-colors hover:text-brand-500 {{ request()->routeIs('public.testimonials') ? 'text-brand-500 active' : 'text-brand-400' }}">Testimonials</a>
                        <a href="{{ route('public.contact') }}" class="btn-primary text-[12px] !py-1.5 !px-4">
                            Contact Us
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center lg:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2.5 rounded-full border border-brand-200 text-brand-500 hover:bg-brand-50 transition duration-150">
                            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': !open}" class="lg:hidden bg-white/95 backdrop-blur-xl border-b border-brand-100">
                <div class="px-4 pt-2 pb-6 space-y-1">
                    <a href="{{ route('public.home') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.home') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">Home</a>
                    <a href="{{ route('public.about') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.about') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">About</a>
                    <a href="{{ route('public.services') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.services') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">Services</a>
                    <a href="{{ route('public.projects') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.projects') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">Project Portfolio</a>
                    <a href="{{ route('public.gallery') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.gallery') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">Media Gallery</a>
                    <a href="{{ route('public.testimonials') }}" class="block px-4 py-3 rounded-xl text-[15px] font-medium {{ request()->routeIs('public.testimonials') ? 'text-brand-500 bg-brand-50' : 'text-brand-400 hover:text-brand-500 hover:bg-brand-50' }}">Testimonials</a>
                    <a href="{{ route('public.contact') }}" class="block px-4 py-3 mt-3 text-center rounded-xl text-[15px] font-semibold text-white bg-brand-500">Contact Us</a>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-grow pt-20">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-brand-500 text-white">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between flex-wrap">
                            <div class="flex items-center">
                                <span class="flex p-1.5 rounded-lg bg-white/10 mr-3">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <p class="font-medium text-sm">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-4 text-white/70 hover:text-white transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="relative bg-gray-950 text-white pt-20 pb-10 overflow-hidden border-t border-white/5">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(ellipse at top left, rgba(224,123,42,0.12), transparent 55%), radial-gradient(ellipse at bottom right, rgba(255,255,255,0.05), transparent 55%);"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 pb-12">
                    <!-- Brand Section -->
                    <div class="lg:col-span-5 flex flex-col justify-between">
                        <div>
                            <a href="{{ route('public.home') }}" class="inline-flex items-center gap-3.5 group mb-5">
                                <img src="/LOGO.png" alt="RubiKnows Logo" class="h-10 w-auto object-contain transition-transform duration-700 group-hover:scale-[1.08] group-hover:rotate-1">
                                <span class="text-2xl font-['Inter'] tracking-tight transition-colors duration-700 inline-flex items-center">
                                    <span class="font-extralight text-white/90">RUBI</span><span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-400 to-orange-500">KNOWS</span>
                                </span>
                            </a>
                            <p class="text-gray-300 text-base leading-relaxed max-w-md">
                                {{ $seoDescription }}
                            </p>
                        </div>

                        <div class="mt-10">
                            <h4 class="text-[11px] font-semibold text-gray-400 tracking-[0.3em] uppercase font-mono mb-4">Start a Project</h4>
                            <div class="flex flex-wrap gap-4 items-center">
                                <a href="{{ route('public.contact', ['tab' => 'quote']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-orange-500/30 rounded-full text-[11px] font-bold font-mono text-white bg-gradient-to-r from-orange-600 to-amber-500 shadow-lg shadow-orange-500/20 hover:shadow-xl hover:shadow-orange-500/40 hover:-translate-y-0.5 transition-all duration-500">
                                    INITIATE_PROPOSAL
                                </a>
                                <div class="flex items-center space-x-3">
                                    @if(!empty($settings['social_facebook']))
                                        <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:text-orange-400 hover:bg-orange-500/10 hover:border-orange-500/30 transition-all duration-300">
                                            <span class="sr-only">Facebook</span>
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                        </a>
                                    @endif
                                    @if(!empty($settings['social_linkedin']))
                                        <a href="{{ $settings['social_linkedin'] }}" target="_blank" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:text-orange-400 hover:bg-orange-500/10 hover:border-orange-500/30 transition-all duration-300">
                                            <span class="sr-only">LinkedIn</span>
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Directory Section -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-10 lg:gap-12">
                        <div>
                            <h3 class="text-[11px] font-semibold text-gray-400 tracking-[0.3em] uppercase font-mono mb-5">
                                Company
                            </h3>
                            <ul class="space-y-3.5 text-base">
                                <li><a href="{{ route('public.about') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">About Us</a></li>
                                <li><a href="{{ route('public.projects') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Portfolio</a></li>
                                <li><a href="{{ route('public.careers') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Careers</a></li>
                                <li><a href="{{ route('public.contact') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Contact</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-[11px] font-semibold text-gray-400 tracking-[0.3em] uppercase font-mono mb-5">
                                Services
                            </h3>
                            <ul class="space-y-3.5 text-base">
                                <li><a href="{{ route('public.services') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Engineering</a></li>
                                <li><a href="{{ route('public.services') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Construction</a></li>
                                <li><a href="{{ route('public.services') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Consultancy</a></li>
                                <li><a href="{{ route('public.services') }}" class="text-white/80 hover:text-orange-300 hover:translate-x-1 transition-all duration-300 inline-block">Design & Build</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-[11px] font-semibold text-gray-400 tracking-[0.3em] uppercase font-mono mb-5">
                                Contact
                            </h3>
                            <ul class="space-y-4 text-base text-white/80">
                                @if(!empty($settings['office_address']))
                                    <li class="flex items-start">
                                        <svg class="h-4 w-4 mr-3 text-orange-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="leading-relaxed">{{ $settings['office_address'] }}</span>
                                    </li>
                                @endif
                                @if(!empty($settings['contact_phone']))
                                    <li class="flex items-center">
                                        <svg class="h-4 w-4 mr-3 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <a href="tel:{{ $settings['contact_phone'] }}" class="hover:text-orange-300 transition-colors duration-300 font-mono text-sm">{{ $settings['contact_phone'] }}</a>
                                    </li>
                                @endif
                                @if(!empty($settings['contact_email']))
                                    <li class="flex items-center">
                                        <svg class="h-4 w-4 mr-3 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-orange-300 transition-colors duration-300 font-mono text-sm">{{ $settings['contact_email'] }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Copyright -->
                <div class="mt-8 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-400 font-mono">
                        &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-8 text-sm">
                        <a href="#" class="text-gray-300 hover:text-orange-300 transition-all duration-300">Privacy Policy</a>
                        <span class="text-white/20 text-xs">•</span>
                        <a href="#" class="text-gray-300 hover:text-orange-300 transition-all duration-300">Terms of Service</a>
                        @if (Route::has('login'))
                            <span class="text-white/20 text-xs hidden sm:inline">•</span>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-sm font-mono text-white hover:text-orange-300 hover:bg-orange-500/10 hover:border-orange-500/30 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                DevPortal
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
