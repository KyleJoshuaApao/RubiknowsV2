<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="form-label-v2">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="form-input-v2">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label-v2">Category</label>
                        <select name="category" id="category" class="form-input-v2">
                            <option value="">Select Category</option>
                            <option value="Engineering" {{ old('category') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Construction" {{ old('category') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>
                            <option value="Consultancy" {{ old('category') == 'Consultancy' ? 'selected' : '' }}>Consultancy</option>
                            <option value="Household" {{ old('category') == 'Household' ? 'selected' : '' }}>Household</option>
                            <option value="Maintainance" {{ old('category') == 'Maintainance' ? 'selected' : '' }}>Maintainance</option>
                            <option value="Aircon Cleaning" {{ old('category') == 'Aircon Cleaning' ? 'selected' : '' }}>Aircon Cleaning</option>
                            <option value="Repaire Hub" {{ old('category') == 'Repaire Hub' ? 'selected' : '' }}>Repaire Hub</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="short_description" class="form-label-v2">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="3" class="form-input-v2">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label-v2">Full Content</label>
                        <textarea name="content" id="content" rows="6" class="form-input-v2">{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Feature this service on the homepage
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.services.index') }}" class="btn-secondary mr-3">Cancel</a>
                        <button type="submit" class="btn-primary">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

