@props(['dark' => false, 'hideText' => false, 'textSize' => 'text-2xl'])

<div class="flex items-center gap-2">
    <img {{ $attributes->merge(['alt' => 'RubiKnows Logo', 'class' => 'object-contain']) }} src="{{ asset('images/RK4.webp') }}">
    @if(!$hideText)
    <span class="{{ $textSize }} tracking-tighter flex items-baseline">
        <span class="{{ $dark ? 'text-white' : 'text-black' }} font-light">RUBI</span><span class="text-gold-500 font-bold ml-[1px]">KNOWS</span>
    </span>
    @endif
</div>
