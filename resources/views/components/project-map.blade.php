@props(['projects' => collect(), 'id' => 'rk-project-map', 'title' => 'Project locations'])

@php
    $mindanaoMap = \App\Support\MindanaoMap::class;
    $mapPoints = collect($projects)
        ->filter(fn ($project) => $mindanaoMap::contains($project->latitude, $project->longitude))
        ->map(fn ($project) => [
            'title' => $project->title,
            'location' => $project->location,
            'latitude' => (float) $project->latitude,
            'longitude' => (float) $project->longitude,
            'url' => route('public.project-details', $project),
        ])
        ->values();
@endphp

@if($mapPoints->isNotEmpty())
    <section class="rk-map" aria-labelledby="{{ $id }}-title">
        <div class="rk-map__head">
            <h2 id="{{ $id }}-title">{{ $title }}</h2>
            <p id="{{ $id }}-instructions" class="sr-only">Select a pin to open the project. All mapped projects are also listed below the map.</p>
        </div>
        <div id="{{ $id }}" class="rk-map__canvas" role="region" aria-label="Map of RUBIKNOWS projects in Mindanao" aria-describedby="{{ $id }}-instructions" aria-busy="true" data-projects='@json($mapPoints)'>
            <p id="{{ $id }}-status" class="rk-map__status" role="status">Loading map…</p>
        </div>
        <details class="rk-map__more">
            <summary>All mapped projects ({{ $mapPoints->count() }})</summary>
            <ul class="rk-map__list">
                @foreach($mapPoints as $point)
                    <li><a href="{{ $point['url'] }}">{{ $point['title'] }}</a>@if($point['location'])<span>{{ $point['location'] }}</span>@endif</li>
                @endforeach
            </ul>
        </details>
    </section>

    @push('scripts')
        <script nonce="{{ Vite::cspNonce() }}">
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById(@json($id));
                if (!container || container.dataset.ready) return;
                const status = document.getElementById(@json("{$id}-status"));

                function setStatus(message) {
                    if (!status) return;
                    status.textContent = message || '';
                    status.hidden = !message;
                }

                // Leaflet is pinned to one version and checked against its published hashes.
                function loadLeaflet() {
                    if (window.L) return Promise.resolve();
                    if (window.rubiKnowsLeafletPromise) return window.rubiKnowsLeafletPromise;

                    window.rubiKnowsLeafletPromise = new Promise(function (resolve, reject) {
                        const stylesheet = document.createElement('link');
                        stylesheet.rel = 'stylesheet';
                        stylesheet.href = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css';
                        stylesheet.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
                        stylesheet.crossOrigin = '';
                        document.head.appendChild(stylesheet);

                        const script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js';
                        script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
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

                    try {
                        await loadLeaflet();
                        if (!window.L) throw new Error('Leaflet did not load.');

                        const points = JSON.parse(container.dataset.projects || '[]');
                        const mindanaoBounds = L.latLngBounds(@json(\App\Support\MindanaoMap::POLYGON));
                        const map = L.map(container, {
                            scrollWheelZoom: false,
                            minZoom: 6,
                            maxZoom: 15,
                            maxBounds: mindanaoBounds.pad(.08),
                            maxBoundsViscosity: 0.9,
                        });

                        // Frame the pins themselves; fall back to the whole of Mindanao.
                        const pinBounds = L.latLngBounds(points.map(point => [point.latitude, point.longitude]));
                        if (points.length) {
                            map.fitBounds(pinBounds.pad(.35), { maxZoom: 11, padding: [24, 24] });
                        } else {
                            map.fitBounds(mindanaoBounds, { padding: [16, 16] });
                        }

                        // OpenStreetMap's public tiles need no account or API key.
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors',
                            maxZoom: 18,
                        }).on('tileerror', function () {
                            setStatus('Some map tiles could not load.');
                        }).addTo(map);

                        const icon = L.divIcon({ className: 'rk-map__marker', html: '<span class="rk-map__pin"></span>', iconSize: [22, 22], iconAnchor: [11, 11] });
                        const pins = L.layerGroup().addTo(map);

                        function onActivate(marker, label, action) {
                            marker.on('click', action);
                            const element = marker.getElement();
                            if (!element) return;
                            element.setAttribute('aria-label', label);
                            element.addEventListener('keydown', function (event) {
                                if (event.key !== 'Enter' && event.key !== ' ') return;
                                event.preventDefault();
                                action();
                            });
                        }

                        // Titles come from the CMS, so lists are built as text nodes, never HTML.
                        function projectList(group, asLinks) {
                            const list = document.createElement('ul');
                            list.className = 'rk-map__group';
                            group.forEach(function (point) {
                                const item = document.createElement('li');
                                const label = document.createElement(asLinks ? 'a' : 'span');
                                label.textContent = point.title;
                                if (asLinks) label.href = point.url;
                                item.appendChild(label);
                                list.appendChild(item);
                            });
                            return list;
                        }

                        function addPin(point) {
                            const marker = L.marker([point.latitude, point.longitude], { icon: icon, title: point.title, keyboard: true }).addTo(pins);
                            marker.bindTooltip(point.title, { direction: 'top', offset: [0, -10] });
                            onActivate(marker, 'Open project: ' + point.title, function () { window.location.assign(point.url); });
                        }

                        function addGroup(group) {
                            const bounds = L.latLngBounds(group.map(point => [point.latitude, point.longitude]));
                            const marker = L.marker(bounds.getCenter(), {
                                icon: L.divIcon({ className: 'rk-map__marker', html: '<span class="rk-map__cluster">' + group.length + '</span>', iconSize: [34, 34], iconAnchor: [17, 17] }),
                                keyboard: true,
                            }).addTo(pins);

                            const tip = document.createElement('div');
                            const heading = document.createElement('strong');
                            heading.textContent = group.length + ' projects here';
                            tip.append(heading, projectList(group, false));
                            marker.bindTooltip(tip, { direction: 'top', offset: [0, -16], className: 'rk-map__tip' });

                            onActivate(marker, group.length + ' projects here. Zoom in to see them.', function () {
                                // Projects at the very same spot never separate, so list them instead.
                                if (map.getZoom() >= map.getMaxZoom() || bounds.getNorthEast().equals(bounds.getSouthWest())) {
                                    marker.closeTooltip();
                                    marker.bindPopup(projectList(group, true), { className: 'rk-map__tip' }).openPopup();
                                    return;
                                }
                                map.fitBounds(bounds.pad(0.5), { maxZoom: map.getMaxZoom(), padding: [40, 40] });
                            });
                        }

                        // Pins that would overlap at the current zoom merge into one numbered pin,
                        // which splits back into single pins as the map zooms in.
                        function drawPins() {
                            pins.clearLayers();
                            const groups = [];
                            points.forEach(function (point) {
                                const at = map.latLngToLayerPoint([point.latitude, point.longitude]);
                                const near = groups.find(group => group.at.distanceTo(at) < 44);
                                if (near) {
                                    near.points.push(point);
                                } else {
                                    groups.push({ at: at, points: [point] });
                                }
                            });
                            groups.forEach(group => group.points.length === 1 ? addPin(group.points[0]) : addGroup(group.points));
                        }

                        map.on('zoomend', drawPins);
                        drawPins();

                        container.dataset.ready = 'true';
                        container.setAttribute('aria-busy', 'false');
                        setStatus('');
                    } catch (error) {
                        container.dataset.ready = '';
                        container.setAttribute('aria-busy', 'false');
                        setStatus('The map could not load. The projects are listed below.');
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
@endif
