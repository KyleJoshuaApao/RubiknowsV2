<x-public-layout>
    <x-slot name="title">About Us</x-slot>

    @php
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    @endphp

    <!-- Header -->
    <div class="relative bg-white pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    Who We Are
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                About <span class="gold-shimmer-text italic font-black">RubiKnows</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Pioneering excellence in engineering and construction since 2020.
            </p>
        </div>
    </div>

    <!-- Company Profile -->
    <div class="py-32 lg:py-44 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-left')" class="opacity-0-initial">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                        <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Our Story</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-6">Building Trust,<br>Delivering Excellence</h2>
                    <div class="rich-text text-gray-600 leading-relaxed text-base space-y-4">
                        {!! $settings['about_story_content'] ?? "<p>Founded with a vision to redefine structural integrity and innovative design, RubiKnows has grown into a premier engineering and construction firm. We specialize in delivering comprehensive solutions from initial consultancy to final build.</p><p class='mt-4'>Our team of dedicated engineers, architects, and project managers work synergistically to ensure that every project we undertake not only meets but exceeds industry standards. We pride ourselves on safety, sustainability, and unparalleled craftsmanship.</p>" !!}
                    </div>

                    <div class="mt-12 grid grid-cols-2 gap-8">
                        <div class="border-l-2 border-orange-500 pl-6">
                            <p class="text-3xl lg:text-4xl font-sans font-black text-gray-900">
                                <span x-data="{ count: 0, target: {{ !empty($settings['about_projects_count']) ? (int)$settings['about_projects_count'] : 100 }} }" x-init="let interval = setInterval(() => { if (count < target) { count += Math.ceil(target/50); if (count > target) count = target; } else { clearInterval(interval); } }, 30)" x-text="count">0</span>+
                            </p>
                            <p class="text-[11px] font-bold text-gray-500 font-mono uppercase tracking-wider mt-2">Projects Completed</p>
                        </div>
                        <div class="border-l-2 border-orange-500 pl-6">
                            <p class="text-3xl lg:text-4xl font-sans font-black text-gray-900">
                                <span x-data="{ count: 0, target: {{ !empty($settings['about_experience_years']) ? (int)$settings['about_experience_years'] : 5 }} }" x-init="let interval = setInterval(() => { if (count < target) { count++ } else { clearInterval(interval); } }, 150)" x-text="count">0</span>+
                            </p>
                            <p class="text-[11px] font-bold text-gray-500 font-mono uppercase tracking-wider mt-2">Years Experience</p>
                        </div>
                    </div>
                </div>
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-right')" class="opacity-0-initial">
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 rounded-[2rem] p-10 lg:p-14 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-orange-100/30 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 right-0 w-32 h-32 bg-amber-100/30 rounded-full blur-2xl"></div>

                        <div class="text-center relative z-10">
                            <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-white text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100 mb-10">
                                Our Motto
                            </span>
                            <div class="relative mt-10">
                                <span class="absolute -top-8 left-2 text-7xl font-sans text-orange-200 leading-none select-none">&ldquo;</span>
                                <blockquote class="relative z-10 text-xl md:text-2xl lg:text-3xl font-sans font-bold text-gray-900 leading-snug tracking-tight">
                                    <span class="gold-shimmer-text italic font-black">With God,</span> All things are possible.
                                </blockquote>
                                <span class="absolute -bottom-10 right-2 text-7xl font-sans text-orange-200 leading-none select-none">&rdquo;</span>
                            </div>
                            <div class="flex items-center justify-center gap-4 mt-14">
                                <div class="h-px w-12 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                                <cite class="not-italic text-[11px] font-bold text-gray-700 font-mono uppercase tracking-[0.2em]">Matthew 19:26</cite>
                                <div class="h-px w-12 bg-gradient-to-l from-orange-500 to-amber-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="py-32 lg:py-44 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-[32rem] h-[32rem] bg-orange-100/20 rounded-full blur-[200px] pointer-events-none -translate-y-1/2 -translate-x-1/2"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
                <!-- Vision -->
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-left')" class="opacity-0-initial">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                        <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">We Aspire To Be</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">Our Vision</h2>
                    <div class="relative pl-6">
                        <span class="absolute top-[-10px] left-0 text-6xl font-sans text-orange-200 leading-none select-none">&ldquo;</span>
                        <div class="rich-text text-lg font-bold text-gray-900 leading-relaxed pl-4 italic">
                            {!! $settings['about_vision'] ?? '<p>RUBIKNOWS AIMS TO BE THE PREFERRED ENGINEERING AND CONSTRUCTION FIRM IN MINDANAO.</p>' !!}
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-right')" class="opacity-0-initial">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                        <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">What We Do</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-7">Our Mission</h2>
                    <div class="rich-text text-gray-600 leading-relaxed text-base space-y-5">
                        {!! $settings['about_mission'] ?? '
                        <p class="text-gray-900 font-bold font-mono text-xs uppercase tracking-wider mb-1">Hassle Free to Clients</p>
                        <p class="mb-4">To provide all-in engineering services from plans to permit process, up to construction or renovation</p>

                        <p class="text-gray-900 font-bold font-mono text-xs uppercase tracking-wider mb-1">Quality and Affordability</p>
                        <p class="mb-4">Committed to deliver and execute works with quality and standard in all projects</p>

                        <p class="text-gray-900 font-bold font-mono text-xs uppercase tracking-wider mb-1">Sustainable Designs</p>
                        <p class="mb-4">Seeks to reduce negative impacts on the environment, and the health and comfort of building occupants</p>

                        <p class="text-gray-900 font-bold font-mono text-xs uppercase tracking-wider mb-1">Produce Employment Opportunities</p>
                        <p>Helps to employ skillful workers payed according to their performances</p>
                        ' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leadership -->
    <div class="py-32 lg:py-44 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial text-center mb-16">
                <div class="flex items-center justify-center gap-3 mb-7">
                    <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Leadership</span>
                    <div class="h-px w-28 bg-gradient-to-l from-orange-500 to-amber-300"></div>
                </div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight">Our Owners</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                @foreach(['Ruvelyn S. Rubinos', 'Kevin C. Rubinos'] as $index => $owner)
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                     class="opacity-0-initial group p-10 text-center bg-white border border-gray-100 rounded-[2rem] hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-700"
                     style="animation-delay: {{ $index * 0.12 }}s">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl shadow-orange-500/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">{{ $owner }}</h3>
                    <p class="text-[11px] font-bold text-gray-500 font-mono uppercase tracking-wider mt-3">Owner</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black py-20 lg:py-28 overflow-hidden border-t border-slate-700">
        <div class="absolute inset-0 bg-grid-pattern-dark opacity-[0.08] pointer-events-none"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[1000px] bg-yellow-500/8 rounded-full blur-[200px] pointer-events-none -translate-y-1/2"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="h-px w-20 bg-gradient-to-r from-yellow-500 to-orange-300"></div>
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Ready To Partner?</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Let's Build <span class="gold-shimmer-text italic font-black">Together</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Discover how we can bring your vision to life with our engineering expertise and construction excellence.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-500 font-bold text-sm">
                        Get In Touch
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('public.projects') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border-2 border-white/30 text-white hover:bg-white/10 hover:border-white/50 transition-all duration-500 font-bold text-sm">
                        View Our Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
