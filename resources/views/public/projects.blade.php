<x-public-layout>
    <x-slot name="title">Our Projects</x-slot>

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
                Our Portfolio
            </p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-none tracking-tight max-w-3xl">
                Featured Work
            </h1>
            <p class="mt-4 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-medium">
                Explore our diverse portfolio of engineering and construction milestones.
            </p>
        </div>
    </section>

    <!-- ===== PROJECTS GRID: EDGE-TO-EDGE CARDS ===== -->
    <section class="bg-gray-50 py-8 lg:py-12 border-t-2 border-brand-500">
        <div class="max-w-screen-2xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($projects as $project)
                    @php
                        // Alternate heights for visual interest
                        $isLarge = ($loop->index % 4 === 0 || $loop->index % 4 === 3);
                        $imgHeightClass = $isLarge ? 'h-[500px]' : 'h-[400px]';
                    @endphp

                    <a href="{{ route('public.project-details', $project) }}"
                       x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                       class="group block relative overflow-hidden bg-white shadow-lg hover:shadow-xl border-b-4 border-transparent hover:border-brand-500 transition-all duration-200 {{ $imgHeightClass }}"
                       style="animation-delay: {{ ($loop->index % 2) * 0.05 }}s">

                        @if($project->cover_image_path)
                            <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out opacity-90 group-hover:opacity-100 grayscale group-hover:grayscale-0">
                        @else
                            <div class="absolute inset-0 bg-richblack-900 flex items-center justify-center">
                                <span class="text-5xl font-bold text-richblack-800 uppercase transform -rotate-12">Project</span>
                            </div>
                        @endif

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-richblack-950 via-richblack-950/40 to-transparent opacity-90 group-hover:opacity-100 transition-opacity"></div>

                        <div class="absolute bottom-0 left-0 w-full p-6 lg:p-8 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-200">
                            <span class="px-3 py-1.5 bg-brand-500 text-white text-[9px] font-bold tracking-widest uppercase mb-3 inline-block">
                                {{ $project->category }}
                            </span>

                            <h3 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mb-3 group-hover:text-brand-500 transition-colors">{{ $project->title }}</h3>

                            <div class="flex items-center justify-between text-sm font-bold uppercase tracking-widest">
                                <span class="flex items-center text-gray-300">
                                    <svg class="w-3 h-3 mr-1.5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $project->location }}
                                </span>

                                <span class="text-white group-hover:text-brand-500 transition-colors inline-flex items-center">
                                    View
                                    <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 bg-white shadow-lg border-t-4 border-brand-500">
                        <span class="block text-gray-300 text-5xl font-bold mb-4">00</span>
                        <p class="text-gray-500 uppercase tracking-widest font-medium text-sm">No projects published yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $projects->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="bg-richblack-950 text-white py-8 lg:py-12 relative overflow-hidden border-t-2 border-white border-b-2">
        <div class="absolute inset-0 bg-brand-500 opacity-15 transform -skew-y-2 origin-top-left"></div>
        <div class="max-w-3xl mx-auto px-6 relative z-10 text-center">
            <span class="block font-bold tracking-[0.2em] uppercase text-brand-500 mb-4">Next Steps</span>
            <h2 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight tracking-tight uppercase">
                Have a project in mind?
            </h2>
            <p class="text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed mb-6 font-medium">
                Let's discuss how our expertise can turn your vision into reality.
            </p>
            <div class="mt-4 inline-block">
                <x-kh-button href="{{ route('public.contact') }}" text="Discuss Your Project" />
            </div>
        </div>
    </section>
</x-public-layout>