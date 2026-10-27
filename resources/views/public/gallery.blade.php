<x-public-layout>
    <x-slot name="title">Gallery</x-slot>
    <x-slot name="description">Photos from RubiKnows construction sites and finished projects in Davao del Norte and across Mindanao.</x-slot>

    <x-public.page-header title="Gallery" lede="Photos from our sites and finished work." :breadcrumbs="['Gallery' => null]" />

    <section class="rk-section" x-data="{ selected: null, caption: '', opener: null, open(url, text, event) { this.opener = event.currentTarget; this.selected = url; this.caption = text; this.$nextTick(() => this.$refs.close.focus()) }, close() { this.selected = null; this.$nextTick(() => { if (this.opener && this.opener.isConnected) this.opener.focus() }) } }">
        <div class="rk-container">
            @if($media->isNotEmpty())
                <div class="rk-gallery-grid">
                    @foreach($media as $item)
                        @php($url = \App\Support\MediaUrl::for($item->url))
                        <figure class="rk-gallery-item">
                            @if($item->type === 'Video')
                                <video controls preload="metadata" aria-label="{{ $item->title }}"><source src="{{ $url }}">Your browser cannot play this video.</video>
                            @else
                                <button type="button" @click="open(@js($url), @js($item->title), $event)" aria-label="View larger: {{ $item->title }}">
                                    <img src="{{ $url }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
                                </button>
                            @endif
                            <figcaption>
                                {{ $item->title }}
                                @if($item->category)<span>{{ $item->category }}</span>@endif
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                {{ $media->links('vendor.pagination.public') }}
            @else
                <x-public.empty-state title="Photos are on the way" message="We are gathering photos from recent projects. Check back soon, or contact us to see examples of our work.">
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact') }}">Contact us</a>
                </x-public.empty-state>
            @endif
        </div>

        <div class="rk-lightbox" x-cloak x-show="selected" @click.self="close()" @keydown.escape.window="close()" @keydown.tab.prevent="$refs.close.focus()" role="dialog" aria-modal="true" aria-label="Photo viewer">
            <button type="button" class="rk-lightbox__close" x-ref="close" @click="close()">Close</button>
            <figure>
                <img :src="selected" :alt="caption">
                <figcaption x-text="caption"></figcaption>
            </figure>
        </div>
    </section>
</x-public-layout>
