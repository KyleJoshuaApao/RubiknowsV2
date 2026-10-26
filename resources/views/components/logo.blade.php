@props(['dark' => false, 'hideText' => false, 'textSize' => 'text-2xl'])

<div class="flex items-center gap-2">
    <img {{ $attributes->merge(['alt' => 'RubiKnows Logo', 'class' => 'object-contain']) }} src="{{ asset('RK4.webp') }}">
    @if(!$hideText)
    <span class="{{ $textSize }} tracking-tighter flex items-baseline" style="font-family: Inter, ui-sans-serif, system-ui, 'Segoe UI', Arial, sans-serif;">
        <span class="{{ $dark ? 'text-white' : 'text-black' }}" style="font-weight: 400;">RUBI</span><span class="text-brand-500 ml-[2px] inline-block origin-left" style="font-weight: 900; letter-spacing: .05em; -webkit-text-stroke: .04em currentColor; transform: scaleX(1.12); margin-right: .15em;">KNOWS</span>
    </span>
    @endif
</div>
