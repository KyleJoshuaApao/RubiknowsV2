<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8">
                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="category_id" class="form-label-v2">Category</label>
                            <input type="text" name="category_id" id="category_id" value="{{ old('category_id', $project->category_id) }}" placeholder="e.g. Civil Engineering" class="form-input-v2">
                        </div>

                        <div>
                            <label for="image_file" class="form-label-v2">Project Cover Image</label>
                            @if($project->image_url)
                                <div class="mt-2 mb-3 flex items-center gap-3">
                                    <img src="{{ Storage::disk('public')->url($project->image_url) }}"
                                         alt="Current Cover"
                                         class="h-24 w-36 object-cover  border border-gray-200 shadow-sm">
                                    <div>
                                        <p class="text-xs text-green-600 font-semibold">✓ Image uploaded</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Choose a new file below to replace it</p>
                                    </div>
                                </div>
                            @else
                                <p class="mt-1 text-xs text-gray-400">No image uploaded yet.</p>
                            @endif
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
                            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required class="form-input-v2">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label-v2">Status</label>
                            <select name="status" id="status" class="form-input-v2">
                                <option value="Latest" {{ old('status', $project->status) == 'Latest' ? 'selected' : '' }}>Latest</option>
                                <option value="Featured" {{ old('status', $project->status) == 'Featured' ? 'selected' : '' }}>Featured</option>
                                <option value="Ongoing" {{ old('status', $project->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="Upcoming" {{ old('status', $project->status) == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="client" class="form-label-v2">Client</label>
                            <input type="text" name="client" id="client" value="{{ old('client', $project->client) }}" class="form-input-v2">
                        </div>

                        <div>
                            <label for="location" class="form-label-v2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}" class="form-input-v2">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label-v2">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-input-v2">{{ old('description', $project->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.projects.index') }}" class="btn-secondary mr-3">Cancel</a>
                        <button type="submit" class="btn-primary">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

