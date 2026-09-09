<x-public-layout>
    <x-slot name="title">Our Services</x-slot>

    <!-- ===== PAGE HEADER ===== -->
    <section class="pt-12 pb-8 lg:pt-16 lg:pb-12 bg-gray-900 text-white relative rounded-none mb-8">
        <!-- Architectural Overlay -->
        <div class="absolute inset-0 z-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-screen-2xl mx-auto px-6 relative z-10 border-l-4 border-brand-500 ml-4 md:ml-8 lg:ml-12">
            <p class="text-white font-bold tracking-widest uppercase text-sm mb-4 flex items-center">
                Our Expertise
            </p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-none tracking-tight max-w-3xl">
                Professional Services
            </h1>
            <p class="mt-4 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-medium">
                Comprehensive engineering and construction solutions tailored to your needs.
            </p>
        </div>
    </section>

    <!-- ===== SERVICES GRID ===== -->
    <section class="bg-gray-50 py-8 lg:py-12 border-t-2 border-brand-500">
        <div class="max-w-screen-2xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                    <a href="{{ route('public.service-details', $service) }}"
                       class="group block bg-white border-t-4 border-brand-500 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-1"
                       x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                       style="animation-delay: {{ ($loop->index % 3) * 0.05 }}s">

                        @if($service->image_path)
                            <div class="aspect-[4/3] w-full overflow-hidden border-b-4 border-richblack-900">
                                <img src="{{ Storage::url($service->image_path) }}" alt="{{ $service->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out grayscale group-hover:grayscale-0">
                            </div>
                        @else
                            <div class="aspect-[4/3] w-full bg-richblack-900 flex items-center justify-center border-b-4 border-richblack-900">
                                <span class="text-4xl font-bold text-richblack-800 uppercase transform -rotate-6">Service</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-charcoal-700 mb-3 group-hover:text-brand-500 transition-colors">{{ $service->title }}</h3>
                            <p class="text-gray-600 text-base leading-relaxed line-height-6 mb-4">{!! $service->short_description !!}</p>

                            @if(!empty($service->features))
                                <div class="space-y-2">
                                    <h4 class="text-sm font-bold text-brand-500 mb-2">Key Features:</h4>
                                    <ul class="list-disc list-inside text-gray-600 text-sm space-y-1">
                                        @php
                                            $features = is_string($service->features)
                                                ? explode("\n", $service->features)
                                                : $service->features;
                                        @endphp
                                        @foreach($features as $feature)
                                            @if(trim($feature) !== '')
                                                <li>{{ trim($feature) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-4">
                                <x-kh-button href="{{ route('public.service-details', $service) }}" text="Learn More" class="w-full" />
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 bg-white shadow-lg border-t-4 border-brand-500">
                        <span class="block text-gray-300 text-4xl font-bold mb-4">00</span>
                        <p class="text-gray-500 uppercase tracking-widest font-medium text-sm">No services available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== PROCESS SECTION ===== -->
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="mb-6 flex flex-col md:flex-row justify-between items-end border-b-2 border-richblack-900 pb-3">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-charcoal-700 tracking-tight">Our Process</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Discovery -->
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border-l-2 border-brand-500 hover:bg-brand-50 transition-colors duration-200">
                    <div class="w-10 h-10 flex-shrink-0 bg-brand-500/10 flex items-center justify-center rounded-lg">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-charcoal-700 mb-1">Discovery</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">We begin by understanding your vision, goals, and requirements through collaborative discussions and site assessments.</p>
                    </div>
                </div>

                <!-- Design -->
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border-l-2 border-brand-500 hover:bg-brand-50 transition-colors duration-200">
                    <div class="w-10 h-10 flex-shrink-0 bg-brand-500/10 flex items-center justify-center rounded-lg">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-3-3h6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-charcoal-700 mb-1">Design</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Our team creates detailed plans and designs that balance aesthetics, functionality, and budget considerations.</p>
                    </div>
                </div>

                <!-- Execution -->
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border-l-2 border-brand-500 hover:bg-brand-50 transition-colors duration-200">
                    <div class="w-10 h-10 flex-shrink-0 bg-brand-500/10 flex items-center justify-center rounded-lg">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M3 21l18-18"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-charcoal-700 mb-1">Execution</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">We bring designs to life with skilled craftsmanship, quality materials, and meticulous attention to detail.</p>
                    </div>
                </div>

                <!-- Delivery -->
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border-l-2 border-brand-500 hover:bg-brand-50 transition-colors duration-200">
                    <div class="w-10 h-10 flex-shrink-0 bg-brand-500/10 flex items-center justify-center rounded-lg">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l3 3 4-4M5 19h14a2 2 0 002-2V6a2 2 0 012-2h.01M17 3h4a2 2 0 012 2v1.5a2 2 0 01-2 2v-2.5h-3.5a2 2 0 00-4 0H5a2 2 0 010 4h6a2 2 0 002 2v6a2 2 0 00-2 2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-charcoal-700 mb-1">Delivery</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">We ensure timely completion, thorough quality checks, and client satisfaction before project handover.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="py-10 lg:py-12 bg-richblack-950">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="mb-6 flex flex-col md:flex-row justify-between items-end border-b-2 border-richblack-900 pb-3">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-charcoal-700 tracking-tight">Client Success Stories</h2>
                </div>
                <div class="text-sm text-brand-500 font-medium uppercase tracking-widest">
                    Hear from those we've served
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @forelse($testimonials as $testimonial)
                    <div class="group block bg-white border-l-4 border-brand-500 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                        <div class="p-6">
                            <p class="text-gray-700 italic leading-relaxed mb-4">{!! $testimonial->content !!}</p>
                            <div class="flex items-center mt-4">
                                @if($testimonial->image_path)
                                    <img src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover mr-3">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-flex items-center justify-center">
                                        <span class="text-white font-bold">{{ substr($testimonial->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-base font-bold text-charcoal-900 mb-0.5">{{ $testimonial->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $testimonial->title ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">No testimonials available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>