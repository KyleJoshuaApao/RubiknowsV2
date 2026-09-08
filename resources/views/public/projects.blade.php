<x-public-layout>
    <x-slot name="title">Our Projects</x-slot>

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
                Our Portfolio
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Featured Work
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                Explore our diverse portfolio of engineering and construction milestones.
            </p>
        </div>
    </section>

    <!-- ===== PROJECTS GRID: EDGE-TO-EDGE CARDS ===== -->
    <section class="bg-gray-50 py-24 lg:py-32 border-t-8 border-brand-500">
        <div class="max-w-screen-2xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($projects as $project)
                    @php
                        // Alternate heights for visual interest
                        $isLarge = ($loop->index % 4 === 0 || $loop->index % 4 === 3);
                        $imgHeightClass = $isLarge ? 'h-[600px]' : 'h-[450px]';
                    @endphp

                    <a href="{{ route('public.project-details', $project) }}"
                       x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                       class="group block relative overflow-hidden bg-white shadow-lg hover:shadow-2xl border-b-4 border-transparent hover:border-brand-500 transition-all duration-300 {{ $imgHeightClass }}"
                       style="animation-delay: {{ ($loop->index % 2) * 0.1 }}s">
                        
                        @if($project->cover_image_path)
                            <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100 grayscale group-hover:grayscale-0">
                        @else
                            <div class="absolute inset-0 bg-richblack-900 flex items-center justify-center">
                                <span class="text-6xl font-black text-richblack-800 uppercase transform -rotate-12">Project</span>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-richblack-950 via-richblack-950/40 to-transparent opacity-90 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="absolute bottom-0 left-0 w-full p-8 lg:p-12 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <span class="px-4 py-2 bg-brand-500 text-white text-[10px] font-black tracking-widest uppercase mb-4 inline-block">
                                {{ $project->category }}
                            </span>
                            
                            <h3 class="text-3xl lg:text-4xl font-black text-white tracking-tight mb-4 group-hover:text-brand-500 transition-colors">{{ $project->title }}</h3>
                            
                            <div class="flex items-center justify-between text-sm font-black uppercase tracking-widest">
                                <span class="flex items-center text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $project->location }}
                                </span>
                                
                                <span class="text-white group-hover:text-brand-500 transition-colors inline-flex items-center">
                                    View
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-32 bg-white shadow-lg border-t-4 border-brand-500">
                        <span class="block text-gray-300 text-6xl font-black mb-6">00</span>
                        <p class="text-gray-500 uppercase tracking-widest font-black text-sm">No projects published yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $projects->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="bg-richblack-950 text-white py-32 lg:py-48 relative overflow-hidden border-t-8 border-white border-b-8">
        <div class="absolute inset-0 bg-brand-500 opacity-20 transform -skew-y-3 origin-top-left"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <span class="block font-black tracking-[0.3em] uppercase text-brand-500 mb-8">Next Steps</span>
            <h2 class="text-5xl lg:text-7xl font-black mb-8 leading-tight tracking-tighter uppercase">
                Have a project in mind?
            </h2>
            <p class="text-xl lg:text-2xl text-gray-300 max-w-2xl mx-auto leading-relaxed mb-12 font-bold">
                Let's discuss how our expertise can turn your vision into reality.
            </p>
            <div class="mt-8 inline-block">
                <x-kh-button href="{{ route('public.contact') }}" text="Discuss Your Project" />
            </div>
        </div>
    </section>
</x-public-layout>
