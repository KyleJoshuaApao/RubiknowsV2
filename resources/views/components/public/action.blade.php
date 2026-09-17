@props([
    'href' => null,
    'tone' => 'gold',
    'type' => 'button',
])

@php($classes = 'rk-action rk-action--' . $tone)

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span>{{ $slot }}</span><span class="rk-action__arrow" aria-hidden="true">↗</span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span>{{ $slot }}</span><span class="rk-action__arrow" aria-hidden="true">↗</span>
    </button>
@endif
