<x-public-layout>
    <x-slot name="title">Clients & Partners</x-slot>

    {{-- ====================== HERO ====================== --}}
    <div class="relative bg-white pt-24 pb-16 lg:pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.04] pointer-events-none"></div>
        {{-- Ambient glow --}}
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-orange-100/40 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                    Trusted By Industry Leaders
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-sans font-black text-black tracking-tight mt-6 mb-6"
                x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.1s">
                Our <span class="gold-shimmer-text italic">Clients</span> &amp;<br>
                <span class="gold-shimmer-text italic">Partners</span>
            </h1>
            <p class="text-base md:text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed"
               x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                We are proud to collaborate with distinguished organizations across Mindanao and beyond.
                Every name here represents a relationship built on trust, quality, and shared vision.
            </p>


        </div>
    </div>

    {{-- ====================== CLIENTS SECTION ====================== --}}
    <div class="py-20 lg:py-32 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-50 rounded-full blur-[200px] opacity-60 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Section header --}}
            <div class="mb-16" x-data x-intersect.once="$el.classList.add('animate-fade-in-left')" class="">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-16 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-widest">Who We Serve</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-sans font-black text-gray-900 tracking-tight">Our Clients</h2>
                <p class="text-gray-500 mt-3 max-w-xl">Organizations that have trusted RubiKnows to engineer and build their vision.</p>
            </div>

            @if($clients->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($clients as $i => $client)
                        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                             class=" group"
                             style="animation-delay: {{ ($i % 10) * 0.06 }}s">
                            <div class="relative bg-white border border-gray-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center
                                        hover:border-orange-400 hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-400 aspect-square">
                                {{-- Logo or initials --}}
                                @if($client->logo_url)
                                    <img src="{{ Str::startsWith($client->logo_url, ['http://', 'https://']) ? $client->logo_url : Storage::url($client->logo_url) }}" alt="{{ $client->name }}"
                                         class="max-h-14 max-w-[80%] object-contain grayscale group-hover:grayscale-0 transition-all duration-500">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-50 flex items-center justify-center mb-3 group-hover:from-orange-500 group-hover:to-amber-400 transition-all duration-500">
                                        <span class="text-xl font-black text-orange-600 group-hover:text-white transition-colors duration-500">
                                            {{ strtoupper(substr($client->name, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-xs font-semibold text-gray-700 mt-3 leading-tight group-hover:text-orange-600 transition-colors duration-300">
                                    {{ $client->name }}
                                </p>
                                @if($client->success_story_url)
                                    <a href="{{ $client->success_story_url }}" target="_blank" rel="noopener noreferrer"
                                       class="mt-2 text-[10px] font-semibold text-orange-500 hover:underline opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        View Story →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Placeholder grid when no clients are added yet --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach(range(1,10) as $n)
                        <div class="bg-white border border-dashed border-gray-200 rounded-2xl aspect-square flex items-center justify-center">
                            <span class="text-gray-300 text-xs font-medium">Client {{ $n }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-8 text-center text-sm text-gray-400 italic">
                    No clients added yet — add them from the admin panel under <strong>Clients</strong>.
                </p>
            @endif
        </div>
    </div>

    {{-- ====================== PARTNERS SECTION ====================== --}}
    <div class="py-20 lg:py-32 bg-white relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-50 rounded-full blur-[200px] opacity-60 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Section header --}}
            <div class="mb-16" x-data x-intersect.once="$el.classList.add('animate-fade-in-right')" class="">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-16 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-widest">Strategic Alliances</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-sans font-black text-gray-900 tracking-tight">Our Partners</h2>
                <p class="text-gray-500 mt-3 max-w-xl">Trusted organizations that collaborate with us to deliver exceptional results.</p>
            </div>

            @if($partners->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8">
                    @foreach($partners as $i => $partner)
                        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                             class=" group"
                             style="animation-delay: {{ ($i % 8) * 0.07 }}s">
                            <div class="relative bg-white border border-gray-100 rounded-3xl p-8 flex flex-col items-center justify-center text-center
                                        hover:border-orange-400 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-500">
                                {{-- Accent top bar --}}
                                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-orange-500 to-amber-400 rounded-t-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                @if($partner->logo_url)
                                    <img src="{{ Str::startsWith($partner->logo_url, ['http://', 'https://']) ? $partner->logo_url : Storage::url($partner->logo_url) }}" alt="{{ $partner->name }}"
                                         class="max-h-16 max-w-[75%] object-contain grayscale group-hover:grayscale-0 transition-all duration-500 mb-4">
                                @else
                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-50 flex items-center justify-center mb-4 group-hover:from-orange-500 group-hover:to-amber-400 transition-all duration-500">
                                        <span class="text-2xl font-black text-orange-600 group-hover:text-white transition-colors duration-500">
                                            {{ strtoupper(substr($partner->name, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300">
                                    {{ $partner->name }}
                                </p>
                                @if($partner->success_story_url)
                                    <a href="{{ $partner->success_story_url }}" target="_blank" rel="noopener noreferrer"
                                       class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-orange-500 hover:underline opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        Learn More
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8">
                    @foreach(range(1,4) as $n)
                        <div class="bg-white border border-dashed border-gray-200 rounded-3xl aspect-square flex items-center justify-center">
                            <span class="text-gray-300 text-xs font-medium">Partner {{ $n }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-8 text-center text-sm text-gray-400 italic">
                    No partners added yet — add them from the admin panel under <strong>Clients</strong> with type = <em>partner</em>.
                </p>
            @endif
        </div>
    </div>

    {{-- ====================== SPONSORS SECTION ====================== --}}
    <div class="py-20 lg:py-32 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-brand-50 rounded-full blur-[200px] opacity-60 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-16" x-data x-intersect.once="$el.classList.add('animate-fade-in-left')" class="">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-16 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-widest">Our Supporters</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-sans font-black text-gray-900 tracking-tight">Our Sponsors</h2>
                <p class="text-gray-500 mt-3 max-w-xl">Organizations that sponsor and empower our mission.</p>
            </div>

            @if(isset($sponsors) && $sponsors->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($sponsors as $i => $sponsor)
                        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                             class=" group"
                             style="animation-delay: {{ ($i % 10) * 0.06 }}s">
                            <div class="relative bg-white border border-gray-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center
                                        hover:border-orange-400 hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-400 aspect-square">
                                @if($sponsor->logo_url)
                                    <img src="{{ Str::startsWith($sponsor->logo_url, ['http://', 'https://']) ? $sponsor->logo_url : Storage::url($sponsor->logo_url) }}" alt="{{ $sponsor->name }}"
                                         class="max-h-14 max-w-[80%] object-contain grayscale group-hover:grayscale-0 transition-all duration-500">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-50 flex items-center justify-center mb-3 group-hover:from-orange-500 group-hover:to-amber-400 transition-all duration-500">
                                        <span class="text-xl font-black text-orange-600 group-hover:text-white transition-colors duration-500">
                                            {{ strtoupper(substr($sponsor->name, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-xs font-semibold text-gray-700 mt-3 leading-tight group-hover:text-orange-600 transition-colors duration-300">
                                    {{ $sponsor->name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ====================== WHY PARTNER CTA ====================== --}}
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
                        <div class="flex items-center justify-center gap-2 mb-6">
                            <div class="h-px w-12 bg-gradient-to-r from-yellow-500 to-orange-300"></div>
                            <span class="text-amber-300 text-sm font-semibold uppercase tracking-widest">Become a Partner</span>
                            <div class="h-px w-12 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                        </div>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                            Let's Build <span class="gold-shimmer-text italic font-black">Together</span>
                        </h2>
                        <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                            Join a growing network of organizations that trust RubiKnows to deliver excellence. We're always open to meaningful partnerships.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-300 font-bold text-sm">
                                Start a Conversation
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border-2 border-white/30 text-white hover:bg-white/10 hover:border-white/50 transition-all duration-300 font-bold text-sm">
                                View Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-public-layout>
