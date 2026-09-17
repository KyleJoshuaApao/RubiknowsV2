<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php
            $settings = Cache::remember('site_settings', 3600, fn () => \App\Models\Setting::pluck('value', 'key')->toArray());
            $companyName = $settings['company_name'] ?? 'RubiKnows';
            $seoDescription = $settings['seo_description'] ?? 'Engineering, construction, and consultancy services in the Philippines.';
            $pageTitle = isset($title) && $title !== 'Home' ? $title . ' | ' . $companyName : $companyName;
            $navItems = [
                ['label' => 'Home', 'route' => 'public.home', 'active' => 'public.home'],
                ['label' => 'About', 'route' => 'public.about', 'active' => 'public.about'],
                ['label' => 'Services', 'route' => 'public.services', 'active' => 'public.services*'],
                ['label' => 'Projects', 'route' => 'public.projects', 'active' => 'public.projects|public.project-details'],
                ['label' => 'Gallery', 'route' => 'public.gallery', 'active' => 'public.gallery'],
                ['label' => 'Testimonials', 'route' => 'public.testimonials', 'active' => 'public.testimonials'],
                ['label' => 'Clients', 'route' => 'public.clients', 'active' => 'public.clients'],
                ['label' => 'Careers', 'route' => 'public.careers', 'active' => 'public.careers*'],
            ];
            $footerServices = Cache::remember('public_footer_services', 300, fn () => \App\Models\Service::latest()->take(5)->get(['id', 'slug', 'title']));
        @endphp

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $seoDescription }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:image" content="{{ asset('RK4.webp') }}">
        <meta property="og:site_name" content="{{ $companyName }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ asset('RK4.webp') }}">
        <script type="application/ld+json">{"@@context":"https://schema.org","@@type":"Organization","name":@json($companyName),"url":@json(url('/')),"logo":@json(asset('RK4.webp')),"description":@json($seoDescription)}</script>
        <link rel="icon" type="image/webp" href="{{ asset('RK4.webp') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="rk-public flex min-h-screen flex-col antialiased">
        <a class="rk-skip-link" href="#main-content">Skip to content</a>

        <header class="rk-header" x-data="{ mobileOpen: false }" @keydown.escape.window="if (mobileOpen) { mobileOpen = false; $nextTick(() => $refs.menuToggle.focus()) }">
            <div class="rk-header__inner">
                <div class="rk-brand">
                    <a href="{{ route('public.home') }}" aria-label="{{ $companyName }} home" class="rk-logo-wordmark">
                        <x-logo textSize="text-2xl sm:text-3xl" class="h-12 sm:h-14 w-auto" />
                    </a>
                </div>

                <nav class="rk-nav" aria-label="Primary navigation">
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="{{ request()->routeIs(...explode('|', $item['active'])) ? 'is-active' : '' }}">{{ $item['label'] }}</a>
                    @endforeach
                    <a href="{{ route('public.contact') }}" class="rk-nav__contact {{ request()->routeIs('public.contact') ? 'is-active' : '' }}">Contact us</a>
                </nav>

                <button x-ref="menuToggle" type="button" class="rk-mobile-toggle" @click="mobileOpen = !mobileOpen; if (mobileOpen) $nextTick(() => $refs.firstMobileLink.focus())" :aria-expanded="mobileOpen.toString()" aria-controls="rk-mobile-menu" aria-label="Toggle navigation">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" /></svg>
                    <svg x-cloak x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" /></svg>
                </button>
            </div>

            <nav id="rk-mobile-menu" class="rk-mobile-menu" x-cloak x-show="mobileOpen" x-transition.opacity @click.outside="mobileOpen = false" aria-label="Mobile navigation">
                <div class="rk-mobile-menu__inner">
                    @foreach($navItems as $item)
                        <a @if($loop->first) x-ref="firstMobileLink" @endif @click="mobileOpen = false" href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                    @endforeach
                    <a @click="mobileOpen = false" href="{{ route('public.contact') }}" class="rk-mobile-menu__contact">Contact us</a>
                </div>
            </nav>
        </header>

        @if(session('success'))
            <div class="rk-alert rk-alert--success" role="status" x-data="{ open: true }" x-show="open">
                <span>{{ session('success') }}</span><button type="button" @click="open = false" aria-label="Dismiss message">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="rk-alert rk-alert--error" role="alert" x-data="{ open: true }" x-show="open">
                <span>{{ session('error') }}</span><button type="button" @click="open = false" aria-label="Dismiss message">×</button>
            </div>
        @endif

        <main id="main-content" class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="rk-footer">
            <div class="rk-container rk-footer__grid">
                <div class="rk-footer__brand">
                    <a href="{{ route('public.home') }}" class="rk-logo-wordmark inline-flex" aria-label="{{ $companyName }} home">
                        <x-logo :dark="true" textSize="text-3xl" class="h-16 w-auto" />
                    </a>
                    <p>Engineering, construction, and consultancy work shaped with rigor, care, and a practical commitment to what lasts.</p>
                    <x-public.action href="{{ route('public.contact', ['tab' => 'quote']) }}" tone="gold" class="mt-7">Start a project</x-public.action>
                </div>
                <div>
                    <h2>Explore</h2>
                    <ul>
                        <li><a href="{{ route('public.about') }}">About RubiKnows</a></li>
                        <li><a href="{{ route('public.projects') }}">Project portfolio</a></li>
                        <li><a href="{{ route('public.gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('public.careers') }}">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h2>Services</h2>
                    <ul>
                        @forelse($footerServices as $service)
                            <li><a href="{{ route('public.service-details', $service) }}">{{ $service->title }}</a></li>
                        @empty
                            <li><a href="{{ route('public.services') }}">View our services</a></li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h2>Contact</h2>
                    <address>
                        @if(!empty($settings['office_address'])){{ $settings['office_address'] }}<br>@endif
                        @if(!empty($settings['contact_phone']))<a href="tel:{{ $settings['contact_phone'] }}">{{ $settings['contact_phone'] }}</a><br>@endif
                        @if(!empty($settings['contact_email']))<a href="mailto:{{ $settings['contact_email'] }}">{{ $settings['contact_email'] }}</a>@endif
                    </address>
                </div>
            </div>
            <div class="rk-container rk-footer__bottom">
                <span>© {{ now()->year }} {{ $companyName }}. All rights reserved.</span>
                <nav aria-label="Legal navigation"><a href="{{ route('public.privacy') }}">Privacy</a><a href="{{ route('public.terms') }}">Terms</a><a href="{{ auth()->check() ? route('dashboard') : route('login') }}">Admin CMS</a></nav>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
