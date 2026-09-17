<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Add New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="category_id" class="form-label-v2">Category</label>
                            <input type="text" name="category_id" id="category_id" value="{{ old('category_id') }}" placeholder="e.g. Civil Engineering" class="form-input-v2">
                        </div>

                        <div>
                            <label for="image_file" class="form-label-v2">Project Cover Image</label>
                            <input type="file" name="image_file" id="image_file"
                                   accept="image/jpeg,image/png,image/gif,image/webp"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file: file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-orange-100">
                            @error('image_file')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">Accepted: JPG, PNG, GIF, WEBP. Max 5MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="title" class="form-label-v2">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="form-input-v2">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label-v2">Status</label>
                            <select name="status" id="status" class="form-input-v2">
                                <option value="Latest" {{ old('status') == 'Latest' ? 'selected' : '' }}>Latest</option>
                                <option value="Featured" {{ old('status') == 'Featured' ? 'selected' : '' }}>Featured</option>
                                <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="Upcoming" {{ old('status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="client" class="form-label-v2">Client</label>
                            <input type="text" name="client" id="client" value="{{ old('client') }}" class="form-input-v2">
                        </div>

                        <div>
                            <label for="location" class="form-label-v2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-input-v2">
                        </div>
                    </div>

                    <div class="mb-6 border border-gray-200 bg-gray-50 p-5">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <label class="form-label-v2 mb-1">Project Map Pin</label>
                                <p class="text-xs text-gray-500">Click the Philippine map to place the project. Coordinates can also be entered manually.</p>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-brand-600">Optional</span>
                        </div>
                        <div id="project-location-picker" class="h-72 border border-gray-300 bg-richblack-900"></div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="latitude" class="form-label-v2">Latitude</label>
                                <input type="number" step="0.0000001" min="4" max="22" name="latitude" id="latitude" value="{{ old('latitude') }}" class="form-input-v2" placeholder="14.5995">
                                @error('latitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="longitude" class="form-label-v2">Longitude</label>
                                <input type="number" step="0.0000001" min="116" max="128" name="longitude" id="longitude" value="{{ old('longitude') }}" class="form-input-v2" placeholder="120.9842">
                                @error('longitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label-v2">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-input-v2">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.projects.index') }}" class="btn-secondary mr-3">Cancel</a>
                        <button type="submit" class="btn-primary">Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@push('extra-head-scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('project-location-picker', { scrollWheelZoom: false }).setView([12.8797, 121.7740], 5);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 18
            }).addTo(map);
            let marker;
            function placePin(lat, lng) {
                if (marker) marker.setLatLng([lat, lng]);
                else marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('latitude').value = lat.toFixed(7);
                document.getElementById('longitude').value = lng.toFixed(7);
            }
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            if (Number.isFinite(lat) && Number.isFinite(lng)) {
                placePin(lat, lng);
                map.setView([lat, lng], 11);
            }
            map.on('click', event => placePin(event.latlng.lat, event.latlng.lng));
        });
    </script>
@endpush

