<x-public-layout>
    <x-slot name="title">Gallery</x-slot>

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
                Visual Showcase
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Our Gallery
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                A visual journey through our construction process and completed engineering marvels.
            </p>
        </div>
    </section>

    <!-- ===== GALLERY MASONRY ===== -->
    <section class="py-24 lg:py-32 bg-white min-h-[500px]">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12" x-data="{ selectedImage: null }">

            <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8">
                @forelse($media as $image)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                         class="break-inside-avoid group cursor-zoom-in relative overflow-hidden bg-gray-100 border-b-4 border-transparent hover:border-brand-500 transition-all duration-300 shadow-sm hover:shadow-xl"
                         style="animation-delay: {{ ($loop->index % 10) * 0.05 }}s"
                         @click="selectedImage = '{{ Storage::url($image->image_path) }}'">
                        
                        <img src="{{ Storage::url($image->image_path) }}" 
                             alt="{{ $image->caption ?? 'Gallery Image' }}"
                             class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700 ease-out filter grayscale-0 group-hover:grayscale-[20%]"
                             loading="lazy">
                        
                        @if($image->caption)
                            <div class="absolute inset-0 bg-richblack-950/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-8 border-t-4 border-brand-500 transform translate-y-4 group-hover:translate-y-0">
                                <p class="text-white text-xl font-black uppercase tracking-widest mb-2">{{ $image->caption }}</p>
                                @if($image->category)
                                    <p class="text-brand-500 text-sm font-bold uppercase tracking-widest">{{ $image->category }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-24 bg-gray-50 border-4 border-gray-100 break-inside-avoid w-full">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-bold uppercase tracking-wider">No images have been added to the gallery yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($media->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $media->links('vendor.pagination.tailwind') }}
                </div>
            @endif

            <!-- Lightbox Modal -->
            <div x-show="selectedImage" 
                 style="display: none;"
                 class="fixed inset-0 z-[100] flex items-center justify-center bg-richblack-950/95 backdrop-blur-md p-4 sm:p-8"
                 @click.self="selectedImage = null"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <button @click="selectedImage = null" class="absolute top-8 right-8 text-white/50 hover:text-brand-500 bg-richblack-900 border-2 border-white/20 hover:border-brand-500 p-3 transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-16 h-16 border-t-8 border-l-8 border-brand-500 z-10 pointer-events-none"></div>
                    <img :src="selectedImage" class="max-w-full max-h-[85vh] object-contain border-4 border-richblack-800 shadow-2xl" @click.stop>
                    <div class="absolute -bottom-4 -right-4 w-16 h-16 border-b-8 border-r-8 border-brand-500 z-10 pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
