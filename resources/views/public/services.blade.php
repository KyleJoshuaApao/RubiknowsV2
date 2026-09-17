<x-public-layout>
    <x-slot name="title">Our Services</x-slot>

    <x-public.page-intro eyebrow="Capabilities" number="03" title="Practical expertise for consequential work." lede="RubiKnows brings the disciplines needed to move projects from an early question to a considered outcome." />

    <section class="rk-section">
        <div class="rk-container">
            <div class="rk-numbered-list">
                @forelse($services as $service)
                    <article class="rk-numbered-list__item">
                        <span class="rk-numbered-list__number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2>{{ $service->title }}</h2>
                        <div>
                            <p>{{ $service->short_description ?? Str::limit(strip_tags($service->content), 185) }}</p>
                            <a class="rk-text-link mt-5" href="{{ route('public.service-details', $service) }}">Explore service</a>
                        </div>
                    </article>
                @empty
                    <p class="rk-empty">No services are available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="rk-section rk-section--paper">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>Our process</x-public.eyebrow>
                    <h2 class="rk-section__title">A clear path from first brief to handover.</h2>
                </div>
            </div>
            <div class="rk-numbered-list">
                <article class="rk-numbered-list__item"><span class="rk-numbered-list__number">01</span><h3>Discovery</h3><p>We listen closely, assess the brief, and frame the questions that matter before work begins.</p></article>
                <article class="rk-numbered-list__item"><span class="rk-numbered-list__number">02</span><h3>Design</h3><p>We develop a clear technical response that balances performance, purpose, and project constraints.</p></article>
                <article class="rk-numbered-list__item"><span class="rk-numbered-list__number">03</span><h3>Delivery</h3><p>We coordinate the work with an eye on quality, safety, communication, and the practical realities of site.</p></article>
                <article class="rk-numbered-list__item"><span class="rk-numbered-list__number">04</span><h3>Handover</h3><p>We close with care, ensuring the work is ready for the people and operations it is intended to serve.</p></article>
            </div>
        </div>
    </section>

    @if(($testimonials ?? collect())->isNotEmpty())
        <section class="rk-section rk-section--ink">
            <div class="rk-container">
                <div class="rk-section__head">
                    <div class="rk-section__head-copy">
                        <x-public.eyebrow>Client perspective</x-public.eyebrow>
                        <h2 class="rk-section__title text-white">Trusted to make the details count.</h2>
                    </div>
                </div>
                <div class="rk-quote-grid">
                    @foreach($testimonials as $testimonial)
                        <article class="rk-quote bg-white/5 text-white">
                            <span class="rk-quote__mark" aria-hidden="true">“</span>
                            <p class="rk-quote__body">{{ $testimonial->quote }}</p>
                            <p class="rk-quote__by">{{ $testimonial->client_name }}</p>
                            <p class="rk-quote__company text-white/55">{{ $testimonial->company }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-public-layout>
