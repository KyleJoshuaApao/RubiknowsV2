<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white  shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Organization Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $client->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Type -->
                <div>
                    <x-input-label for="type" value="Organization Type" />
                    <select id="type" name="type" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" required>
                        <option value="Client" {{ (old('type', $client->type) == 'Client') ? 'selected' : '' }}>Client</option>
                        <option value="Partner" {{ (old('type', $client->type) == 'Partner') ? 'selected' : '' }}>Partner</option>
                        <option value="Sponsor" {{ (old('type', $client->type) == 'Sponsor') ? 'selected' : '' }}>Sponsor</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>

                <!-- Logo -->
                <div>
                    <x-input-label for="logo" value="Organization Logo (Image)" />
                    @if($client->logo_url)
                        <div class="mt-2 mb-3">
                            <img src="{{ Storage::url($client->logo_url) }}" class="h-16 rounded border bg-gray-50 p-1">
                        </div>
                    @endif
                    <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file: file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-orange-100" accept="image/*" />
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep the current logo.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                </div>

                <!-- Success Story URL -->
                <div>
                    <x-input-label for="success_story_url" value="Success Story Link (Optional)" />
                    <x-text-input id="success_story_url" name="success_story_url" type="url" class="mt-1 block w-full" :value="old('success_story_url', $client->success_story_url)" placeholder="https://..." />
                    <x-input-error class="mt-2" :messages="$errors->get('success_story_url')" />
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300  font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-brand-500 border border-transparent  font-medium text-sm text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Update Client
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

