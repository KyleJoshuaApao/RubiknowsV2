<x-public-layout>
    <x-slot name="title">Testimonials</x-slot>
    <x-slot name="description">What clients say about working with RUBIKNOWS on their engineering and construction projects.</x-slot>

    <x-public.page-header tone="light" title="Testimonials" :breadcrumbs="['Testimonials' => null]" />

    <section class="rk-section">
        <div class="rk-container">
            @if($testimonials->isNotEmpty())
                <div class="rk-testimonials">
                    @foreach($testimonials as $testimonial)
                        <figure class="rk-testimonial">
                            <blockquote><p>{{ $testimonial->quote }}</p></blockquote>
                            <figcaption>
                                @if($testimonial->avatar_path)
                                    <img src="{{ \App\Support\MediaUrl::for($testimonial->avatar_path) }}" alt="" loading="lazy">
                                @else
                                    <span class="rk-testimonial__initial" aria-hidden="true">{{ mb_strtoupper(mb_substr($testimonial->client_name, 0, 1)) }}</span>
                                @endif
                                <span>
                                    <strong>{{ $testimonial->client_name }}</strong>
                                    @if($testimonial->role || $testimonial->company)<span>{{ collect([$testimonial->role, $testimonial->company])->filter()->join(', ') }}</span>@endif
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                {{ $testimonials->links('vendor.pagination.public') }}
            @else
                <x-public.empty-state title="No testimonials yet" message="Client feedback will appear here. Ask us for references from past clients." />
            @endif
        </div>
    </section>

    <x-public.contact-band />
</x-public-layout>
