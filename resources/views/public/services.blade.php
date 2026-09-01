<x-public-layout>
    <x-slot name="title">Our Services</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-24 pb-16 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class=" mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    What We Offer
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                Our <span class="gold-shimmer-text italic font-black">Services</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Comprehensive engineering and construction solutions tailored to your needs.
            </p>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="py-20 lg:py-44 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($services as $service)
                    @php
                        $titleLower = strtolower($service->title);
                        $iconSvg = null;
                        if (str_contains($titleLower, 'household')) {
                            $iconSvg = 'household';
                        } elseif (str_contains($titleLower, 'maintain') || str_contains($titleLower, 'mainten')) {
                            $iconSvg = 'maintenance';
                        } elseif (str_contains($titleLower, 'aircon') || str_contains($titleLower, 'air cond')) {
                            $iconSvg = 'aircon';
                        } elseif (str_contains($titleLower, 'repaire') || str_contains($titleLower, 'repair')) {
                            $iconSvg = 'repair';
                        }
                    @endphp
                     <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                          class=" group flex flex-col h-full bg-white border border-gray-100 rounded-[2rem] hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700"
                          style="animation-delay: {{ $loop->index * 0.08 }}s">
                         <div class="p-6 lg:p-8 flex-grow flex flex-col">
                             <div class="flex items-center justify-between mb-8">
                                 <div class="w-14 h-14 rounded-[1.5rem] bg-gradient-to-br from-orange-500 to-amber-50 flex items-center justify-center shadow-xl shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                                @if($iconSvg === 'household')
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3 9l9-7 9 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="12" cy="7" r="1.5" fill="currentColor" />
                                    </svg>
                                @elseif($iconSvg === 'maintenance')
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.22 2h-.44a1 1 0 00-.99.83l-.23 1.4a8.13 8.13 0 00-1.37.57l-1.25-.66a1 1 0 00-1.24.24l-.31.38a1 1 0 00-.08 1.25l.76 1.19a8.15 8.15 0 00-.73 1.29l-1.39.29a1 1 0 00-.79.98v.44a1 1 0 00.79.98l1.39.29c.2.46.45.89.73 1.29l-.76 1.19a1 1 0 00.08 1.25l.31.38a1 1 0 001.24.24l1.25-.66c.42.25.88.44 1.37.57l.23 1.4a1 1 0 00.99.83h.44a1 1 0 00.99-.83l.23-1.4a8.13 8.13 0 001.37-.57l1.25.66a1 1 0 001.24-.24l.31-.38a1 1 0 00.08-1.25l-.76-1.19c.28-.4.53-.83.73-1.29l1.39-.29a1 1 0 00.79-.98v-.44a1 1 0 00-.79-.98l-1.39-.29a8.15 8.15 0 00-.73-1.29l.76-1.19a1 1 0 00-.08-1.25l-.31-.38a1 1 0 00-1.24-.24l-1.25.66a8.13 8.13 0 00-1.37-.57l-.23-1.4a1 1 0 00-.99-.83z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M14.7 14.7l5.3-5.3a2 2 0 1 0-2.82-2.82l-5.3 5.3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="10" cy="14" r="3" stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                @elseif($iconSvg === 'aircon')
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="4" width="18" height="9" rx="1.5" stroke="currentColor" stroke-width="1.5" />
                                        <path d="M6 13h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M8 17c.5 1 1.5 1.5 2.5 1.5s2-.5 2-1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M11 18c.5 1 1.5 1.5 2.5 1.5s2-.5 2-1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                @elseif($iconSvg === 'repair')
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                        <path d="M14.5 17.5l-5-5a2.5 2.5 0 113.5-3.5l5 5a2.5 2.5 0 01-3.5 3.5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 18l4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                @else
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M2 17l10 5 10-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M2 7v10l10 5V12L2 7z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                @endif
                             </div>
                             <div class="text-sm font-bold text-orange-500 font-mono tracking-wider mb-3">
                                 #{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                             </div>
                         </div>
                         <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors duration-300">{{ $service->title }}</h3>
                         @if($service->short_description)
                                 <p class="text-sm text-gray-700 font-semibold mb-2">{{ $service->short_description }}</p>
                             @endif
                             <div class="text-gray-600 mb-6 flex-grow whitespace-pre-line text-sm leading-relaxed">{!! nl2br(e($service->content)) !!}</div>
                             <div class="mt-auto pt-6 border-t border-gray-100">
                                 <a href="{{ route('public.contact', ['subject' => 'Inquiry: ' . $service->title]) }}" class="inline-flex items-center justify-center w-full px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-500 text-white font-bold rounded-full shadow-xl shadow-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 transition-all duration-500 text-sm">
                                     Inquire About This
                                     <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                 </a>
                             </div>
                         </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">No services available at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Premium 3D CTA Section -->
    <div class="relative bg-white py-20 lg:py-32 overflow-hidden">
        <!-- 3D Perspective Grid -->
        <div class="absolute inset-0 bg-grid-pattern-light opacity-50 pointer-events-none" style="transform: perspective(1000px) rotateX(60deg) scale(2.5); transform-origin: top; mask-image: linear-gradient(to bottom, transparent, black 40%, transparent);"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- 3D Glassmorphic Card -->
            <div class="relative bg-gradient-to-br from-gray-950 via-gray-900 to-[#0a0a0a] rounded-[2.5rem] p-6 sm:p-8 lg:p-20 overflow-hidden shadow-[0_40px_80px_-20px_rgba(0,0,0,0.5),inset_0_2px_10px_rgba(255,255,255,0.05),inset_0_-1px_0_rgba(255,255,255,0.02)] border border-white/10 group transform hover:-translate-y-2 transition-transform duration-700">
                
                <!-- Inner 3D Lighting -->
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/10 rounded-full blur-[100px] pointer-events-none transform translate-x-1/3 -translate-y-1/3 group-hover:bg-brand-500/20 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none transform -translate-x-1/3 translate-y-1/3 group-hover:bg-amber-500/15 transition-colors duration-700"></div>
                <div class="absolute inset-0 bg-grid-pattern-dark opacity-[0.05] pointer-events-none mix-blend-overlay"></div>

                <div class="relative z-20 text-center max-w-4xl mx-auto">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="h-px w-20 bg-gradient-to-r from-yellow-500 to-orange-300"></div>
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Custom Solutions</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Need a <span class="gold-shimmer-text italic font-black">Custom Solution?</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Our engineering team can tailor any service to your project's unique requirements.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-500 font-bold text-sm">
                        Get a Custom Quote
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-public-layout>
