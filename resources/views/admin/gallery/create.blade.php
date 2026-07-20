<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Upload Media') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Media Title/Caption" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <x-input-label for="type" value="Media Type" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                            <option value="Photo">Photo</option>
                            <option value="Video">Video</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Category -->
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                            <option value="Construction Progress">Construction Progress</option>
                            <option value="Before & After">Before & After</option>
                            <option value="Events">Events</option>
                            <option value="General">General</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>
                </div>

                <!-- Album Name -->
                <div>
                    <x-input-label for="album_name" value="Album Name (Optional)" />
                    <x-text-input id="album_name" name="album_name" type="text" class="mt-1 block w-full" :value="old('album_name')" placeholder="e.g. Project Alpha Phase 1" />
                    <x-input-error class="mt-2" :messages="$errors->get('album_name')" />
                </div>

                <!-- File -->
                <div>
                    <x-input-label for="media_file" value="Upload File" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="media_file" class="relative cursor-pointer bg-white rounded-md font-medium text-[#E07B2A] hover:text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>Upload a file</span>
                                    <input id="media_file" name="media_file" type="file" class="sr-only" accept="image/*,video/mp4,video/quicktime" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, MP4 up to 20MB</p>
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('media_file')" />
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-[#E07B2A] border border-transparent rounded-lg font-medium text-sm text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Upload
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
