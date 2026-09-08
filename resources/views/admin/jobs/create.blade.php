<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Post New Job') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white  shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Job Title / Position" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus placeholder="e.g. Senior Civil Engineer" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <x-input-label for="type" value="Employment Type" />
                        <select id="type" name="type" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" required>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <!-- Location -->
                    <div>
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required placeholder="e.g. Manila, Remote, On-site" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" value="Job Description" />
                    <textarea id="description" name="description" rows="5" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" required placeholder="Describe the role and responsibilities...">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Requirements -->
                <div>
                    <x-input-label for="requirements" value="Requirements / Qualifications (Optional)" />
                    <textarea id="requirements" name="requirements" rows="5" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" placeholder="List the necessary skills and qualifications...">{{ old('requirements') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
                </div>

                <!-- Archived / Active Status -->
                <div class="block mt-4">
                    <label for="is_archived" class="inline-flex items-center">
                        <input id="is_archived" type="checkbox" class="rounded border-gray-300 text-brand-500 shadow-sm focus:ring-[#E07B2A]" name="is_archived" value="1" {{ old('is_archived') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Archive this job (Hide from public website)') }}</span>
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300  font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-brand-500 border border-transparent  font-medium text-sm text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Post Job
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

