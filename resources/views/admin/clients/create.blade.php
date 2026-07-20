<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Add New Client') }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Organization Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Type -->
                <div>
                    <x-input-label for="type" value="Organization Type" />
                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" required>
                        <option value="Client">Client</option>
                        <option value="Partner">Partner</option>
                        <option value="Sponsor">Sponsor</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>

                <!-- Logo -->
                <div>
                    <x-input-label for="logo" value="Organization Logo (Image)" />
                    <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#E07B2A] hover:file:bg-orange-100" accept="image/*" />
                    <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                </div>

                <!-- Success Story URL -->
                <div>
                    <x-input-label for="success_story_url" value="Success Story Link (Optional)" />
                    <x-text-input id="success_story_url" name="success_story_url" type="url" class="mt-1 block w-full" :value="old('success_story_url')" placeholder="https://..." />
                    <x-input-error class="mt-2" :messages="$errors->get('success_story_url')" />
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-[#E07B2A] border border-transparent rounded-lg font-medium text-sm text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                    Save Client
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
