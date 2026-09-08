<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Edit Testimonial') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white  shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Client Name -->
                <div>
                    <x-input-label for="client_name" value="Client Name" />
                    <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name', $testimonial->client_name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('client_name')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company -->
                    <div>
                        <x-input-label for="company" value="Company (Optional)" />
                        <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $testimonial->company)" />
                        <x-input-error class="mt-2" :messages="$errors->get('company')" />
                    </div>

                    <!-- Role -->
                    <div>
                        <x-input-label for="role" value="Role/Title (Optional)" />
                        <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $testimonial->role)" placeholder="e.g. CEO, Project Manager" />
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                </div>

                <!-- Quote -->
                <div>
                    <x-input-label for="quote" value="Testimonial Quote" />
                    <textarea id="quote" name="quote" rows="4" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" required>{{ old('quote', $testimonial->quote) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('quote')" />
                </div>

                <!-- Published -->
                <div class="block mt-4">
                    <label for="is_published" class="inline-flex items-center">
                        <input id="is_published" type="checkbox" class="rounded border-gray-300 text-brand-500 shadow-sm focus:ring-[#E07B2A]" name="is_published" value="1" {{ old('is_published', $testimonial->is_published) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Publish on Website') }}</span>
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300  font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-brand-500 border border-transparent  font-medium text-sm text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Update Testimonial
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

