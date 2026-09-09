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
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,900|dm-serif-display:400,400i&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Custom Scrollbar for Mega Menus */
            .mega-menu-scroll::-webkit-scrollbar {
                width: 6px;
            }
            .mega-menu-scroll::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }
            .mega-menu-scroll::-webkit-scrollbar-thumb {
                background: #E0A92A; 
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-700 bg-white flex flex-col min-h-screen selection:bg-brand-500 selection:text-white">

        <!-- ===== STYLISTIC NAVIGATION ===== -->
        <header x-data="{ mobileOpen: false }" class="w-full z-50 relative sticky top-0 bg-gray-100 shadow-sm border-b border-gray-300">
            <div class="flex items-stretch h-24 lg:h-28 w-full relative">
                
                <!-- Left: Logo Area with Stylistic Accents -->
                <div class="relative h-full flex items-center z-20">
                    <!-- The Gold Main Wing -->
                    <div class="absolute top-2 lg:top-3 left-0 h-[100%] w-[55%] bg-gold-600 kh-angled-logo shadow-xl -z-10 pointer-events-none"></div>
                    
                    <!-- The White Logo Background -->
                    <div class="absolute inset-0 bg-white kh-angled-logo shadow-md -z-10 pointer-events-none"></div>
                    
                    <a href="{{ route('public.home') }}" class="flex items-center gap-3 pl-4 sm:pl-8 lg:pl-12 pr-16 lg:pr-32 py-2">
                        <img src="{{ asset('RK3.png') }}" alt="RubiKnows" class="h-14 sm:h-16 lg:h-20 w-auto">
                        <div class="flex flex-col mt-1">
                            <span class="flex items-baseline">
                                <span class="text-2xl sm:text-3xl lg:text-4xl font-light tracking-tight text-richblack-950">RUBI</span>
                                <span class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-brand-500 ml-[1px]">KNOWS</span>
                            </span>
                            <span class="text-[10px] lg:text-[11px] font-medium text-gray-600 tracking-[0.2em] uppercase mt-0.5 whitespace-nowrap hidden sm:block">
                                CORPORATION
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Right: Desktop Navigation -->
                <nav class="hidden lg:flex items-center flex-1 justify-end space-x-1 xl:space-x-4 h-full pr-6 lg:pr-12">
                    <a href="{{ route('public.home') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Home
                    </a>
                    <a href="{{ route('public.about') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        About Us
                    </a>
                    <a href="{{ route('public.services') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Services
                    </a>
                    <a href="{{ route('public.projects') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Projects
                    </a>
                    <a href="{{ route('public.gallery') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Gallery
                    </a>
                    <a href="{{ route('public.testimonials') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Testimonials
                    </a>
                    <a href="{{ route('public.clients') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Clients
                    </a>
                    <a href="{{ route('public.careers') }}" class="text-[13px] xl:text-[14px] font-bold uppercase tracking-widest text-charcoal-700 hover:text-brand-500 transition-colors px-3 py-2 flex items-center h-full border-b-4 border-transparent hover:border-brand-500">
                        Careers
                    </a>

                    <div class="flex items-center h-full ml-4 xl:ml-6">
                        <a href="{{ route('public.contact') }}" class="btn-primary">
                            Contact Us
                        </a>
                    </div>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden ml-auto pr-6">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 text-charcoal-700 hover:text-brand-500 focus:outline-none z-50">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" @click.outside="mobileOpen = false" style="display: none;"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="lg:hidden bg-white border-t-4 border-brand-500 absolute w-full shadow-2xl z-50">
                <div class="px-6 py-6 flex flex-col space-y-4">
                    <a @click="mobileOpen = false" href="{{ route('public.home') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Home</a>
                    <a @click="mobileOpen = false" href="{{ route('public.about') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">About</a>
                    <a @click="mobileOpen = false" href="{{ route('public.services') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Services</a>
                    <a @click="mobileOpen = false" href="{{ route('public.projects') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Portfolio</a>
                    <a @click="mobileOpen = false" href="{{ route('public.gallery') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Gallery</a>
                    <a @click="mobileOpen = false" href="{{ route('public.testimonials') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Testimonials</a>
                    <a @click="mobileOpen = false" href="{{ route('public.clients') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Clients</a>
                    <a @click="mobileOpen = false" href="{{ route('public.careers') }}" class="text-xl font-black text-richblack-900 hover:text-brand-500 uppercase tracking-tight">Careers</a>
                    <a @click="mobileOpen = false" href="{{ route('public.contact') }}" class="mt-4 text-center px-6 py-3 bg-brand-500 text-white font-black uppercase tracking-widest text-[14px]">Contact Us</a>
                </div>
            </div>
        </header>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- ===== KIMLEY-HORN STYLE "FAT" FOOTER (RESTORED LINKS) ===== -->
        <footer class="bg-richblack-950 text-white pt-24 pb-12 mt-auto border-t-[16px] border-brand-500 relative overflow-hidden">
            <!-- Decorative geometric element -->
            <div class="absolute bottom-0 right-0 w-1/3 h-1/2 bg-white/5 kh-angled-deco-right"></div>
            
            <div class="max-w-screen-2xl mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-16 pb-16">
                    
                    <!-- Brand Section -->
                    <div class="lg:col-span-5 pr-8">
                        <a href="{{ route('public.home') }}" class="inline-flex items-center gap-3 mb-8">
                            <img src="{{ asset('RK3.png') }}" alt="RubiKnows" class="h-24 w-auto">
                            <span class="flex items-baseline">
                                <span class="text-3xl sm:text-4xl font-light tracking-tight text-gray-200">RUBI</span><span class="text-3xl sm:text-4xl font-black tracking-tight text-brand-500 ml-[1px]">KNOWS</span>
                            </span>
                        </a>
                        <p class="text-gray-400 text-sm leading-relaxed mb-10 max-w-sm font-bold uppercase tracking-wider">
                            World-class engineering, construction, and consultancy services. We engineer the future, blending world-class precision with visionary design.
                        </p>
                        
                        <div>
                            <h4 class="text-xs font-black text-brand-500 tracking-[0.2em] uppercase mb-4">Start a Project</h4>
                            <a href="{{ route('public.contact', ['tab' => 'quote']) }}" class="inline-flex items-center justify-center px-8 py-4 bg-brand-500 text-white font-black uppercase tracking-widest text-sm hover:bg-white hover:text-richblack-950 transition-all duration-300">
                                Initiate Proposal
                                <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Directory Section -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-12">
                        
                        <!-- Company Links -->
                        <div>
                            <h3 class="text-sm font-black text-brand-500 tracking-[0.15em] uppercase mb-6 border-b-2 border-brand-500 pb-2 inline-block">
                                Company
                            </h3>
                            <ul class="space-y-4 text-xs font-bold text-gray-400 tracking-widest uppercase">
                                <li><a href="{{ route('public.about') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">About Us</a></li>
                                <li><a href="{{ route('public.projects') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">Portfolio</a></li>
                                <li><a href="{{ route('public.clients') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">Clients & Partners</a></li>
                                <li><a href="{{ route('public.careers') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">Careers</a></li>
                                <li><a href="{{ route('public.contact') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">Contact</a></li>
                            </ul>
                        </div>

                        <!-- Services List -->
                        <div>
                            <h3 class="text-sm font-black text-brand-500 tracking-[0.15em] uppercase mb-6 border-b-2 border-brand-500 pb-2 inline-block">
                                Services
                            </h3>
                            <ul class="space-y-4 text-xs font-bold text-gray-400 tracking-widest uppercase">
                                @php
                                    $footerServices = \App\Models\Service::latest()->take(6)->get();
                                @endphp
                                @foreach($footerServices as $fs)
                                    <li><a href="{{ route('public.services') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 block">{{ $fs->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Global HQ / Contact -->
                        <div>
                            <h3 class="text-sm font-black text-brand-500 tracking-[0.15em] uppercase mb-6 border-b-2 border-brand-500 pb-2 inline-block">
                                Global HQ
                            </h3>
                            <ul class="space-y-4 text-xs font-bold text-gray-400 tracking-widest uppercase">
                                @if(!empty($settings['contact_phone']))
                                    <li class="flex flex-col gap-1">
                                        <span class="text-brand-500">Phone</span>
                                        <span class="text-white">{{ $settings['contact_phone'] }}</span>
                                    </li>
                                @endif
                                @if(!empty($settings['contact_email']))
                                    <li class="flex flex-col gap-1">
                                        <span class="text-brand-500">Email</span>
                                        <a href="mailto:{{ $settings['contact_email'] }}" class="text-white hover:text-brand-500 transition-colors lowercase tracking-normal">{{ $settings['contact_email'] }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-6 text-xs text-gray-500 font-bold uppercase tracking-widest">
                    <p>&copy; {{ date('Y') }} {{ $companyName }}. All Rights Reserved.</p>
                    <div class="flex flex-wrap gap-6 justify-center items-center">
                        <a href="{{ route('public.privacy') }}" class="hover:text-white transition-colors">Privacy</a>
                        <a href="{{ route('public.terms') }}" class="hover:text-white transition-colors">Terms</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="ml-4 px-4 py-2 bg-brand-500 text-white hover:bg-white hover:text-richblack-950 transition-colors">CMS Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="ml-4 px-4 py-2 border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition-colors">Portal</a>
                        @endauth
                    </div>
                </div>
            </div>
        </footer>

        <!-- ===== TOAST NOTIFICATION SYSTEM ===== -->
        <div id="rk-toast-container" class="fixed top-5 right-5 z-[99999] flex flex-col gap-3 pointer-events-none" aria-live="polite"></div>
        <script>
        (function () {
            var _c = document.getElementById('rk-toast-container');
            function rkToast(message, type) {
                type = type || 'success';
                var colors = {
                    success: { bar: '#E07B2A', label: 'Success' },
                    error:   { bar: '#ef4444', label: 'Error' },
                    info:    { bar: '#3b82f6', label: 'Notice' },
                };
                var c = colors[type] || colors.success;
                var icons = {
                    success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>',
                    error:   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>',
                    info:    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                };
                var t = document.createElement('div');
                t.setAttribute('data-rk-toast', '1');
                t.style.cssText = 'pointer-events:all;min-width:320px;max-width:400px;background:#0f172a;border-left:4px solid ' + c.bar + ';border-radius:0;box-shadow:0 10px 30px rgba(0,0,0,0.5);overflow:hidden;transform:translateX(120%);opacity:0;transition:transform .3s cubic-bezier(.34,1.56,.64,1),opacity .2s ease;';
                t.innerHTML =
                    '<div style="display:flex;align-items:flex-start;gap:12px;padding:16px;">' +
                    '<svg style="width:20px;height:20px;flex-shrink:0;margin-top:2px" fill="none" viewBox="0 0 24 24" stroke="' + c.bar + '">' + (icons[type] || icons.success) + '</svg>' +
                    '<div style="flex:1;min-width:0;">' +
                    '<p style="font-size:11px;font-weight:900;letter-spacing:.1em;text-transform:uppercase;color:' + c.bar + ';margin:0 0 4px 0;">' + c.label + '</p>' +
                    '<p style="font-size:14px;font-weight:600;color:#f8fafc;margin:0;line-height:1.5;">' + message + '</p></div>' +
                    '<button onclick="this.closest(\'[data-rk-toast]\').remove()" style="flex-shrink:0;padding:2px;background:none;border:none;cursor:pointer;color:#64748b;transition:color .2s;">' +
                    '<svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>' +
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
