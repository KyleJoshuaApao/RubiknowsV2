@props(['href', 'text' => 'LEARN MORE'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'group inline-flex items-stretch font-bold text-sm tracking-wide text-charcoal-700 transition-all duration-200 hover:-translate-y-0.5']) }}>
    <div class="bg-gray-100 pl-6 pr-8 py-3 flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-200 uppercase relative z-0 kh-angled-button-left">
        {{ $text }}
    </div>
    <div class="bg-brand-500 text-white px-4 py-3 flex items-center justify-center kh-angled-arrow-block group-hover:bg-brand-600 transition-colors duration-200 -ml-[15px] relative z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </div>
</a>
