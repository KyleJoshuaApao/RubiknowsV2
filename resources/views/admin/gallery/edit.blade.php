<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Edit Media') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Current Media Preview -->
                @if($gallery->url)
                    <div class="mb-4">
                        <x-input-label value="Current Media" />
                        <div class="mt-2 border rounded p-2 bg-gray-50 max-w-xs">
                            @if($gallery->type === 'Photo')
                                <img src="{{ Storage::url($gallery->url) }}" class="rounded h-32 object-cover w-full">
                            @else
                                <div class="h-32 bg-gray-800 text-white flex items-center justify-center rounded">
                                    <span class="text-xs">Video File</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Media Title/Caption" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $gallery->title)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <x-input-label for="type" value="Media Type" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                            <option value="Photo" {{ old('type', $gallery->type) == 'Photo' ? 'selected' : '' }}>Photo</option>
                            <option value="Video" {{ old('type', $gallery->type) == 'Video' ? 'selected' : '' }}>Video</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Category -->
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                            <option value="Construction Progress" {{ old('category', $gallery->category) == 'Construction Progress' ? 'selected' : '' }}>Construction Progress</option>
                            <option value="Before & After" {{ old('category', $gallery->category) == 'Before & After' ? 'selected' : '' }}>Before & After</option>
                            <option value="Events" {{ old('category', $gallery->category) == 'Events' ? 'selected' : '' }}>Events</option>
                            <option value="General" {{ old('category', $gallery->category) == 'General' ? 'selected' : '' }}>General</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>
                </div>

                <!-- Album Name -->
                <div>
                    <x-input-label for="album_name" value="Album Name (Optional)" />
                    <x-text-input id="album_name" name="album_name" type="text" class="mt-1 block w-full" :value="old('album_name', $gallery->album_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('album_name')" />
                </div>

                <!-- File -->
                <div>
                    <x-input-label for="media_file" value="Replace File (Optional)" />
                    <input id="media_file" name="media_file" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E07B2A] hover:file:bg-orange-100" accept="image/*,video/mp4,video/quicktime" />
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current file.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('media_file')" />
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-[#E07B2A] border border-transparent rounded-lg font-medium text-sm text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Update Media
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
