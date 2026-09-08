<x-public-layout>
    <x-slot name="title">Clients & Partners</x-slot>

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
                Our Network
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Clients & Partners
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                We are proud to collaborate with leading organizations to deliver exceptional engineering solutions.
            </p>
        </div>
    </section>

    <!-- ===== LOGOS GRID ===== -->
    <section class="py-24 lg:py-32 bg-gray-50">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 lg:gap-8">
                @forelse($clients as $client)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                         class="flex flex-col items-center justify-center p-10 bg-white border-t-4 border-transparent hover:border-brand-500 hover:shadow-xl transition-all duration-300 group h-48 relative overflow-hidden"
                         style="animation-delay: {{ $loop->index * 0.05 }}s">
                        
                        <!-- Accent Line on Hover -->
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-brand-500 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>

                        @if($client->logo_path)
                            <img src="{{ Storage::url($client->logo_path) }}" 
                                 alt="{{ $client->name }}" 
                                 class="max-w-full max-h-20 object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 transform group-hover:scale-105">
                        @else
                            <span class="text-xl font-black text-gray-400 group-hover:text-richblack-900 uppercase tracking-widest text-center transition-colors">{{ $client->name }}</span>
                        @endif
                        
                    </div>
                @empty
                    <div class="col-span-full text-center py-24 bg-white border-4 border-gray-100">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-bold uppercase tracking-wider">No clients or partners have been added yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($clients->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $clients->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </section>
</x-public-layout>
