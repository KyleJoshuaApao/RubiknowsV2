<x-public-layout>
    <x-slot name="title">Gallery</x-slot>

    <x-public.page-intro eyebrow="In the field" number="04" title="A closer look at the work." lede="Scenes from planning, construction, collaboration, and the projects that reach completion." />

    <section class="rk-section" x-data="{ selectedImage: null, opener: null, openImage(url, event) { this.opener = event.currentTarget; this.selectedImage = url; this.$nextTick(() => this.$refs.lightboxClose.focus()) }, closeImage() { this.selectedImage = null; this.$nextTick(() => { if (this.opener && this.opener.isConnected) this.opener.focus() }) } }">
        <div class="rk-container">
            <div class="rk-gallery-grid">
                @forelse($media as $image)
                    @php($mediaUrl = \App\Support\MediaUrl::for($image->url))
                    <figure class="rk-gallery-tile" @if($image->type === 'Photo') role="button" tabindex="0" aria-label="View {{ $image->title }} in a larger size" @click="openImage(@js($mediaUrl), $event)" @keydown.enter.prevent="openImage(@js($mediaUrl), $event)" @keydown.space.prevent="openImage(@js($mediaUrl), $event)" @endif>
                        @if($image->type === 'Video')
                            <video controls preload="metadata" aria-label="{{ $image->title }}"><source src="{{ $mediaUrl }}">Your browser does not support this video.</video>
                        @else
                            <img loading="lazy" decoding="async" src="{{ $mediaUrl }}" alt="{{ $image->title }}">
                        @endif
                        <figcaption class="rk-gallery-tile__caption">
                            <h2>{{ $image->title }}</h2>
                            @if($image->category)<p>{{ $image->category }}</p>@endif
                        </figcaption>
                    </figure>
                @empty
                    <p class="rk-empty col-span-full">No images have been added to the gallery yet.</p>
                @endforelse
            </div>

            @if($media->hasPages())
                <div class="mt-12 flex justify-center">{{ $media->links('vendor.pagination.tailwind') }}</div>
            @endif
        </div>

        <div x-cloak x-show="selectedImage" class="rk-lightbox" @click.self="closeImage()" @keydown.escape.window="closeImage()" @keydown.tab.prevent="$refs.lightboxClose.focus()" role="dialog" aria-modal="true" aria-label="Image preview">
            <button x-ref="lightboxClose" type="button" class="rk-lightbox__close" @click="closeImage()" aria-label="Close image preview">×</button>
            <img :src="selectedImage" alt="Gallery image preview">
        </div>
    </section>
</x-public-layout>
