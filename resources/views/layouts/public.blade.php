<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Dynamic Meta tags from settings -->
        @php
            $settings = Cache::remember('site_settings', 3600, fn() =>
                \App\Models\Setting::pluck('value', 'key')->toArray()
            );
            $companyName    = $settings['company_name'] ?? 'RubiKnows';
            $seoDescription = $settings['seo_description'] ?? 'World-class engineering, construction, and consultancy services.';
            $pageTitle      = isset($title) ? $title . ' | ' . $companyName : $companyName;
        @endphp

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $seoDescription }}">

        <!-- Open Graph / Social Sharing -->
        <meta property="og:type"        content="website">
        <meta property="og:url"         content="{{ url()->current() }}">
        <meta property="og:title"       content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:image"       content="{{ asset('LOGO.png') }}">
        <meta property="og:site_name"   content="{{ $companyName }}">
        <meta name="twitter:card"        content="summary_large_image">
        <meta name="twitter:title"       content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image"       content="{{ asset('LOGO.png') }}">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('LOGO.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|playfair+display:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Alpine.js Intersect Plugin is bundled via Vite -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white selection:bg-brand-500 selection:text-white flex flex-col min-h-screen">


        <!-- Navigation -->
        <nav x-data="{ open: false }" @click.outside="open = false" class="fixed w-full z-50 bg-white border-b border-gray-200/50 transition-all duration-500 shadow-[0_4px_30px_rgba(0,0,0,0.02)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-24">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('public.home') }}" class="flex items-center group relative">
                            <div class="absolute inset-0 bg-brand-500/10 blur-xl rounded-full scale-0 group-hover:scale-150 transition-transform duration-700"></div>
                            <img src="{{ asset('LOGO.png') }}" alt="RubiKnows" class="h-12 w-auto object-contain mr-3 relative z-10 transition-transform duration-700 group-hover:rotate-[5deg] group-hover:scale-110">
                            <span class="text-[26px] font-['Playfair_Display'] tracking-tight transition-colors duration-500 inline-flex items-center relative z-10">
                                <span class="font-normal text-gray-900">RUBI</span><span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-amber-500">KNOWS</span>
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center space-x-10">
                        @php
                            $navLinks = [
                                ['route' => 'public.home', 'label' => 'Home'],
                                ['route' => 'public.about', 'label' => 'About'],
                                ['route' => 'public.services', 'label' => 'Services'],
                                ['route' => 'public.projects', 'label' => 'Portfolio'],
                                ['route' => 'public.gallery', 'label' => 'Gallery'],
                                ['route' => 'public.testimonials', 'label' => 'Testimonials'],
                                ['route' => 'public.clients', 'label' => 'Clients'],
                            ];
                        @endphp
                        
                        @foreach($navLinks as $link)
                            <a href="{{ route($link['route']) }}" class="relative text-[13px] uppercase tracking-[0.1em] font-semibold transition-all duration-300 {{ request()->routeIs($link['route']) ? 'text-brand-600' : 'text-gray-500 hover:text-brand-500' }} group">
                                {{ $link['label'] }}
                                <span class="absolute -bottom-2 left-0 w-full h-[2px] bg-gradient-to-r from-brand-500 to-amber-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                            </a>
                        @endforeach
                        
                        <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-7 py-2.5 text-[12px] uppercase tracking-[0.15em] font-bold text-white bg-brand-500 rounded-full shadow-[0_4px_14px_0_rgba(224,123,42,0.39)] hover:shadow-[0_6px_20px_rgba(224,123,42,0.23)] hover:-translate-y-0.5 transition-all duration-300">
                            Contact Us
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center lg:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-3 rounded-full bg-gray-50 border border-gray-100 text-gray-900 hover:bg-gray-100 hover:text-brand-600 transition-all duration-300">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path x-show="!open" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" style="display: none;" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="lg:hidden absolute w-full bg-white border-b border-gray-100 shadow-2xl">
                <div class="px-6 pt-4 pb-8 space-y-2">
                    @foreach($navLinks as $link)
                        <a @click="open = false" href="{{ route($link['route']) }}" class="block px-4 py-3 rounded-2xl text-[14px] uppercase tracking-[0.1em] font-bold {{ request()->routeIs($link['route']) ? 'text-brand-600 bg-brand-50/50' : 'text-gray-500 hover:text-brand-500 hover:bg-gray-50' }} transition-colors">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <a @click="open = false" href="{{ route('public.contact') }}" class="block px-4 py-4 mt-6 text-center rounded-2xl text-[14px] uppercase tracking-[0.15em] font-bold text-white bg-gradient-to-r from-brand-600 to-amber-500 shadow-lg shadow-brand-500/20">Contact Us</a>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-grow pt-20">
            {{-- Flash toasts handled by RubiKnows toast system below --}}

            {{ $slot }}
        </main>

        <footer class="relative bg-[#050505] text-white pt-16 lg:pt-24 pb-12 overflow-hidden border-t border-white/10 shadow-[0_-20px_50px_rgba(0,0,0,0.5)]">
            <!-- Animated Background Grid -->
            <div class="absolute inset-0 bg-grid-pattern-dark opacity-[0.02] animate-grid-pan pointer-events-none"></div>
            
            <!-- Premium Lighting Effects -->
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-brand-500/10 rounded-full blur-[160px] pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[150px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 pb-16 border-b border-white/10">
                    <!-- Brand Section -->
                    <div class="lg:col-span-5 flex flex-col justify-between">
                        <div>
                            <a href="{{ route('public.home') }}" class="inline-flex items-center gap-4 group mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-2xl shadow-brand-500/10 transition-transform duration-700 group-hover:scale-110 group-hover:rotate-[5deg]">
                                    <img src="{{ asset('LOGO.png') }}" alt="RubiKnows Logo" class="w-10 h-10 object-contain">
                                </div>
                                <span class="text-3xl font-['Playfair_Display'] tracking-tight transition-colors duration-700 inline-flex items-center">
                                    <span class="font-normal text-white">RUBI</span><span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-amber-300">KNOWS</span>
                                </span>
                            </a>
                            <p class="text-gray-400 text-sm leading-loose max-w-md font-light">
                                {{ $seoDescription }} We engineer the future, blending world-class precision with visionary design.
                            </p>
                        </div>

                        <div class="mt-12">
                            <h4 class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-6">Start a Project</h4>
                            <div class="flex flex-wrap gap-5 items-center">
                                <a href="{{ route('public.contact', ['tab' => 'quote']) }}" class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden text-sm font-semibold text-white rounded-full bg-white/5 border border-white/10 hover:border-brand-500/50 transition-all duration-500 group">
                                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-brand-600/20 to-amber-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                    <span class="relative">Initiate Proposal</span>
                                    <svg class="w-4 h-4 ml-3 relative transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                                
                                <div class="flex items-center space-x-3">
                                    @if(!empty($settings['social_facebook']))
                                        <a href="{{ $settings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-brand-500 hover:border-brand-500 shadow-lg hover:shadow-brand-500/30 transition-all duration-500">
                                            <span class="sr-only">Facebook</span>
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                        </a>
                                    @endif
                                    @if(!empty($settings['social_linkedin']))
                                        <a href="{{ $settings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-600 hover:border-blue-600 shadow-lg hover:shadow-blue-600/30 transition-all duration-500">
                                            <span class="sr-only">LinkedIn</span>
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Directory Section -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-12 lg:gap-16">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-8">
                                Company
                            </h3>
                            <ul class="space-y-4 text-sm font-light">
                                <li><a href="{{ route('public.about') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> About Us</a></li>
                                <li><a href="{{ route('public.projects') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> Portfolio</a></li>
                                <li><a href="{{ route('public.clients') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> Clients & Partners</a></li>
                                <li><a href="{{ route('public.careers') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> Careers</a></li>
                                <li><a href="{{ route('public.contact') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> Contact</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-8">
                                Services
                            </h3>
                            <ul class="space-y-4 text-sm font-light">
                                @php
                                    $footerServices = \App\Models\Service::latest()->take(4)->get();
                                @endphp
                                @foreach($footerServices as $fs)
                                    <li><a href="{{ route('public.services') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 inline-flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-500 opacity-0 -ml-3 transition-all duration-300"></span> {{ $fs->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-8">
                                Global HQ
                            </h3>
                            <ul class="space-y-6 text-sm text-gray-400 font-light">
                                @if(!empty($settings['office_address']))
                                    <li class="flex items-start group cursor-default">
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-brand-500/20 group-hover:text-brand-400 transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <span class="leading-relaxed mt-1">{{ $settings['office_address'] }}</span>
                                    </li>
                                @endif
                                @if(!empty($settings['contact_phone']))
                                    <li class="flex items-center group">
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-brand-500/20 group-hover:text-brand-400 transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <a href="tel:{{ $settings['contact_phone'] }}" class="hover:text-white transition-colors duration-300 text-sm">{{ $settings['contact_phone'] }}</a>
                                    </li>
                                @endif
                                @if(!empty($settings['contact_email']))
                                    <li class="flex items-center group">
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-brand-500/20 group-hover:text-brand-400 transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-white transition-colors duration-300 text-sm">{{ $settings['contact_email'] }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Copyright -->
                <div class="mt-8 pt-4 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-xs text-gray-500 tracking-wide">
                        &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-8 text-xs tracking-wide">
                        <a href="{{ route('public.privacy') }}" class="text-gray-500 hover:text-white transition-all duration-300">Privacy</a>
                        <a href="{{ route('public.terms') }}" class="text-gray-500 hover:text-white transition-all duration-300">Terms</a>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-gray-300 hover:text-brand-400 hover:bg-brand-500/10 hover:border-brand-500/30 transition-all duration-300">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Portal
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
        <!-- Cursor Tracking Script for Spotlights -->
        <script>
            document.addEventListener('mousemove', e => {
                document.querySelectorAll('.cursor-spotlight').forEach(el => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    el.style.setProperty('--x', `${x}px`);
                    el.style.setProperty('--y', `${y}px`);
                });
            });
        </script>

        <!-- RubiKnows Toast System -->
        <div id="rk-toast-container" class="fixed top-5 right-5 z-[99999] flex flex-col gap-3 pointer-events-none" aria-live="polite"></div>
        <script>
        (function () {
            var _c = document.getElementById('rk-toast-container');
            function rkToast(message, type) {
                type = type || 'success';
                var icons = {
                    success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    error:   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                };
                var bar = type === 'error' ? '#ef4444' : '#f97316';
                var label = type === 'error' ? 'Error' : 'Success';
                var t = document.createElement('div');
                t.setAttribute('data-rk-toast', '1');
                t.style.cssText = 'pointer-events:all;min-width:300px;max-width:380px;background:#fff;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.13),0 2px 8px rgba(0,0,0,0.07);overflow:hidden;transform:translateX(120%);opacity:0;transition:transform 0.38s cubic-bezier(.34,1.56,.64,1),opacity 0.25s ease;';
                t.innerHTML =
                    '<div style="height:3px;background:' + bar + ';border-radius:999px 999px 0 0"></div>' +
                    '<div style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px;">' +
                    '<div style="flex-shrink:0;width:34px;height:34px;border-radius:10px;background:' + bar + '18;display:flex;align-items:center;justify-content:center;">' +
                    '<svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="' + bar + '">' + (icons[type] || icons.success) + '</svg></div>' +
                    '<div style="flex:1;min-width:0;">' +
                    '<p style="font-size:10px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:' + bar + ';margin:0 0 2px 0;">' + label + '</p>' +
                    '<p style="font-size:13px;font-weight:500;color:#1a1a1a;margin:0;line-height:1.5;">' + message + '</p></div>' +
                    '<button onclick="var el=this.closest(\'[data-rk-toast]\');el.style.transform=\'translateX(120%)\';el.style.opacity=\'0\';setTimeout(function(){el.parentNode&&el.parentNode.removeChild(el);},400);" style="flex-shrink:0;padding:2px;background:none;border:none;cursor:pointer;color:#9ca3af;">' +
                    '<svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>' +
                    '</div>';
                _c.appendChild(t);
                requestAnimationFrame(function () { requestAnimationFrame(function () { t.style.transform = 'translateX(0)'; t.style.opacity = '1'; }); });
                setTimeout(function () { t.style.transform = 'translateX(120%)'; t.style.opacity = '0'; setTimeout(function () { t.parentNode && t.parentNode.removeChild(t); }, 400); }, 5000);
            }
            window.rkToast = rkToast;
            @if(session('success'))
            window.addEventListener('DOMContentLoaded', function () { rkToast({{ json_encode(session('success')) }}, 'success'); });
            @endif
            @if(session('error'))
            window.addEventListener('DOMContentLoaded', function () { rkToast({{ json_encode(session('error')) }}, 'error'); });
            @endif
        })();
        </script>
    </body>
</html>
