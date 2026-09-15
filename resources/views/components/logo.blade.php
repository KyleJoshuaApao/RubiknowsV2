@props(['dark' => false, 'hideText' => false])

<div class="flex items-center gap-2">
    <img {{ $attributes->merge(['alt' => 'RubiKnows Logo', 'class' => 'object-contain']) }} src="{{ asset('RK4.webp') }}">
    @if(!$hideText)
    <span class="text-2xl tracking-tighter">
        <span class="{{ $dark ? 'text-white' : 'text-black' }} font-light">RUBI</span><span class="{{ $dark ? 'text-brand-500' : 'text-[#E07B2A]' }} font-bold">KNOWS</span>
    </span>
    @endif
</div>
