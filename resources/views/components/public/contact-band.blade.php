@props([
    'title' => 'Tell us about your project',
    'accent' => null,
    'text' => 'Send us your plans or a rough sketch. We will get back to you to set up a call or a site visit.',
    'featured' => false,
])

@if($featured)
    <section class="rk-cta" aria-labelledby="rk-cta-title">
        <div class="rk-container rk-cta__grid" data-reveal>
            <div>
                <h2 id="rk-cta-title" class="rk-cta__title">{{ $title }}@if($accent) <em>{{ $accent }}</em>@endif</h2>
                <p class="rk-cta__text">{{ $text }}</p>
                <div class="rk-cta__actions">
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quotation</a>
                    <a class="rk-btn rk-btn--ghost" href="{{ route('public.contact') }}">Send a message</a>
                </div>
            </div>

            {{-- The RUBIKNOWS cube: one solved square on top, two on the sides. --}}
            <svg class="rk-cta__cube" viewBox="0 0 400 400" aria-hidden="true">
                <polygon class="is-solved" points="156.7,125 200,100 243.3,125 200,150"/>
                <polygon class="is-half" points="70,175 113.3,200 113.3,250 70,225"/>
                <polygon class="is-half" points="286.7,250 330,225 330,275 286.7,300"/>
                <path class="is-grid" d="M113.3 100 L243.3 175 M156.7 75 L286.7 150 M243.3 75 L113.3 150 M286.7 100 L156.7 175 M113.3 150 V300 M156.7 175 V325 M70 175 L200 250 M70 225 L200 300 M243.3 175 V325 M286.7 150 V300 M330 175 L200 250 M330 225 L200 300"/>
                <path class="is-edge" d="M200 50 L330 125 V275 L200 350 L70 275 V125 Z M70 125 L200 200 L330 125 M200 200 V350"/>
            </svg>
        </div>
    </section>
@else
    <section class="rk-cta-line" aria-labelledby="rk-cta-title">
        <div class="rk-container rk-cta-line__inner">
            <h2 id="rk-cta-title">{{ $title }}</h2>
            <div class="rk-cta__actions">
                <a class="rk-btn rk-btn--primary" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quotation</a>
                <a class="rk-btn rk-btn--outline" href="{{ route('public.contact') }}">Send a message</a>
            </div>
        </div>
    </section>
@endif
