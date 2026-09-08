<x-public-layout>
    <x-slot name="title">Testimonials</x-slot>

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
                Client Feedback
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                What Our Clients Say
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                Hear from the organizations and individuals who have trusted RubiKnows with their engineering and construction projects.
            </p>
        </div>
    </section>

    <!-- ===== TESTIMONIALS GRID ===== -->
    <section class="py-24 lg:py-32 bg-gray-50">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @forelse($testimonials as $testimonial)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                         class="bg-white p-10 border-t-4 border-brand-500 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col h-full"
                         style="animation-delay: {{ $loop->index * 0.08 }}s">
                        
                        <div class="mb-8 text-brand-500 opacity-20">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151C7.563 6.068 6 8.789 6 11h4v10H0z"/></svg>
                        </div>
                        
                        <div class="flex-grow">
                            <p class="text-gray-900 leading-relaxed text-lg font-medium mb-10 italic">"{{ $testimonial->quote }}"</p>
                        </div>
                        
                        <div class="flex items-center pt-8 border-t-2 border-gray-100 mt-auto">
                            @if($testimonial->avatar_path)
                                <img class="h-16 w-16 object-cover mr-6 border-b-4 border-brand-500" src="{{ Storage::url($testimonial->avatar_path) }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <div class="h-16 w-16 bg-gray-100 text-brand-500 border-b-4 border-brand-500 flex items-center justify-center font-black text-2xl mr-6 uppercase">
                                    {{ substr($testimonial->client_name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-base font-black text-richblack-900 uppercase tracking-widest">{{ $testimonial->client_name }}</h4>
                                <p class="text-sm text-gray-500 mt-1 font-bold">
                                    {{ $testimonial->role }} 
                                    @if($testimonial->company)
                                        <span class="text-brand-500 font-medium px-2">|</span> {{ $testimonial->company }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-24 bg-white border-4 border-gray-100">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-bold uppercase tracking-wider">No testimonials have been added yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($testimonials->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $testimonials->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </section>
</x-public-layout>
