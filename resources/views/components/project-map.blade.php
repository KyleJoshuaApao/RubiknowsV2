@props(['projects' => collect(), 'id' => 'rk-project-map'])

@php
    $mapPoints = collect($projects)
        ->filter(fn ($project) => filled($project->latitude) && filled($project->longitude))
        ->map(fn ($project) => [
            'title' => $project->title,
            'location' => $project->location,
            'latitude' => (float) $project->latitude,
            'longitude' => (float) $project->longitude,
            'url' => route('public.project-details', $project),
        ])
        ->values();
@endphp

<section class="rk-map-section" aria-labelledby="{{ $id }}-title">
    <div id="{{ $id }}" class="rk-map-canvas" role="region" aria-label="Interactive project map of the Philippines" aria-describedby="{{ $id }}-instructions {{ $id }}-status" aria-busy="true" data-projects='@json($mapPoints)'>
        <p id="{{ $id }}-status" class="rk-map-loading" role="status">Loading the project map<span aria-hidden="true">...</span></p>
    </div>
    <div class="rk-map-heading">
        <x-public.eyebrow>RubiKnows footprint</x-public.eyebrow>
        <h2 id="{{ $id }}-title">Projects across<br><em>the Philippines.</em><span class="sr-only"> Remarkable experiences across the map</span></h2>
        <p>Every pin is linked to a portfolio project. Choose one to see the work in context.</p>
    </div>
    <p id="{{ $id }}-instructions" class="sr-only">Use a project pin to open its portfolio page. A full list of mapped projects follows.</p>
    @if($mapPoints->isNotEmpty())
        <ul class="sr-only" aria-label="Mapped RubiKnows projects">
            @foreach($mapPoints as $point)
                <li><a href="{{ $point['url'] }}">{{ $point['title'] }}@if($point['location']), {{ $point['location'] }}@endif</a></li>
            @endforeach
        </ul>
    @endif
    @if($mapPoints->isEmpty())
        <p class="rk-map-empty">Project locations will appear here as pins are added from the CMS.</p>
    @endif
</section>

@once
    @push('head')
        <style>
            .rk-map-section { position: relative; isolation: isolate; height: 100svh; min-height: min(40rem, 100svh); overflow: hidden; background: #ece9e0; color: #171613; }
            .rk-map-canvas { position: absolute; inset: 0; z-index: 0; width: 100%; height: 100%; background: #e6e4dd; }
            .rk-map-canvas::after { position: absolute; inset: 0; z-index: 400; background: linear-gradient(90deg, rgba(246,244,239,.88) 0%, rgba(246,244,239,.42) 34%, transparent 60%), linear-gradient(0deg, rgba(246,244,239,.18), transparent 34%); content: ''; pointer-events: none; }
            .rk-map-heading { position: absolute; top: clamp(1.5rem, 6vw, 5rem); left: max(1.5rem, calc((100vw - 88rem) / 2)); z-index: 450; width: min(31rem, calc(100% - 3rem)); pointer-events: none; }
            .rk-map-heading .rk-eyebrow { color: var(--rk-gold-deep); }
            .rk-map-heading h2 { max-width: 29rem; margin: .9rem 0 0; color: #171613; font-size: clamp(2.5rem, 4.2vw, 4.75rem); font-weight: 800; letter-spacing: -.078em; line-height: .84; text-transform: uppercase; text-shadow: 0 1px 0 rgba(255,255,255,.5); }
            .rk-map-heading h2 em { color: var(--rk-gold-deep); font-style: normal; }
            .rk-map-heading p { max-width: 21rem; margin: 1.5rem 0 0; color: #47443e; font-size: .88rem; line-height: 1.6; }
            .rk-map-canvas .leaflet-top { top: 1.5rem; }
            .rk-map-canvas .leaflet-right { right: 1.25rem; }
            .rk-map-canvas .leaflet-control-zoom { border: 1px solid rgba(23,22,19,.28); border-radius: 0; box-shadow: none; }
            .rk-map-canvas .leaflet-control-zoom a { width: 2.25rem; height: 2.25rem; border-radius: 0; color: #171613; font-weight: 700; line-height: 2.15rem; }
            .rk-map-canvas .leaflet-control-attribution { padding: .2rem .4rem; background: rgba(255,255,255,.88); color: #5e5a53; font-size: .62rem; }
            .rk-map-canvas .leaflet-control-attribution a { color: #8a630a; }
            .rk-map-pin { position: relative; display: grid; width: 2rem; height: 2rem; place-items: center; border: 2px solid #171613; border-radius: 50% 50% 50% 0; background: var(--rk-gold); box-shadow: 0 0 0 .35rem color-mix(in srgb, var(--rk-gold) 24%, transparent); transform: rotate(-45deg); }
            .rk-map-pin::before { position: absolute; inset: -.7rem; border: 1px solid rgba(185,129,7,.72); border-radius: inherit; content: ''; animation: rk-map-marker-pulse 2.5s ease-out infinite; }
            .rk-map-pin::after { color: #171613; content: '+'; font-size: 1.15rem; font-weight: 900; line-height: 1; transform: rotate(45deg); }
            .rk-map-empty { position: absolute; right: 1.5rem; bottom: 1.5rem; left: max(1.5rem, calc((100vw - 88rem) / 2)); z-index: 450; max-width: 30rem; margin: 0; padding: .75rem 1rem; background: rgba(255,255,255,.88); color: #5e5a53; font-size: .68rem; font-weight: 750; letter-spacing: .1em; text-transform: uppercase; }
            .rk-map-loading { position: relative; z-index: 1; display: grid; width: 100%; height: 100%; place-items: center; margin: 0; color: #5e5a53; font-size: .68rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
            .rk-map-loading span { color: var(--rk-gold-deep); animation: rk-map-pulse 1.1s infinite; }
            @keyframes rk-map-pulse { 50% { opacity: .2; } }
            @keyframes rk-map-marker-pulse { 75% { opacity: .75; } 100% { opacity: 0; transform: scale(1.5); } }
            @media (max-width: 700px) { .rk-map-section { min-height: 100svh; } .rk-map-canvas::after { background: linear-gradient(180deg, rgba(246,244,239,.9) 0%, rgba(246,244,239,.32) 45%, transparent 75%); } .rk-map-heading { top: 1.5rem; } .rk-map-heading h2 { font-size: clamp(2.35rem, 11vw, 3.8rem); } .rk-map-heading p { max-width: 17rem; margin-top: 1rem; font-size: .8rem; } .rk-map-canvas .leaflet-top { top: auto; bottom: 1.5rem; } .rk-map-canvas .leaflet-right { right: 1rem; } .rk-map-canvas .leaflet-control-attribution { display: none; } .rk-map-empty { right: 1rem; bottom: 1rem; left: 1rem; } }
            @media (prefers-reduced-motion: reduce) { .rk-map-pin::before, .rk-map-loading span { animation: none; } }
        </style>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById(@json($id));
            if (!container || container.dataset.ready) return;
            const status = document.getElementById(@json("{$id}-status"));

            function setStatus(message, isError) {
                if (!status) return;
                status.textContent = message || '';
                status.hidden = !message;
                status.classList.toggle('rk-map-loading--error', Boolean(isError));
            }

            function loadLeaflet() {
                if (window.L) return Promise.resolve();
                if (window.rubiKnowsLeafletPromise) return window.rubiKnowsLeafletPromise;

                window.rubiKnowsLeafletPromise = new Promise(function (resolve, reject) {
                    if (!document.querySelector('link[data-rk-leaflet]')) {
                        const stylesheet = document.createElement('link');
                        stylesheet.rel = 'stylesheet';
                        stylesheet.href = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css';
                        stylesheet.crossOrigin = '';
                        stylesheet.dataset.rkLeaflet = 'true';
                        document.head.appendChild(stylesheet);
                    }

                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js';
                    script.crossOrigin = '';
                    script.onload = resolve;
                    script.onerror = reject;
                    document.head.appendChild(script);
                });

                return window.rubiKnowsLeafletPromise;
            }

            async function initialiseMap() {
                if (container.dataset.ready) return;
                container.dataset.ready = 'loading';
                setStatus('Loading the project map…');

                try {
                    await loadLeaflet();
                    if (!window.L) throw new Error('Leaflet did not load.');

                    const points = JSON.parse(container.dataset.projects || '[]');
                    const philippinesBounds = L.latLngBounds([[4.35, 116.55], [21.45, 127.35]]);
                    const map = L.map(container, {
                        scrollWheelZoom: false,
                        zoomControl: false,
                        minZoom: 5,
                        maxZoom: 12,
                        maxBounds: philippinesBounds.pad(.08),
                        maxBoundsViscosity: 0.9,
                    }).setView([12.45, 122.25], window.innerWidth < 700 ? 5 : 6);

                    L.control.zoom({ position: 'topright' }).addTo(map);
                    // OpenStreetMap's public tiles require no account or API key.
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 18,
                    }).on('tileerror', function () {
                        setStatus('Map tiles are unavailable. You can still explore the complete portfolio.', true);
                    }).addTo(map);

                    const icon = L.divIcon({
                        className: 'rk-map-marker',
                        html: '<span class="rk-map-pin"></span>',
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                    });

                    points.forEach(function (point) {
                        const marker = L.marker([point.latitude, point.longitude], {
                            icon: icon,
                            title: point.title,
                            keyboard: true,
                        }).addTo(map);
                        marker.bindTooltip(point.title, { direction: 'top', offset: [0, -24] });
                        marker.on('click', function () { window.location.assign(point.url); });
                        const markerElement = marker.getElement();
                        if (markerElement) {
                            markerElement.setAttribute('aria-label', 'Open project: ' + point.title);
                            markerElement.addEventListener('keydown', function (event) {
                                if (event.key !== 'Enter' && event.key !== ' ') return;
                                event.preventDefault();
                                window.location.assign(point.url);
                            });
                        }
                    });

                    container.dataset.ready = 'true';
                    container.setAttribute('aria-busy', 'false');
                    setStatus('');
                } catch (error) {
                    container.dataset.ready = '';
                    container.setAttribute('aria-busy', 'false');
                    setStatus('Map unavailable. You can still explore the complete portfolio.', true);
                }
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    if (!entries.some(entry => entry.isIntersecting)) return;
                    observer.disconnect();
                    initialiseMap();
                }, { rootMargin: '300px 0px' });
                observer.observe(container);
            } else {
                initialiseMap();
            }
        });
    </script>
@endpush
