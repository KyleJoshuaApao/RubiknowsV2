@props(['projects' => collect(), 'id' => 'rk-project-map'])

@php
    $mapPoints = collect($projects)->filter(fn ($project) => filled($project->latitude) && filled($project->longitude))->map(fn ($project) => [
        'title' => $project->title,
        'location' => $project->location,
        'category' => $project->category,
        'latitude' => (float) $project->latitude,
        'longitude' => (float) $project->longitude,
        'url' => route('public.project-details', $project),
    ])->values();
@endphp

<section class="rk-map-section" aria-labelledby="{{ $id }}-title">
    <div class="rk-map-heading">
        <div>
            <p class="rk-kicker">RubiKnows footprint</p>
            <h2 id="{{ $id }}-title">Projects across the Philippines</h2>
        </div>
        <p class="rk-map-copy">Every marker is connected to a project in our portfolio. Select a location to explore the work behind it.</p>
    </div>
    <div id="{{ $id }}" class="rk-map-canvas" data-projects='@json($mapPoints)'>
        <div class="rk-map-loading">Loading project map<span>·</span><span>·</span><span>·</span></div>
    </div>
    @if($mapPoints->isEmpty())
        <p class="rk-map-empty">Project locations will appear here as pins are added from the CMS.</p>
    @endif
</section>

@once
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
        <style>
            .rk-map-section { background: #0b0c0c; color: #fff; padding: clamp(3rem, 8vw, 8rem) clamp(1.25rem, 5vw, 5rem); }
            .rk-map-heading { display: flex; align-items: end; justify-content: space-between; gap: 2rem; max-width: 90rem; margin: 0 auto 2rem; }
            .rk-map-heading h2 { margin-top: .65rem; max-width: 42rem; font-size: clamp(2.5rem, 6vw, 6.25rem); line-height: .9; letter-spacing: -.055em; text-transform: uppercase; }
            .rk-map-copy { max-width: 25rem; color: #a7aaad; font-size: .9rem; line-height: 1.6; }
            .rk-map-canvas { max-width: 90rem; height: min(62vw, 44rem); min-height: 25rem; margin: 0 auto; overflow: hidden; border: 1px solid #3a3d3f; background: #202527; }
            .rk-map-canvas .leaflet-tile { filter: grayscale(1) contrast(1.1) brightness(.7); }
            .rk-map-canvas .leaflet-control-zoom a { color: #0b0c0c; }
            .rk-map-canvas .leaflet-control-attribution { background: rgba(11,12,12,.82); color: #899094; }
            .rk-map-canvas .leaflet-control-attribution a { color: #dcae32; }
            .rk-map-pin { width: 2rem; height: 2rem; display: grid; place-items: center; border: 2px solid #0b0c0c; border-radius: 50% 50% 50% 0; background: #dcae32; box-shadow: 0 0 0 .35rem rgba(220,174,50,.18); transform: rotate(-45deg); }
            .rk-map-pin::after { content: '+'; color: #0b0c0c; font-size: 1.2rem; font-weight: 900; transform: rotate(45deg); }
            .rk-map-popup strong { color: #0b0c0c; display: block; font-size: .95rem; }
            .rk-map-popup span { color: #697177; display: block; font-size: .75rem; margin: .2rem 0 .55rem; }
            .rk-map-popup a { color: #a87908; font-size: .7rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
            .rk-map-empty { max-width: 90rem; margin: 1rem auto 0; color: #899094; font-size: .75rem; text-transform: uppercase; letter-spacing: .15em; }
            .rk-map-loading { height: 100%; display: grid; place-items: center; color: #a7aaad; font-size: .72rem; text-transform: uppercase; letter-spacing: .18em; }
            .rk-map-loading span { color: #dcae32; animation: rk-map-pulse 1s infinite; }
            .rk-map-loading span:nth-child(2) { animation-delay: .15s; } .rk-map-loading span:nth-child(3) { animation-delay: .3s; }
            @keyframes rk-map-pulse { 50% { opacity: .2; } }
            @media (max-width: 700px) { .rk-map-heading { display: block; } .rk-map-copy { margin-top: 1.25rem; } .rk-map-canvas { height: 28rem; } }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById(@json($id));
            if (!container || typeof L === 'undefined' || container.dataset.ready === 'true') return;
            container.dataset.ready = 'true';
            const points = JSON.parse(container.dataset.projects || '[]');
            const map = L.map(container, { scrollWheelZoom: false, minZoom: 5, maxZoom: 14 }).setView([12.8797, 121.7740], 5.4);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 18
            }).addTo(map);
            const icon = L.divIcon({ className: 'rk-map-marker', html: '<span class="rk-map-pin"></span>', iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -32] });
            points.forEach(point => {
                const marker = L.marker([point.latitude, point.longitude], { icon, title: point.title }).addTo(map);
                marker.bindPopup('<div class="rk-map-popup"><strong>' + escapeHtml(point.title) + '</strong><span>' + escapeHtml(point.location || 'Philippines') + '</span><a href="' + point.url + '">View project →</a></div>');
                marker.on('click', () => { window.location.href = point.url; });
            });
            if (points.length) map.fitBounds(L.latLngBounds(points.map(point => [point.latitude, point.longitude])), { padding: [40, 40], maxZoom: 8 });
            function escapeHtml(value) { return String(value).replace(/[&<>"']/g, character => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[character])); }
        });
    </script>
@endpush
