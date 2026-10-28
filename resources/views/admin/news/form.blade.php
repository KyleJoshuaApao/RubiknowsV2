<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
            {{ $post->exists ? 'Edit News Post' : 'Add News Post' }}
        </h2>
    </x-slot>

    <div class="mt-6 bg-white shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ $post->exists ? route('admin.news.update', $post) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($post->exists) @method('PUT') @endif

            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <x-input-label for="facebook_url" value="Link to the Facebook post" />
                    <x-text-input id="facebook_url" name="facebook_url" type="url" class="mt-1 block w-full" :value="old('facebook_url', $post->facebook_url)" placeholder="https://www.facebook.com/..." required />
                    <p class="text-xs text-gray-500 mt-1">On Facebook, open the post, click its date or the “…” menu, choose “Copy link”, and paste it here.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('facebook_url')" />
                </div>

                <div>
                    <x-input-label for="title" value="Headline (optional)" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post->title)" maxlength="150" placeholder="e.g. Roof slab poured at our Apokon project" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div>
                    <x-input-label for="body" value="Description" />
                    <textarea id="body" name="body" rows="5" maxlength="2000" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" required>{{ old('body', $post->body) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">A short summary. The home page shows the first few lines; visitors read the rest on Facebook.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('body')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="posted_at" value="Date and time" />
                        <x-text-input id="posted_at" name="posted_at" type="datetime-local" class="mt-1 block w-full" :value="old('posted_at', $post->posted_at?->format('Y-m-d\TH:i'))" required />
                        <p class="text-xs text-gray-500 mt-1">Posts dated in the future appear on the site at that time.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('posted_at')" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Photo" />
                        @if($post->image_path)
                            <img src="{{ \App\Support\MediaUrl::for($post->image_path) }}" alt="" class="mt-1 mb-2 h-24 w-auto object-cover border border-gray-200">
                        @endif
                        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-1 block w-full text-sm text-gray-700">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or WEBP, up to 8 MB.{{ $post->image_path ? ' Choose a file only to replace the current photo.' : '' }}</p>
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>
                </div>

                <label for="is_published" class="inline-flex items-center">
                    <input type="hidden" name="is_published" value="0">
                    <input id="is_published" type="checkbox" class="rounded border-gray-300 text-brand-500 shadow-sm" name="is_published" value="1" @checked(old('is_published', $post->is_published ?? true))>
                    <span class="ml-2 text-sm text-gray-600">Show on the website</span>
                </label>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 font-medium text-sm text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-brand-500 border border-transparent font-medium text-sm text-white hover:bg-brand-600 transition-colors shadow-sm">
                    {{ $post->exists ? 'Save Changes' : 'Publish Post' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
