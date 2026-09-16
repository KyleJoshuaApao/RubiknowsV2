<x-public-layout>
    <x-slot name="title">{{ $service->title }}</x-slot>

    <section class="relative overflow-hidden bg-richblack-900 py-20 text-white md:py-28">
        <div class="absolute inset-0 opacity-10" aria-hidden="true">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="service-grid" width="48" height="48" patternUnits="userSpaceOnUse">
                        <path d="M48 0H0V48" fill="none" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#service-grid)" />
            </svg>
        </div>

        <div class="relative mx-auto max-w-screen-xl px-6 lg:px-12">
            <a href="{{ route('public.services') }}" class="mb-8 inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-brand-300 transition-colors hover:text-white">
                <span aria-hidden="true">&larr;</span> All services
            </a>
            @if($service->category)
                <p class="mb-4 text-xs font-black uppercase tracking-[0.2em] text-brand-300">{{ $service->category }}</p>
            @endif
            <h1 class="max-w-4xl text-4xl font-black uppercase tracking-tight md:text-6xl">{{ $service->title }}</h1>
            @if($service->short_description)
                <p class="mt-6 max-w-3xl text-lg font-medium leading-relaxed text-gray-200 md:text-xl">{{ $service->short_description }}</p>
            @endif
        </div>
    </section>

    <section class="bg-white py-16 md:py-24">
        <article class="prose prose-lg mx-auto max-w-4xl px-6 prose-headings:font-black prose-headings:text-richblack-900 prose-a:text-brand-600 lg:px-12">
            @if($service->content)
                {!! nl2br(e($service->content)) !!}
            @else
                <p>Our team will tailor this service to your project requirements. Contact us to discuss your needs.</p>
            @endif
        </article>
    </section>
</x-public-layout>
