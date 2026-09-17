@props([
    'eyebrow' => 'RubiKnows',
    'title',
    'lede' => null,
    'number' => null,
])

<section {{ $attributes->merge(['class' => 'rk-page-intro']) }}>
    <div class="rk-page-intro__rule" aria-hidden="true"></div>
    <div class="rk-container rk-page-intro__inner">
        <div class="rk-page-intro__meta">
            <x-public.eyebrow>{{ $eyebrow }}</x-public.eyebrow>
            @if($number)
                <span class="rk-page-intro__number">{{ $number }}</span>
            @endif
        </div>
        <div class="rk-page-intro__copy">
            <h1>{{ $title }}</h1>
            @if($lede)
                <p>{{ $lede }}</p>
            @endif
        </div>
    </div>
</section>
