<x-public-layout>
    <x-slot name="title">Portfolio</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-24 pb-16 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class=" mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    Build Specification
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                Project <span class="gold-shimmer-text italic font-black">Portfolio</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Explore our track record of successful engineering and construction projects.
            </p>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="py-20 lg:py-44 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($projects as $project)
                    <a href="{{ route('public.project-details', $project) }}"
                       x-data x-intersect.once="$el.classList.add('animate-scale-in')"
                       class=" group block bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700"
                       style="animation-delay: {{ $loop->index * 0.08 }}s">
                        @if($project->cover_image_path)
                            <div class="relative h-80 overflow-hidden bg-orange-50">
                                <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 ease-out group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-5 left-5 z-20">
                                    <span class="px-4 py-2 bg-white border border-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase tracking-wider shadow-md">{{ $project->category }}</span>
                                </div>
                            </div>
                        @else
                            <div class="h-80 bg-orange-50 flex items-center justify-center border-b border-gray-100">
                                <span class="px-4 py-2 bg-white border border-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase tracking-wider shadow-md">{{ $project->category }}</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors duration-300">{{ $project->title }}</h3>
                            <div class="flex items-center text-sm text-gray-500 mb-6">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $project->location }}
                            </div>

                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-7">{{ $project->description }}</p>

                            <div class="flex justify-between items-center pt-6 border-t border-gray-100 text-xs font-bold">
                                <span class="text-orange-600 uppercase tracking-wider">
                                    {{ $project->status === 'Featured' ? 'Completed' : strtoupper($project->status) }}
                                </span>
                                <span class="text-gray-900 group-hover:translate-x-1.5 transition-transform duration-300 inline-flex items-center">
                                    Details
                                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">No projects found.</p>
                    </div>
                @endforelse
            </div>

            @if($projects->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
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
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Your Next Project</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Ready to Start Your <span class="gold-shimmer-text italic font-black">Project?</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Let's work together to bring your vision to life with our engineering excellence.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-500 font-bold text-sm">
                        Contact Us Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-public-layout>
