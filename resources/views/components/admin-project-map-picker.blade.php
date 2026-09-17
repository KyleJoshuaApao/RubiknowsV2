@props([
    'mapProjects' => collect(),
    'latitude' => null,
    'longitude' => null,
])

@php
    $existingPins = collect($mapProjects)->map(fn ($project) => [
        'title' => $project->title,
        'latitude' => (float) $project->latitude,
        'longitude' => (float) $project->longitude,
    ])->values();
@endphp

<fieldset class="mb-6 border border-gray-200 bg-gray-50 p-5" aria-describedby="project-map-help">
    <div class="flex items-start justify-between gap-4 mb-4">
        <div>
            <legend class="form-label-v2 mb-1">Project Map Pin</legend>
            <p id="project-map-help" class="text-xs text-gray-500">Click anywhere in Mindanao to place a pin. Existing Mindanao projects appear as white dots; coordinates can also be edited manually.</p>
        </div>
        <button id="clear-project-pin" type="button" class="text-[10px] font-black uppercase tracking-widest text-brand-700 hover:text-richblack-900">Clear pin</button>
    </div>
    <div id="project-location-picker" class="h-72 border border-gray-300 bg-richblack-900" role="application" aria-label="Mindanao project location picker" data-existing-pins='@json($existingPins)'>
        <p id="project-map-status" class="h-full grid place-items-center px-4 text-center text-xs font-bold uppercase tracking-widest text-gray-300" role="status">Loading map…</p>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
            <label for="latitude" class="form-label-v2">Latitude</label>
            <input type="number" step="0.0000001" min="4.3" max="10.9" name="latitude" id="latitude" value="{{ old('latitude', $latitude) }}" class="form-input-v2" placeholder="7.1907" inputmode="decimal">
            @error('latitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="longitude" class="form-label-v2">Longitude</label>
            <input type="number" step="0.0000001" min="118.4" max="126.9" name="longitude" id="longitude" value="{{ old('longitude', $longitude) }}" class="form-input-v2" placeholder="125.4553" inputmode="decimal">
            @error('longitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</fieldset>

@once
    @push('extra-head-scripts')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
        <style>
            .rk-admin-existing-pin { width: .75rem; height: .75rem; border: 2px solid #0b0c0c; border-radius: 999px; background: #fff; box-shadow: 0 0 0 .2rem rgba(255,255,255,.18); }
            .rk-admin-selected-pin { width: 2rem; height: 2rem; display: grid; place-items: center; border: 2px solid #0b0c0c; border-radius: 50% 50% 50% 0; background: #dcae32; box-shadow: 0 0 0 .35rem rgba(220,174,50,.18); transform: rotate(-45deg); }
            .rk-admin-selected-pin::after { content: '+'; color: #0b0c0c; font-size: 1.2rem; font-weight: 900; transform: rotate(45deg); }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mount = document.getElementById('project-location-picker');
            const status = document.getElementById('project-map-status');
            const latitude = document.getElementById('latitude');
            const longitude = document.getElementById('longitude');
            const clear = document.getElementById('clear-project-pin');
            if (!mount || !latitude || !longitude || !clear) return;

            if (typeof L === 'undefined') {
                status.textContent = 'Map unavailable. Enter coordinates manually.';
                status.classList.add('text-red-300');
                return;
            }

            const mindanaoBounds = L.latLngBounds([[4.3, 118.4], [10.9, 126.9]]);
            const map = L.map(mount, {
                scrollWheelZoom: false,
                minZoom: 6,
                maxZoom: 14,
                maxBounds: mindanaoBounds.pad(.08),
                maxBoundsViscosity: 0.9,
            }).fitBounds(mindanaoBounds, { padding: [18, 18] });
            function setStatus(message, isError = false) {
                status.textContent = message;
                status.style.display = message ? 'grid' : 'none';
                status.classList.toggle('text-red-300', isError);
            }

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors', maxZoom: 18
            }).on('tileerror', function () {
                setStatus('Map tiles are unavailable. You can still enter coordinates manually.', true);
            }).addTo(map);

            const selectedIcon = L.divIcon({ className: 'rk-admin-marker', html: '<span class="rk-admin-selected-pin"></span>', iconSize: [32, 32], iconAnchor: [16, 32] });
            const existingIcon = L.divIcon({ className: 'rk-admin-existing-marker', html: '<span class="rk-admin-existing-pin"></span>', iconSize: [12, 12], iconAnchor: [6, 6] });
            const existingPins = JSON.parse(mount.dataset.existingPins || '[]');
            let selectedMarker;

            existingPins.forEach(pin => L.marker([pin.latitude, pin.longitude], { icon: existingIcon, interactive: false }).bindTooltip(pin.title).addTo(map));

            function placePin(lat, lng, centre = false) {
                if (selectedMarker) selectedMarker.setLatLng([lat, lng]);
                else selectedMarker = L.marker([lat, lng], { icon: selectedIcon, title: 'Selected project location' }).addTo(map);
                latitude.value = Number(lat).toFixed(7);
                longitude.value = Number(lng).toFixed(7);
                if (centre) map.setView([lat, lng], 11);
            }

            function moveToManualCoordinates() {
                const lat = Number.parseFloat(latitude.value);
                const lng = Number.parseFloat(longitude.value);
                if (Number.isFinite(lat) && Number.isFinite(lng) && lat >= 4.3 && lat <= 10.9 && lng >= 118.4 && lng <= 126.9) placePin(lat, lng, true);
            }

            moveToManualCoordinates();
            map.on('click', event => placePin(event.latlng.lat, event.latlng.lng));
            latitude.addEventListener('change', moveToManualCoordinates);
            longitude.addEventListener('change', moveToManualCoordinates);
            clear.addEventListener('click', function () {
                if (selectedMarker) { map.removeLayer(selectedMarker); selectedMarker = null; }
                latitude.value = '';
                longitude.value = '';
                latitude.focus();
            });
            map.whenReady(() => setStatus(''));
        });
    </script>
@endpush
