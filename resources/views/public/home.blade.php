<x-public-layout>
    <x-slot name="title">Home</x-slot>

    <div x-data="homeLivePreview()">
    <!-- ===== HERO SECTION ===== -->
    <section class="relative h-[85vh] min-h-[600px] flex items-center bg-gray-900 kh-angled-bottom-right mb-0">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2500&auto=format&fit=crop"
                 alt="Engineering Excellence"
                 class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-transparent"></div>
        </div>

        <div class="relative z-20 w-full max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="max-w-xl md:max-w-2xl pl-4 md:pl-8 border-l-4 border-brand-500">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="mb-6">
                    <span class="inline-flex items-center gap-3 text-white text-xs font-bold uppercase tracking-[0.2em]">
                        Established 2020 — Engineering Excellence
                    </span>
                </div>
                <h1 x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                    class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[1.05] tracking-tight mb-8"
                    style="animation-delay: 0.1s">
                    Building the Future,<br>
                    <span class="font-display italic text-brand-400">one structure at a time.</span>
                </h1>
                <p class="text-base md:text-lg text-gray-300 max-w-2xl leading-relaxed mb-10" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                    We deliver premier civil, structural engineering, and construction services. Partner with RubiKnows to bring state-of-the-art infrastructure projects to life with precision and integrity.
                </p>
                <div class="flex flex-col sm:flex-row gap-4" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.3s">
                    <x-kh-button href="{{ route('public.projects') }}" text="Explore Projects" />
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-3 bg-transparent text-white font-bold uppercase tracking-widest text-sm hover:text-brand-500 transition-colors duration-300">
                        Get a Quotation
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== [NEW] STATS BAR (By The Numbers) ===== -->
    <section class="bg-richblack-950 border-t-4 border-brand-500 py-12 relative z-30">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-800 text-center">
                <template x-for="(stat, index) in previewData.stats" :key="index">
                    <div class="px-4">
                        <div class="text-4xl md:text-5xl font-black text-brand-500 mb-2" x-text="stat.value"></div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em]" x-text="stat.label"></div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- ===== [NEW] MARKETS & SECTORS GRID ===== -->
    <section class="py-24 bg-gray-50 border-b border-gray-200">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-1 w-16 bg-brand-500"></div>
                        <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Specialized Focus</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight leading-tight">Markets We Serve</h2>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
                <template x-for="market in previewData.markets" :key="market">
                    <div class="bg-white p-8 border border-gray-100 hover:border-brand-500 group transition-colors duration-300 cursor-pointer">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-brand-500 mb-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="text-sm font-black text-richblack-900 uppercase tracking-widest group-hover:text-brand-500 transition-colors duration-300" x-text="market"></h3>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- ===== FEATURED SERVICES (Capabilities) ===== -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-1 w-16 bg-brand-500"></div>
                        <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Our Capabilities</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight leading-tight">Technical Architecture<br>& Services</h2>
                    <p class="text-gray-600 text-lg max-w-xl leading-relaxed mt-6">High-performance engineering design, analysis, and implementation across diverse sectors.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
                @forelse($services as $service)
                <div class="group flex flex-col h-full bg-gray-50 border-b-4 border-transparent hover:border-brand-500 p-10 hover:bg-white hover:shadow-xl transition-all duration-500">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="inline-flex items-center justify-center w-14 h-14 bg-richblack-950 text-brand-500 text-sm font-black">0{{ $loop->index + 1 }}</span>
                    </div>
                    <h3 class="text-xl font-black text-richblack-900 mb-4 uppercase tracking-tight group-hover:text-brand-500 transition-colors duration-300">{{ $service->title }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-8 flex-grow">{{ $service->short_description ?? Str::limit(strip_tags($service->content), 160) }}</p>
                    <a href="{{ route('public.services') }}" class="inline-flex items-center text-xs font-black text-brand-500 hover:text-richblack-900 transition-all duration-300 uppercase tracking-widest">
                        View Details
                        <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
                @empty
                <div class="col-span-full py-32 bg-gray-50 border-4 border-dashed border-gray-200 flex flex-col items-center justify-center shadow-inner">
                    <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-gray-500 text-sm uppercase tracking-[0.2em] font-black">Architecture & Services Directory Empty</p>
                    <p class="text-gray-400 text-xs mt-2 font-bold uppercase tracking-widest">Awaiting system synchronization</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== FEATURED PROJECTS ===== -->
    <section class="py-24 bg-gray-50 border-t border-gray-200">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-1 w-16 bg-brand-500"></div>
                        <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Active Portfolio</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight">Featured Projects</h2>
                </div>
                <a href="{{ route('public.projects') }}" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="hidden md:inline-flex items-center gap-2 px-6 py-3 border-2 border-richblack-900 text-xs font-black text-richblack-900 uppercase tracking-widest hover:bg-richblack-950 hover:text-white transition-all duration-300">
                    View Complete Projects
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-1">
                @forelse($featuredProjects as $project)
                <a href="{{ route('public.project-details', $project) }}"
                    x-data x-intersect.once="$el.classList.add('animate-scale-in')"
                    class="group block bg-white overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 hover:border-brand-500 transition-all duration-500"
                    style="animation-delay: {{ $loop->index * 0.12 }}s">
                    @if($project->cover_image_path)
                    <div class="relative h-80 overflow-hidden bg-richblack-950">
                        <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute top-5 left-5 z-20">
                            <span class="px-4 py-2 bg-brand-500 text-white text-xs font-black uppercase tracking-[0.2em]">{{ $project->category }}</span>
                        </div>
                    </div>
                    @else
                    <div class="h-80 bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400 text-xs uppercase tracking-[0.25em] font-black">No Image Available</span>
                    </div>
                    @endif
                    <div class="p-8 border-t-4 border-brand-500">
                        <h3 class="text-xl font-black text-richblack-900 mb-4 uppercase tracking-tight group-hover:text-brand-500 transition-colors duration-300">{{ $project->title }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-6 font-bold">
                            <svg class="w-4 h-4 mr-2.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $project->location }}
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-7">{{ $project->description }}</p>
                        <div class="flex justify-between items-center pt-5 border-t border-gray-200 text-xs font-black uppercase tracking-widest">
                            <span class="text-brand-500">
                                {{ $project->status === 'Featured' ? 'Completed' : strtoupper($project->status) }}
                            </span>
                            <span class="text-richblack-900 group-hover:translate-x-2 transition-all duration-300 inline-flex items-center">
                                Details
                                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-32 bg-white border-4 border-dashed border-gray-200 flex flex-col items-center justify-center shadow-inner">
                    <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-gray-500 text-sm uppercase tracking-[0.2em] font-black">Active Portfolio Empty</p>
                    <p class="text-gray-400 text-xs mt-2 font-bold uppercase tracking-widest">Awaiting project deployment</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('public.projects') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-richblack-950 text-white font-black uppercase tracking-widest text-sm hover:bg-brand-500 transition-all duration-300">
                    View Complete Portfolio
                </a>
            </div>
        </div>
    </section>

    <!-- ===== [NEW] CLIENT/PARTNER MARQUEE ===== -->
    <section class="py-12 bg-white border-b border-gray-200 overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-8">Trusted by industry leaders and municipalities</p>
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 opacity-40 grayscale">
                <template x-for="marquee in previewData.marquee" :key="marquee">
                    <div class="text-xl font-black tracking-tight text-richblack-900" x-text="marquee"></div>
                </template>
            </div>
        </div>
    </section>

    <!-- ===== PROCESS SECTION ===== -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-1 w-16 bg-brand-500"></div>
                    <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Our Engineering Process</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight">How We Work</h2>
                <p class="text-gray-600 text-lg max-w-xl leading-relaxed mt-6">A systematic approach to delivering excellence on every project.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1">
                @php
                $steps = [
                ['num' => '01', 'title' => 'Consultation', 'desc' => 'Initial project assessment, feasibility studies, and requirement analysis with stakeholders.'],
                ['num' => '02', 'title' => 'Design', 'desc' => 'Structural modeling, civil planning, and detailed engineering drawings using advanced software.'],
                ['num' => '03', 'title' => 'Execution', 'desc' => 'On-site construction management with strict adherence to safety and quality standards.'],
                ['num' => '04', 'title' => 'Delivery', 'desc' => 'Final inspection, documentation handover, and post-project support and maintenance.'],
                ];
                @endphp
                @foreach($steps as $step)
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="relative p-10 bg-gray-50 border-l-4 border-brand-500 hover:bg-richblack-950 hover:text-white group transition-all duration-500" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="w-16 h-16 bg-richblack-950 group-hover:bg-brand-500 text-brand-500 group-hover:text-white flex items-center justify-center font-black text-xl mb-6 transition-colors duration-500">{{ $step['num'] }}</div>
                    <h3 class="text-xl font-black text-richblack-900 group-hover:text-white mb-4 uppercase tracking-tight transition-colors duration-500">{{ $step['title'] }}</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 text-base leading-relaxed transition-colors duration-500">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="py-24 bg-gray-50 relative overflow-hidden border-t border-gray-200">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="mb-16">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-1 w-16 bg-brand-500"></div>
                    <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Client Feedback</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight">Testimonials</h2>
                <p class="text-gray-600 text-lg max-w-xl leading-relaxed mt-6">Transparent validation from our clients and partners.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
                @forelse($testimonials as $testimonial)
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                    class="group p-10 bg-white border-t-4 border-brand-500 hover:shadow-xl transition-all duration-500"
                    style="{{ 'animation-delay: ' . ($loop->index * 0.1) . 's;' }}">
                    <svg class="w-10 h-10 text-brand-500/20 mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    <p class="text-gray-700 italic text-base leading-relaxed mb-8">"{{ $testimonial->quote }}"</p>
                    <div class="flex items-center pt-6 border-t border-gray-200">
                        @if($testimonial->avatar_path)
                        <img class="h-14 w-14 object-cover mr-4 border-2 border-brand-500" src="{{ Storage::url($testimonial->avatar_path) }}" alt="{{ $testimonial->client_name }}">
                        @else
                        <div class="h-14 w-14 bg-richblack-950 text-brand-500 flex items-center justify-center font-black text-xl mr-4">
                            {{ substr($testimonial->client_name, 0, 1) }}
                        </div>
                        @endif
                        <div>
                            <h4 class="text-base font-black text-richblack-900 uppercase tracking-tight group-hover:text-brand-500 transition-colors duration-300">{{ $testimonial->client_name }}</h4>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $testimonial->role }} @if($testimonial->company) • {{ $testimonial->company }} @endif</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400 text-sm uppercase tracking-widest font-black">No feedback available.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('public.testimonials') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-richblack-950 text-white font-black uppercase tracking-widest text-sm hover:bg-brand-500 transition-all duration-300 border-2 border-richblack-950 hover:border-brand-500">
                    View All Testimonials
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== [NEW] CORPORATE NEWS & INSIGHTS ===== -->
    <section class="py-24 bg-white border-t border-gray-200">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-1 w-16 bg-brand-500"></div>
                        <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Thought Leadership</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-charcoal-700 tracking-tight">News & Insights</h2>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-2 px-6 py-3 border-2 border-richblack-900 text-xs font-black text-richblack-900 uppercase tracking-widest hover:bg-richblack-950 hover:text-white transition-all duration-300">
                    View All Insights
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Insight Card 1 -->
                <article class="group cursor-pointer">
                    <div class="relative h-60 overflow-hidden bg-gray-200 mb-6">
                        <div class="absolute inset-0 bg-richblack-950/20 group-hover:bg-transparent transition-colors z-10"></div>
                        <img src="https://images.unsplash.com/photo-1541888086925-0c13d4b68e96?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 z-20">
                            <span class="px-3 py-1 bg-brand-500 text-white text-[10px] font-black uppercase tracking-widest">Press Release</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-3">September 12, 2026</p>
                    <h3 class="text-xl font-black text-richblack-900 leading-snug mb-3 group-hover:text-brand-500 transition-colors">RubiKnows awarded massive contract for Regional Municipal Water Expansion</h3>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4">Our water infrastructure division has been selected to lead the design and implementation of the new high-capacity treatment facility.</p>
                    <span class="inline-flex items-center text-xs font-black text-brand-500 uppercase tracking-widest">
                        Read More
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </article>

                <!-- Insight Card 2 -->
                <article class="group cursor-pointer">
                    <div class="relative h-60 overflow-hidden bg-gray-200 mb-6">
                        <div class="absolute inset-0 bg-richblack-950/20 group-hover:bg-transparent transition-colors z-10"></div>
                        <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 z-20">
                            <span class="px-3 py-1 bg-brand-500 text-white text-[10px] font-black uppercase tracking-widest">Whitepaper</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-3">August 28, 2026</p>
                    <h3 class="text-xl font-black text-richblack-900 leading-snug mb-3 group-hover:text-brand-500 transition-colors">Sustainable Concrete Methodologies and Stress Testing in 2026</h3>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4">A deep dive into the latest structural integrity tests for low-carbon composite concrete used in high-rise developments.</p>
                    <span class="inline-flex items-center text-xs font-black text-brand-500 uppercase tracking-widest">
                        Read More
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </article>

                <!-- Insight Card 3 -->
                <article class="group cursor-pointer">
                    <div class="relative h-60 overflow-hidden bg-gray-200 mb-6">
                        <div class="absolute inset-0 bg-richblack-950/20 group-hover:bg-transparent transition-colors z-10"></div>
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 z-20">
                            <span class="px-3 py-1 bg-brand-500 text-white text-[10px] font-black uppercase tracking-widest">Culture</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-3">August 15, 2026</p>
                    <h3 class="text-xl font-black text-richblack-900 leading-snug mb-3 group-hover:text-brand-500 transition-colors">RubiKnows Named Top Workplace for Structural Engineers</h3>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4">Our commitment to continuous education, safety, and diversity has earned us a spot on the ENR Top Workplace list.</p>
                    <span class="inline-flex items-center text-xs font-black text-brand-500 uppercase tracking-widest">
                        Read More
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </article>
            </div>
        </div>
    </section>

    <!-- ===== [NEW] CAREERS / FOOTPRINT SPLIT BLOCK ===== -->
    <section class="bg-gray-100 border-t border-b border-gray-200 flex flex-col lg:flex-row">
        <!-- Careers Side -->
        <div class="w-full lg:w-1/2 p-12 lg:p-24 lg:pr-16 bg-white">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-1 w-16 bg-brand-500"></div>
                <span class="text-brand-500 text-xs font-black uppercase tracking-[0.3em]">Join Our Team</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-richblack-900 tracking-tight mb-8" x-text="previewData.careers.title"></h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-10" x-text="previewData.careers.description"></p>
            <a href="#" class="inline-flex items-center gap-3 px-8 py-4 bg-brand-500 text-white font-black uppercase tracking-widest text-sm hover:bg-richblack-950 transition-all duration-300">
                View Open Positions
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        <!-- Footprint Side -->
        <div class="w-full lg:w-1/2 p-12 lg:p-24 lg:pl-16 bg-richblack-950 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-1 w-16 bg-brand-500"></div>
                    <span class="text-brand-400 text-xs font-black uppercase tracking-[0.3em]">Our Footprint</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-12">Global Reach, Local Impact.</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-brand-500 font-bold uppercase tracking-widest text-xs mb-3">Headquarters</h4>
                        <p class="text-gray-300 font-medium">100 Engineering Plaza<br>Suite 400<br>Metropolis, NY 10001</p>
                    </div>
                    <div>
                        <h4 class="text-brand-500 font-bold uppercase tracking-widest text-xs mb-3">Regional Offices</h4>
                        <ul class="text-gray-300 font-medium space-y-2">
                            <li>• West Coast Division (CA)</li>
                            <li>• Southern Hub (TX)</li>
                            <li>• Midwest Operations (IL)</li>
                            <li>• European Branch (UK)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="relative bg-richblack-950 py-24 lg:py-32 overflow-hidden">
        <!-- Geometric accent -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-500/10 kh-angled-deco-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-white/5 kh-angled-deco-left"></div>

        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                    <div class="flex items-center justify-center gap-3 mb-8">
                        <div class="h-1 w-16 bg-brand-500"></div>
                        <span class="text-brand-400 text-xs font-black uppercase tracking-[0.3em]">Next Project</span>
                        <div class="h-1 w-16 bg-brand-500"></div>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter uppercase mb-8 leading-tight">
                        Ready to start your<br><span class="text-brand-500">next build?</span>
                    </h2>
                    <p class="text-gray-400 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-12 font-medium">
                        Consult with our engineers or obtain a detailed projection. Let's engineer your vision with precision.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <x-kh-button href="{{ route('public.contact') }}" text="Contact Our Engineers" />
                        <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-10 py-3 bg-transparent text-white font-bold uppercase tracking-widest text-sm hover:text-brand-500 transition-colors duration-300">
                            View Our Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div> <!-- End x-data -->

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('homeLivePreview', () => ({
                previewData: {
                    stats: @json($homeStats ?? []),
                    markets: @json($homeMarkets ?? []),
                    marquee: @json($homeMarquee ?? []),
                    careers: @json($homeCareers ?? ['title' => 'Build your career with the industry leaders.', 'description' => 'We are actively recruiting...'])
                },
                init() {
                    // Listen for postMessage from Admin CMS Live Editor
                    window.addEventListener('message', (event) => {
                        // In production, verify event.origin if necessary
                        if (event.data && event.data.type === 'live-editor-update') {
                            // Update Alpine state instantly
                            this.previewData = event.data.data;
                        }
                    });
                }
            }))
        })
    </script>
    @endpush

</x-public-layout>