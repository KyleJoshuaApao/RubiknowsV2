@props([
    'href',
    'icon',
    'label',
    'activeWhen' => [],
    'badge' => null,
    'badgeColor' => 'brand-500'
])

@php
    $isActive = false;
    foreach ($activeWhen as $pattern) {
        if (request()->routeIs($pattern)) {
            $isActive = true;
            break;
        }
    }
@endphp

<a href="{{ $href }}"
   class="group flex items-center px-4 py-3 text-sm font-bold transition-all duration-200 border-l-4
          {{ $isActive ? 'border-brand-500 bg-white/5 text-white' : 'border-transparent text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
    <svg class="w-5 h-5 mr-3 flex-shrink-0
              {{ $isActive ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }}
              transition-colors"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
        {{ $icon }}
    </svg>
    <span>{{ $label }}</span>

    @if($badge)
        <span class="ml-auto {{ $badgeColor }} text-white py-0.5 px-2 rounded-full text-[10px] font-semibold min-w-[20px] text-center">
            {{ $badge }}
        </span>
    @endif

    @if($isActive)
        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
    @endif
</a>