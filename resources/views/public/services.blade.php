<x-public-layout>
    <x-slot name="title">Our Services</x-slot>

    <!-- ===== PAGE HEADER ===== -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gray-900 text-white relative kh-angled-bottom-right mb-16">
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
            <p class="text-white font-bold tracking-[0.2em] uppercase text-sm mb-6 flex items-center">
                What We Offer
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Our Expertise
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                Comprehensive engineering and construction solutions tailored to your unique requirements.
            </p>
        </div>
    </section>

    <!-- ===== SERVICES LIST ===== -->
    <section class="bg-gray-50 py-24 lg:py-32 border-t-8 border-brand-500 relative">
        <div class="max-w-screen-2xl mx-auto px-6">
            
            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Sticky Index (30%) -->
                <div class="lg:w-1/4 hidden lg:block">
                    <div class="sticky top-32 bg-white border-t-4 border-brand-500 shadow-lg p-8">
                        <h3 class="text-sm font-black text-richblack-900 uppercase tracking-widest mb-6 pb-4 border-b-2 border-brand-500 inline-block">Index</h3>
                        <ul class="space-y-4">
                            @foreach($services as $service)
                                <li>
                                    <a href="#service-{{ $service->id }}" class="text-sm font-bold text-gray-500 hover:text-brand-500 hover:translate-x-1 transition-all uppercase tracking-wider block truncate">
                                        <span class="text-brand-500 font-black mr-2">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span> 
                                        {{ $service->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Content Area (70%) -->
                <div class="lg:w-3/4 space-y-12">
                    @forelse($services as $service)
                        <div id="service-{{ $service->id }}" class="bg-white p-10 lg:p-16 shadow-lg hover:shadow-2xl transition-all duration-300 border-t-4 border-transparent hover:border-brand-500 group relative overflow-hidden">
                            <!-- Background accent on hover -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/5 transform translate-x-16 -translate-y-16 group-hover:scale-150 transition-transform duration-500 rounded-full blur-2xl"></div>
                            
                            <div class="flex flex-col md:flex-row md:items-start gap-8 relative z-10">
                                <div class="w-20 h-20 bg-richblack-950 flex items-center justify-center shrink-0 group-hover:bg-brand-500 transition-colors">
                                    <span class="text-3xl font-black text-white transition-colors">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-3xl lg:text-5xl font-black text-charcoal-700 mb-6 group-hover:text-brand-500 transition-colors tracking-tight">{{ $service->title }}</h2>
                                    
                                    @if($service->short_description)
                                        <div class="border-l-4 border-brand-500 pl-6 mb-8">
                                            <p class="text-xl text-gray-800 font-bold leading-relaxed">{{ $service->short_description }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="rich-text text-gray-600 font-medium leading-relaxed text-lg space-y-6 mb-10 max-w-3xl">
                                        {!! nl2br(e($service->content)) !!}
                                    </div>
                                    
                                    <div class="mt-8 inline-block">
                                        <x-kh-button href="{{ route('public.contact', ['subject' => 'Inquiry: ' . $service->title]) }}" text="Inquire About This" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center text-gray-500 font-bold uppercase tracking-widest bg-white shadow-lg border-t-4 border-brand-500">
                            No services available at this time.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="bg-richblack-950 text-white py-32 lg:py-48 relative overflow-hidden border-t-8 border-white border-b-8">
        <div class="absolute inset-0 bg-brand-500 opacity-20 transform -skew-y-3 origin-top-left"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <span class="block font-black tracking-[0.3em] uppercase text-brand-500 mb-8">Custom Solutions</span>
            <h2 class="text-white text-5xl lg:text-7xl font-black mb-8 leading-tight tracking-tighter uppercase">
                Need a Custom Plan?
            </h2>
            <p class="text-xl lg:text-2xl text-gray-300 max-w-2xl mx-auto leading-relaxed mb-12 font-bold">
                Our engineering team can tailor any service to your project's unique requirements.
            </p>
            <div class="mt-8 inline-block">
                <x-kh-button href="{{ route('public.contact') }}" text="Get a Custom Quote" />
            </div>
        </div>
    </section>
</x-public-layout>
