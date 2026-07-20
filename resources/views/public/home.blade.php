<x-public-layout>
    <x-slot name="title">Home</x-slot>

    <!-- Hero Section -->
    <div class="relative bg-white pt-24 pb-16 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-8">
                    <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                        <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                        Established 2020 — Engineering Excellence
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                    <span class="text-gray-900">BUILDING THE FUTURE,</span><br>
                    <span class="gold-shimmer-text italic font-black">one structure at a time.</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 max-w-2xl leading-relaxed mb-10" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                    We deliver premier civil, structural engineering, and construction services. Partner with RubiKnows to bring state-of-the-art infrastructure projects to life with precision and integrity.
                </p>
                <div class="flex flex-col sm:flex-row gap-4" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.3s">
                    <a href="{{ route('public.projects') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-orange-600 to-amber-500 text-white font-bold rounded-full shadow-xl shadow-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1.5 transition-all duration-500 text-sm">
                        Explore Projects
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-gray-900 font-bold rounded-full border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 hover:-translate-y-1.5 transition-all duration-500 text-sm">
                        Get a Quotation
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services -->
    <div class="py-20 lg:py-44 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-20">
                <div class="flex items-center gap-3 mb-7">
                    <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Our Capabilities</span>
                </div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">Technical Architecture<br>& Services</h2>
                <p class="text-gray-600 text-base max-w-xl leading-relaxed">High-performance engineering design, analysis, and implementation across diverse sectors.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($services as $service)
                    <div class="group flex flex-col h-full border border-gray-100 rounded-[2rem] bg-white p-8 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-b from-orange-500 to-amber-500 text-white text-sm font-bold rounded-[1.25rem] shadow-xl shadow-orange-500/30">0{{ $loop->index + 1 }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors duration-300">{{ $service->title }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-7 flex-grow">{{ $service->short_description ?? Str::limit(strip_tags($service->content), 160) }}</p>
                        <a href="{{ route('public.services') }}" class="inline-flex items-center text-xs font-bold text-orange-600 hover:text-orange-700 transition-all duration-300">
                            View Details
                            <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">No services available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="py-20 lg:py-44 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-[32rem] h-[32rem] bg-orange-100/20 rounded-full blur-[200px] pointer-events-none -translate-y-1/2 -translate-x-1/2"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-20 gap-7">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                        <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Active Portfolio</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">Featured Projects</h2>
                </div>
                <a href="{{ route('public.projects') }}" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial hidden md:inline-flex items-center gap-2 px-5 py-2.5 border-2 border-orange-200 rounded-full text-xs font-bold text-orange-600 bg-white hover:border-orange-500 hover:bg-orange-50 transition-all duration-300">
                    View Complete Projects
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
                @forelse($featuredProjects as $project)
                    <a href="{{ route('public.project-details', $project) }}"
                       x-data x-intersect.once="$el.classList.add('animate-scale-in')"
                       class="opacity-0-initial group block bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-2xl hover:shadow-orange-500/10 border border-gray-100 hover:border-orange-200 transition-all duration-700"
                       style="animation-delay: {{ $loop->index * 0.12 }}s">
                        @if($project->cover_image_path)
                            <div class="relative h-80 overflow-hidden bg-orange-50">
                                <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 ease-out group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-5 left-5 z-20">
                                    <span class="px-4 py-2 bg-white border border-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase tracking-[0.2em] shadow-md">{{ $project->category }}</span>
                                </div>
                            </div>
                        @else
                            <div class="h-80 bg-orange-50 flex items-center justify-center">
                                <span class="text-orange-300 font-mono text-xs uppercase tracking-[0.25em]">No Image Available</span>
                            </div>
                        @endif
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">{{ $project->title }}</h3>
                            <div class="flex items-center text-sm text-gray-500 mb-6">
                                <svg class="w-4 h-4 mr-2.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $project->location }}
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-7">{{ $project->description }}</p>
                            <div class="flex justify-between items-center pt-5 border-t border-gray-100 text-xs font-bold">
                                <span class="text-orange-600 uppercase tracking-[0.2em]">
                                    {{ $project->status === 'Featured' ? 'Completed' : strtoupper($project->status) }}
                                </span>
                                <span class="text-gray-900 group-hover:translate-x-1.5 transition-all duration-300 inline-flex items-center">
                                    Details
                                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">No featured projects available.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('public.projects') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-white border-2 border-orange-500 text-orange-600 font-bold rounded-full hover:bg-orange-500 hover:text-white transition-all duration-300 text-sm">
                    View Complete Portfolio
                </a>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="py-20 lg:py-44 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-20">
                <div class="flex items-center gap-3 mb-7">
                    <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Our Engineering Process</span>
                </div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">How We Work</h2>
                <p class="text-gray-600 text-lg max-w-xl leading-relaxed mb-3">A systematic approach to delivering excellence on every project.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-12 md:gap-y-7 gap-x-7 pt-6 md:pt-0">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Consultation', 'desc' => 'Initial project assessment, feasibility studies, and requirement analysis with stakeholders.'],
                        ['num' => '02', 'title' => 'Design', 'desc' => 'Structural modeling, civil planning, and detailed engineering drawings using advanced software.'],
                        ['num' => '03', 'title' => 'Execution', 'desc' => 'On-site construction management with strict adherence to safety and quality standards.'],
                        ['num' => '04', 'title' => 'Delivery', 'desc' => 'Final inspection, documentation handover, and post-project support and maintenance.'],
                    ];
                @endphp
                @foreach($steps as $step)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial relative p-8 bg-white rounded-[2rem] border border-gray-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="absolute -top-5 left-4 md:-left-5 w-12 h-12 bg-orange-500 rounded-[1.25rem] flex items-center justify-center text-white font-black text-base shadow-xl shadow-orange-500/30">{{ $step['num'] }}</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 mt-1">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 text-base leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="py-20 lg:py-44 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-20">
                <div class="flex items-center gap-3 mb-7">
                    <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Client Feedback</span>
                </div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">Testimonials</h2>
                <p class="text-gray-600 text-lg max-w-xl leading-relaxed mb-3">Transparent validation from our clients and partners.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($testimonials as $testimonial)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                         class="opacity-0-initial group p-8 bg-white rounded-[2rem] border border-gray-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700"
                         style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <p class="text-gray-700 italic text-sm leading-relaxed mb-7">"{{ $testimonial->quote }}"</p>
                        <div class="flex items-center pt-5 border-t border-gray-100">
                            @if($testimonial->avatar_path)
                                <img class="h-14 w-14 rounded-full object-cover mr-4 ring-2 ring-orange-100" src="{{ Storage::url($testimonial->avatar_path) }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <div class="h-14 w-14 rounded-full bg-orange-500 text-white flex items-center justify-center font-black text-xl mr-4 shadow-xl shadow-orange-500/30">
                                    {{ substr($testimonial->client_name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">{{ $testimonial->client_name }}</h4>
                                <p class="text-xs text-gray-500">{{ $testimonial->role }} @if($testimonial->company) • {{ $testimonial->company }} @endif</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">No feedback available.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('public.testimonials') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-white border-2 border-orange-500 text-orange-600 font-bold rounded-full hover:bg-orange-500 hover:text-white hover:shadow-xl hover:shadow-orange-500/30 transition-all duration-300 text-sm">
                    View All Testimonials
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
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
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="h-px w-20 bg-gradient-to-r from-yellow-500 to-orange-300"></div>
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Next Project</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Ready to start your<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-300 to-orange-500">next build?</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Consult with our engineers or obtain a detailed projection. Let's engineer your vision with precision.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-500 font-bold text-sm">
                        Contact Our Engineers
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border-2 border-white/30 text-white hover:bg-white/10 hover:border-white/50 transition-all duration-500 font-bold text-sm">
                        View Our Services
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-public-layout>