<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Edit Job Posting') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Job Title / Position" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $job->title)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <x-input-label for="type" value="Employment Type" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                            <option value="Full-time" {{ old('type', $job->type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('type', $job->type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ old('type', $job->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Internship" {{ old('type', $job->type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Location -->
                    <div>
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $job->location)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" value="Job Description" />
                    <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>{{ old('description', $job->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Requirements -->
                <div>
                    <x-input-label for="requirements" value="Requirements / Qualifications (Optional)" />
                    <textarea id="requirements" name="requirements" rows="5" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">{{ old('requirements', $job->requirements) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
                </div>

                <!-- Archived / Active Status -->
                <div class="block mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <label for="is_archived" class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_archived" type="checkbox" class="rounded border-gray-300 text-[#E07B2A] shadow-sm focus:ring-[#E07B2A]" name="is_archived" value="1" {{ old('is_archived', $job->is_archived) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <span class="font-medium text-gray-700">Archive this job</span>
                            <p class="text-gray-500">Archived jobs are hidden from the public careers page, but you can still view their historical applications.</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-[#E07B2A] border border-transparent rounded-lg font-medium text-sm text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Update Job
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
