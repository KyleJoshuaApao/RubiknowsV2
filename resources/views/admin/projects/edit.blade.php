<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.projects.update', $project) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                            <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                            <input type="text" name="client" id="client" value="{{ old('client', $project->client) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $project->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-300 transition mr-2">Cancel</a>
                        <button type="submit" class="bg-[#E07B2A] text-white px-4 py-2 rounded shadow hover:bg-orange-600 transition">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
