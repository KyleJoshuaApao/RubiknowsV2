<x-public-layout>
    <x-slot name="title">Gallery</x-slot>
    <x-slot name="description">Photos from RubiKnows construction sites and finished projects in Davao del Norte and across Mindanao.</x-slot>

    @php
        $items = $media->getCollection()->map(fn ($item) => [
            'title' => $item->title,
            'category' => $item->category,
            'type' => $item->type === 'Video' ? 'video' : 'photo',
            'url' => \App\Support\MediaUrl::for($item->url),
        ])->values();
        $categories = $items->pluck('category')->filter()->unique()->values();
    @endphp

    <x-public.page-header title="Gallery" lede="Photos from our sites, from the first excavation to the finished building." :breadcrumbs="['Gallery' => null]" />

    <section class="rk-section" x-data="rkGallery(@js($items))" @keydown.window="onKey($event)">
        <div class="rk-container">
            @if($items->isNotEmpty())
                @if($categories->count() > 1)
                    <ul class="rk-filter" aria-label="Filter photos">
                        <li><button type="button" @click="filter = ''" :aria-pressed="(filter === '').toString()">All</button></li>
                        @foreach($categories as $category)
                            <li><button type="button" @click="filter = @js($category)" :aria-pressed="(filter === @js($category)).toString()">{{ $category }}</button></li>
                        @endforeach
                    </ul>
                @endif

                <ul class="rk-mosaic" data-reveal-stagger>
                    @foreach($items as $index => $item)
                        <li class="rk-mosaic__item" x-show="!filter || filter === @js($item['category'])" x-transition.opacity.duration.250ms>
                            <button type="button" @click="open({{ $index }}, $event)" aria-label="Open {{ $item['type'] }}: {{ $item['title'] }}">
                                @if($item['type'] === 'video')
                                    <video src="{{ $item['url'] }}" muted preload="metadata" playsinline></video>
                                    <span class="rk-mosaic__play" aria-hidden="true"></span>
                                @else
                                    <img src="{{ $item['url'] }}" alt="" loading="lazy" decoding="async">
                                @endif
                                <span class="rk-mosaic__caption">
                                    @if($item['category'])<small>{{ $item['category'] }}</small>@endif
                                    {{ $item['title'] }}
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>
                {{ $media->links('vendor.pagination.public') }}
            @else
                <x-public.empty-state title="Photos are on the way" message="We are gathering photos from recent and ongoing projects. Contact us if you would like to see examples of our work.">
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact') }}">Contact us</a>
                </x-public.empty-state>
            @endif
        </div>

        <div class="rk-viewer" x-cloak x-show="current !== null" x-transition.opacity.duration.200ms @click.self="close()" role="dialog" aria-modal="true" aria-label="Photo viewer">
            <button type="button" class="rk-viewer__close" x-ref="close" @click="close()">Close</button>
            <button type="button" class="rk-viewer__nav rk-viewer__nav--prev" @click="step(-1)" aria-label="Previous" x-show="items.length > 1">&#8592;</button>
            <figure class="rk-viewer__figure" x-show="current !== null">
                <template x-if="item && item.type === 'photo'"><img :src="item.url" :alt="item.title"></template>
                <template x-if="item && item.type === 'video'"><video :src="item.url" controls autoplay playsinline></video></template>
                <figcaption>
                    <span x-text="item ? item.title : ''"></span>
                    <small x-text="(current + 1) + ' / ' + items.length"></small>
                </figcaption>
            </figure>
            <button type="button" class="rk-viewer__nav rk-viewer__nav--next" @click="step(1)" aria-label="Next" x-show="items.length > 1">&#8594;</button>
        </div>
    </section>

    @push('scripts')
        <script nonce="{{ Vite::cspNonce() }}">
            document.addEventListener('alpine:init', function () {
                Alpine.data('rkGallery', function (items) {
                    return {
                        items: items,
                        filter: '',
                        current: null,
                        opener: null,
                        get item() { return this.current === null ? null : this.items[this.current]; },
                        open(index, event) {
                            this.opener = event.currentTarget;
                            this.current = index;
                            document.body.style.overflow = 'hidden';
                            this.$nextTick(() => this.$refs.close.focus());
                        },
                        close() {
                            this.current = null;
                            document.body.style.overflow = '';
                            this.$nextTick(() => { if (this.opener) this.opener.focus(); });
                        },
                        step(direction) {
                            const visible = this.items.map((item, index) => index).filter((index) => !this.filter || this.items[index].category === this.filter);
                            const position = visible.indexOf(this.current);
                            this.current = visible[(position + direction + visible.length) % visible.length];
                        },
                        onKey(event) {
                            if (this.current === null) return;
                            if (event.key === 'Escape') this.close();
                            if (event.key === 'ArrowRight') this.step(1);
                            if (event.key === 'ArrowLeft') this.step(-1);
                        },
                    };
                });
            });
        </script>
    @endpush
</x-public-layout>
