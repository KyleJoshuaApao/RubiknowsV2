<x-public-layout>
    <x-slot name="title">Testimonials</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.04] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    Client Stories
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black text-black tracking-tight mt-6 mb-6" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.1s">
                What Our <span class="gold-shimmer-text italic">Clients Say</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Hear from the people we've had the pleasure of working with.
            </p>
        </div>
    </div>

    <!-- Testimonials Grid -->
    <div class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                     class="opacity-0-initial group p-6 lg:p-8 bg-white rounded-3xl border border-gray-100 hover:border-orange-500 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-500"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="flex items-center gap-1 mb-6">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921,1.603-.921,1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0,1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <p class="text-gray-700 italic text-sm leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center pt-6 border-t border-gray-100">
                        @if($testimonial->avatar_path)
                        <img class="h-14 w-14 rounded-full object-cover mr-5 ring-4 ring-orange-100" src="{{ Storage::url($testimonial->avatar_path) }}" alt="{{ $testimonial->name }}">
                        @else
                        <div class="h-14 w-14 rounded-full bg-orange-500 text-white flex items-center justify-center font-black text-xl mr-5 shadow-lg shadow-orange-500/30">
                            {{ substr($testimonial->name, 0, 1) }}
                        </div>
                        @endif
                        <div>
                            <h4 class="text-base font-bold text-black group-hover:text-orange-600 transition-colors duration-300">{{ $testimonial->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $testimonial->role }} @if($testimonial->company) &bull; {{ $testimonial->company }} @endif</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400 font-mono text-sm">No testimonials available yet. Check back soon!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black py-20 lg:py-28 overflow-hidden border-t border-slate-700">
        <div class="absolute inset-0 bg-grid-pattern-dark opacity-[0.1] pointer-events-none"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial">
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class="h-px w-12 bg-gradient-to-r from-yellow-500 to-orange-300"></div>
                    <span class="text-amber-300 text-sm font-semibold uppercase tracking-widest">Ready to Share Your Story?</span>
                    <div class="h-px w-12 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Let's Work <span class="gold-shimmer-text italic font-black">Together</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Ready to start your next project? Get in touch with us today!
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-300 font-bold text-sm">
                        Contact Us
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border-2 border-white/30 text-white hover:bg-white/10 hover:border-white/50 transition-all duration-300 font-bold text-sm">
                        View Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
