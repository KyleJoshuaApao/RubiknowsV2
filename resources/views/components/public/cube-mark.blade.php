@props(['lit' => 1])

{{-- The 3x3 brand marker; the lit square counts through the page. --}}
<span {{ $attributes->merge(['class' => 'rk-cube-mark']) }} aria-hidden="true">
    @for($cell = 1; $cell <= 9; $cell++)
        <span @class(['is-lit' => $cell === (int) $lit])></span>
    @endfor
</span>
