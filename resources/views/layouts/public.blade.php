<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php
            $settings = \App\Models\Setting::allCached();
            $sections = \App\Support\PublicContentCache::sections();
            $footerServices = \App\Support\PublicContentCache::footerServices();

            $companyName = $settings['company_name'] ?? 'RubiKnows';
            $brandName = mb_strtoupper($companyName) === $companyName ? 'RubiKnows' : $companyName;
            $contact = \App\Support\ContactDetails::fromSettings();
            [$phone, $phoneHref, $email, $address] = [$contact->phone, $contact->phoneHref, $contact->email, $contact->address];

            $pageTitle = isset($title) && trim((string) $title) !== '' && (string) $title !== 'Home'
                ? trim((string) $title).' | '.$brandName
                : $brandName.' | Engineering and Construction in Tagum City';
            $metaDescription = isset($description) && trim((string) $description) !== ''
                ? trim(preg_replace('/\s+/', ' ', strip_tags((string) $description)))
                : ($settings['seo_description'] ?? 'Engineering, design and construction company in Tagum City, Davao del Norte, serving property owners across Mindanao.');
            $shareImage = isset($image) && trim((string) $image) !== '' ? url(trim((string) $image)) : asset('images/og-default.png');

            $navItems = array_values(array_filter([
                ['label' => 'Services', 'route' => 'public.services', 'active' => ['public.services', 'public.service-details']],
                $sections['projects'] ? ['label' => 'Projects', 'route' => 'public.projects', 'active' => ['public.projects', 'public.project-details']] : null,
                ['label' => 'Gallery', 'route' => 'public.gallery', 'active' => ['public.gallery']],
                ['label' => 'Careers', 'route' => 'public.careers', 'active' => ['public.careers']],
                ['label' => 'Contact', 'route' => 'public.contact', 'active' => ['public.contact']],
                ['label' => 'About', 'route' => 'public.about', 'active' => ['public.about']],
            ]));

            $socialLinks = array_filter([
                'Facebook' => $settings['social_facebook'] ?? null,
                'LinkedIn' => $settings['social_linkedin'] ?? null,
            ], fn ($url) => is_string($url) && filter_var($url, FILTER_VALIDATE_URL));

            $organization = array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'GeneralContractor',
                'name' => $brandName,
                'url' => url('/'),
                'logo' => asset('RK4.webp'),
                'image' => asset('images/og-default.png'),
                'description' => $metaDescription,
                'telephone' => $phone ?: null,
                'email' => $email ?: null,
                'foundingDate' => $settings['about_est_year'] ?? null,
                'address' => $address ? ['@type' => 'PostalAddress', 'streetAddress' => $address, 'addressCountry' => 'PH'] : null,
                'areaServed' => 'Mindanao, Philippines',
                'sameAs' => array_values($socialLinks) ?: null,
            ]);
        @endphp

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $metaDescription }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $brandName }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:image" content="{{ $shareImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="theme-color" content="#0a0a0a">
        <script nonce="{{ Vite::cspNonce() }}" type="application/ld+json">{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
        <link rel="icon" type="image/webp" href="{{ asset('RK4.webp') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=barlow:400,500,600,700|barlow-semi-condensed:500,600,700|inter:400,900&display=swap" rel="stylesheet">
        <script nonce="{{ Vite::cspNonce() }}">if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) document.documentElement.classList.add('rk-motion');</script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="rk-public">
        <a class="rk-skip-link" href="#main-content">Skip to content</a>

        <header class="rk-header" x-data="{ open: false }" @keydown.escape.window="if (open) { open = false; $nextTick(() => $refs.menuButton.focus()) }">
            <div class="rk-container rk-header__bar">
                <a class="rk-brand" href="{{ route('public.home') }}" aria-label="{{ $brandName }} home">
                    <x-logo textSize="text-[1.6rem]" class="h-11 w-auto" />
                </a>

                <nav class="rk-nav" aria-label="Main">
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" @if(request()->routeIs(...$item['active'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                    @endforeach
                </nav>

                <div class="rk-header__actions">
                    @if($phone)
                        <a class="rk-header__phone" href="tel:{{ $phoneHref }}">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2" stroke-linejoin="round"/></svg>
                            {{ $phone }}
                        </a>
                    @endif
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quote</a>
                </div>

                <button type="button" class="rk-menu-button" x-ref="menuButton" @click="open = !open" :aria-expanded="open.toString()" aria-controls="rk-mobile-menu">
                    <span x-text="open ? 'Close' : 'Menu'">Menu</span>
                    <svg x-show="!open" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/></svg>
                    <svg x-cloak x-show="open" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18" stroke-linecap="round"/></svg>
                </button>
            </div>

            <div id="rk-mobile-menu" class="rk-mobile-menu" x-cloak x-show="open" @click.outside="open = false">
                <nav class="rk-container" aria-label="Main">
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" @if(request()->routeIs(...$item['active'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                    @endforeach
                    <div class="rk-mobile-menu__actions">
                        <a class="rk-btn rk-btn--primary" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quote</a>
                        @if($phone)
                            <a class="rk-btn rk-btn--outline" href="tel:{{ $phoneHref }}">Call {{ $phone }}</a>
                        @endif
                    </div>
                </nav>
            </div>
        </header>

        @if(session('success'))
            <div class="rk-alert rk-alert--success" role="status" x-data="{ shown: true }" x-show="shown">
                <div class="rk-container rk-alert__inner">
                    <p>{{ session('success') }}</p>
                    <button type="button" @click="shown = false" aria-label="Dismiss message">&times;</button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="rk-alert rk-alert--error" role="alert" x-data="{ shown: true }" x-show="shown">
                <div class="rk-container rk-alert__inner">
                    <p>{{ session('error') }}</p>
                    <button type="button" @click="shown = false" aria-label="Dismiss message">&times;</button>
                </div>
            </div>
        @endif

        <main id="main-content">
            {{ $slot }}
        </main>

        <footer class="rk-footer">
            <div class="rk-container rk-footer__grid">
                <div class="rk-footer__about">
                    <a class="rk-brand" href="{{ route('public.home') }}" aria-label="{{ $brandName }} home">
                        <x-logo :dark="true" textSize="text-[1.6rem]" class="h-11 w-auto" />
                    </a>
                    <p>Engineering, design and construction from Tagum City, Davao del Norte. Serving homeowners, businesses and institutions across Mindanao{{ !empty($settings['about_est_year']) ? ' since '.$settings['about_est_year'] : '' }}.</p>
                </div>

                <div>
                    <h2>Company</h2>
                    <ul>
                        <li><a href="{{ route('public.about') }}">About us</a></li>
                        @if($sections['projects'])<li><a href="{{ route('public.projects') }}">Projects</a></li>@endif
                        <li><a href="{{ route('public.gallery') }}">Gallery</a></li>
                        @if($sections['testimonials'])<li><a href="{{ route('public.testimonials') }}">Testimonials</a></li>@endif
                        @if($sections['clients'])<li><a href="{{ route('public.clients') }}">Clients and partners</a></li>@endif
                        <li><a href="{{ route('public.careers') }}">Careers</a></li>
                        <li><a href="{{ route('public.contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h2>Services</h2>
                    <ul>
                        @forelse($footerServices as $service)
                            <li><a href="{{ route('public.service-details', $service) }}">{{ $service->title }}</a></li>
                        @empty
                            <li><a href="{{ route('public.services') }}">Our services</a></li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <h2>Get in touch</h2>
                    <address>
                        @if($phone)<a href="tel:{{ $phoneHref }}">{{ $phone }}</a>@endif
                        @if($email)<a href="mailto:{{ $email }}">{{ $email }}</a>@endif
                        @if($address)<span>{{ $address }}</span>@endif
                    </address>
                    @if($socialLinks)
                        <ul class="rk-footer__social">
                            @foreach($socialLinks as $network => $url)
                                <li><a href="{{ $url }}" rel="noopener" target="_blank">{{ $network }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="rk-container rk-footer__bottom">
                <p>&copy; {{ now()->year }} {{ $brandName }}. All rights reserved.</p>
                <nav class="rk-footer__legal" aria-label="Legal">
                    <a href="{{ route('public.privacy') }}">Privacy policy</a>
                    <a href="{{ route('public.terms') }}">Terms of use</a>
                </nav>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
