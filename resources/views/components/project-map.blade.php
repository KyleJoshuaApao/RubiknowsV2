@props(['projects' => collect(), 'id' => 'rk-project-map'])

@php
    $mapPoints = collect($projects)->filter(fn ($project) => filled($project->latitude) && filled($project->longitude))->map(fn ($project) => [
        'title' => $project->title,
        'location' => $project->location,
        'latitude' => (float) $project->latitude,
        'longitude' => (float) $project->longitude,
        'url' => route('public.project-details', $project),
    ])->values();
@endphp

<section class="rk-map-section" aria-labelledby="{{ $id }}-title">
    <div class="rk-map-heading">
        <div>
            <p class="rk-kicker">RubiKnows footprint</p>
            <h2 id="{{ $id }}-title">Remarkable experiences across the map</h2>
        </div>
        <p class="rk-map-copy">Every marker is connected to a project in our portfolio. Select a location to explore the work behind it.</p>
    </div>
    <div id="{{ $id }}" class="rk-map-canvas" role="application" aria-label="Interactive map of RubiKnows projects in the Philippines" aria-describedby="{{ $id }}-status" aria-busy="true" data-projects='@json($mapPoints)'>
        <p id="{{ $id }}-status" class="rk-map-loading" role="status">Map loads as you reach this section<span>·</span><span>·</span><span>·</span></p>
    </div>
    @if($mapPoints->isEmpty())
        <p class="rk-map-empty">Project locations will appear here as pins are added from the CMS.</p>
    @endif
</section>

@once
    @push('head')
        <style>
            .rk-map-section { position: relative; z-index: 0; isolation: isolate; height: 100svh; min-height: 42rem; overflow: hidden; background: #0b0c0c; color: #fff; }
            .rk-map-heading { position: absolute; inset: calc(7rem + clamp(2rem, 7vw, 5rem)) clamp(1.25rem, 7vw, 7rem) auto; z-index: 2; display: flex; align-items: start; justify-content: space-between; gap: 2rem; max-width: none; margin: 0; pointer-events: none; text-shadow: 0 2px 18px rgba(0,0,0,.45); }
            .rk-map-heading h2 { margin-top: .65rem; max-width: 42rem; color: #fff; font-size: clamp(2.5rem, 6vw, 6.25rem); line-height: .9; letter-spacing: -.055em; text-transform: uppercase; }
            .rk-map-copy { max-width: 25rem; margin-top: 2.2rem; color: #e1e4e5; font-size: .9rem; line-height: 1.6; }
            .rk-map-canvas { position: absolute; inset: 0; z-index: 0; max-width: none; height: 100%; min-height: 0; margin: 0; overflow: hidden; border: 0; background: #202527; }
            .rk-map-canvas .leaflet-tile { filter: grayscale(1) contrast(1.1) brightness(.7); }
            .rk-map-canvas .leaflet-top { top: 7rem; }
            .rk-map-canvas .leaflet-control-zoom a { color: #0b0c0c; }
            .rk-map-canvas .leaflet-control-attribution { background: rgba(11,12,12,.82); color: #899094; }
            .rk-map-canvas .leaflet-control-attribution a { color: #dcae32; }
            .rk-map-pin { width: 2rem; height: 2rem; display: grid; place-items: center; border: 2px solid #0b0c0c; border-radius: 50% 50% 50% 0; background: #dcae32; box-shadow: 0 0 0 .35rem rgba(220,174,50,.18); transform: rotate(-45deg); }
            .rk-map-pin::before { position: absolute; inset: -.65rem; border: 1px solid rgba(220,174,50,.8); border-radius: inherit; content: ''; opacity: 0; animation: rk-map-marker-pulse 2.2s ease-out infinite; }
            .rk-map-pin::after { content: '+'; color: #0b0c0c; font-size: 1.2rem; font-weight: 900; transform: rotate(45deg); }
            .rk-map-empty { position: absolute; right: clamp(1.25rem, 7vw, 7rem); bottom: 2rem; left: clamp(1.25rem, 7vw, 7rem); z-index: 2; max-width: 90rem; margin: 0 auto; color: #c2c7c9; font-size: .75rem; text-transform: uppercase; letter-spacing: .15em; text-shadow: 0 2px 12px rgba(0,0,0,.6); }
            .rk-map-loading { height: 100%; display: grid; place-items: center; padding: 1rem; color: #a7aaad; font-size: .72rem; text-align: center; text-transform: uppercase; letter-spacing: .18em; }
            .rk-map-loading span { color: #dcae32; animation: rk-map-pulse 1s infinite; }
            .rk-map-loading span:nth-child(2) { animation-delay: .15s; } .rk-map-loading span:nth-child(3) { animation-delay: .3s; }
            @keyframes rk-map-pulse { 50% { opacity: .2; } }
            @keyframes rk-map-marker-pulse { 25% { opacity: .85; } 100% { transform: scale(1.55); opacity: 0; } }
            @media (max-width: 700px) { .rk-map-section { height: 100svh; min-height: 38rem; } .rk-map-heading { display: block; inset: calc(6rem + 2rem) 1.25rem auto; } .rk-map-heading h2 { font-size: clamp(2.5rem, 13vw, 4.5rem); } .rk-map-copy { margin-top: 1.25rem; } .rk-map-canvas .leaflet-top { top: 6rem; } .rk-map-empty { right: 1.25rem; bottom: 1.5rem; left: 1.25rem; } }
            @media (prefers-reduced-motion: reduce) { .rk-map-loading span, .rk-map-pin::before { animation: none; } }
        </style>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById(@json($id));
            if (!container || container.dataset.ready) return;
            const status = document.getElementById(@json("{$id}-status"));

            function setStatus(message, isError = false) {
                if (!status) return;
                status.textContent = message;
                status.hidden = !message;
                status.classList.toggle('text-red-300', isError);
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
                setStatus('Loading project map…');

                try {
                    await loadLeaflet();
                    if (typeof window.L === 'undefined') throw new Error('Leaflet failed to load.');

                    const points = JSON.parse(container.dataset.projects || '[]');
                    const map = L.map(container, { scrollWheelZoom: false, zoomControl: false, minZoom: 5, maxZoom: 14 }).setView([12.8797, 121.7740], 5.4);
                    L.control.zoom({ position: 'topright' }).addTo(map);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors', maxZoom: 18
                    }).on('tileerror', function () {
                        setStatus('Map tiles are unavailable. You can still explore every project from the portfolio.', true);
                    }).addTo(map);

                    const icon = L.divIcon({ className: 'rk-map-marker', html: '<span class="rk-map-pin"></span>', iconSize: [32, 32], iconAnchor: [16, 32] });
                    points.forEach(function (point) {
                        const marker = L.marker([point.latitude, point.longitude], { icon: icon, title: point.title, keyboard: true }).addTo(map);
                        marker.bindTooltip(point.title, { direction: 'top', offset: [0, -24] });
                        marker.on('click', function () { window.location.assign(point.url); });
                    });

                    if (points.length) {
                        map.fitBounds(L.latLngBounds(points.map(point => [point.latitude, point.longitude])), { padding: [40, 40], maxZoom: 8 });
                    }

                    container.dataset.ready = 'true';
                    container.setAttribute('aria-busy', 'false');
                    setStatus('');
                } catch (error) {
                    container.dataset.ready = '';
                    container.setAttribute('aria-busy', 'false');
                    setStatus('Map unavailable. You can still explore every project from the portfolio.', true);
                }
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    if (!entries.some(entry => entry.isIntersecting)) return;
                    observer.disconnect();
                    initialiseMap();
                }, { rootMargin: '350px 0px' });
                observer.observe(container);
            } else {
                initialiseMap();
            }
        });
    </script>
@endpush
