<x-public-layout>
    <x-slot name="title">Gallery</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-24 pb-16 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    Media Repository
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                Project <span class="gold-shimmer-text italic font-black">Gallery</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                A visual journey through our worksites, progress, and achievements.
            </p>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="py-20 lg:py-44 bg-white" x-data="{ modalOpen: false, currentImage: '', currentTitle: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-7">
                @forelse($media as $item)
                    @php($imageUrl = asset($item->url))
                    <div x-data x-intersect.once="$el.classList.add('animate-scale-in')"
                         class="opacity-0-initial group relative aspect-square bg-white border border-gray-100 rounded-[1.5rem] overflow-hidden cursor-pointer hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-700"
                         @click="modalOpen = true; currentImage = '{{ $imageUrl }}'; currentTitle = '{{ addslashes($item->title) }}'"
                         style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 ease-out group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                            <span class="text-white font-bold text-base truncate">{{ $item->title }}</span>
                            <span class="text-orange-300 text-[10px] font-mono font-bold uppercase tracking-wider mt-1">{{ $item->category }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 font-mono text-sm">Gallery empty. Images will be added soon.</p>
                    </div>
                @endforelse
            </div>

            @if($media->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $media->links() }}
                </div>
            @endif
        </div>

        <!-- Lightbox Modal -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/95 transition-opacity"
                     @click="modalOpen = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl w-full border border-white/10 rounded-[1.5rem]">
                    <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                        <button @click="modalOpen = false" type="button" class="bg-white/10 rounded-full p-2 text-white hover:text-orange-400 hover:bg-orange-500/10 transition-all focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="bg-slate-900 relative">
                        <img :src="currentImage" :alt="currentTitle" class="w-full h-auto max-h-[85vh] object-contain mx-auto">
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-900 to-transparent p-6">
                            <h3 class="text-white text-xl font-bold" x-text="currentTitle"></h3>
                        </div>
                    </div>
                </div>
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
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Like What You See?</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Let's Create Your <span class="gold-shimmer-text italic font-black">Next Masterpiece</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Inspired by our gallery? Let's work together to bring your vision to life.
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
