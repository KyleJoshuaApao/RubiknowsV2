<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                        <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Full Content</label>
                        <textarea name="content" id="content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Feature this service on the homepage
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.services.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-300 transition mr-2">Cancel</a>
                        <button type="submit" class="bg-[#E07B2A] text-white px-4 py-2 rounded shadow hover:bg-orange-600 transition">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
