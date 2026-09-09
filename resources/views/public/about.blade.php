<x-public-layout>
    <x-slot name="title">About Us</x-slot>

    @php
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    @endphp>

    <!-- ===== KIMLEY-HORN STYLE HERO ===== -->
    <section class="relative h-[60vh] min-h-[500px] flex items-center bg-gray-900 rounded-none mb-12">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1541888081-3e4b1a4767e7?q=80&w=2500&auto=format&fit=crop"
                 alt="RubiKnows Team"
                 class="w-full h-full object-cover opacity-50 grayscale hover:grayscale-0 transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-screen-2xl mx-auto px-6 lg:px-12 pt-20 border-l-4 border-brand-500 ml-4 md:ml-8 lg:ml-12">
            <h1 x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                class="text-5xl sm:text-7xl lg:text-8xl font-bold text-white leading-none tracking-tight">
                About Us
            </h1>
        </div>
    </section>

    <!-- ===== STANDARD TEXT / MISSION ===== -->
    <section class="py-12 lg:py-16 bg-white relative">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-lightgray/30 -z-10 kh-angled-deco-right"></div>
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="max-w-5xl">
                <h3 class="text-3xl lg:text-4xl font-bold text-charcoal-700 leading-tight mb-6 tracking-tight">
                    {!! nl2br(e($settings['about_story_title'] ?? 'At RubiKnows, we lead with a people-first mindset. Whether you’re a client or an employee, you’ll feel the difference in how we work—because your success is our priority.')) !!}
                </h3>
                <div class="w-full h-1 bg-gray-200 mb-6 relative">
                    <div class="absolute top-0 left-0 h-full w-24 bg-brand-500"></div>
                </div>
                <div class="text-lg text-gray-700 leading-relaxed font-medium space-y-4">
                    {!! $settings['about_story_content'] ?? '<p>We do things differently. People—clients and employees—are at the forefront of our business. Clients know we are laser-focused on their success. Employees know our culture and approach to business are built on a desire to see our staff flourish, one and all. Both groups know that with RubiKnows, they can expect more and experience better.</p>' !!}
                </div>
            </div>
        </div>
    </section>

    <!-- ===== VIDEO / GALLERY SECTION ===== -->
    <section class="py-12 bg-richblack-950 border-t-2 border-brand-500">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="relative w-full aspect-video overflow-hidden shadow-2xl group cursor-pointer border-4 border-richblack-900">
                <!-- Video/Image Background -->
                <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2000&auto=format&fit=crop"
                     alt="Making a Difference"
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 grayscale group-hover:grayscale-0">
                <div class="absolute inset-0 bg-brand-500/20 group-hover:bg-transparent transition-colors duration-500"></div>
                <!-- Play Button Center -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-24 h-24 bg-richblack-950 border-4 border-brand-500 flex items-center justify-center group-hover:bg-brand-500 transition-all duration-300">
                        <svg class="w-10 h-10 ml-2 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CORE VALUES / AWARDS GRID ===== -->
    <section class="py-12 lg:py-16 bg-gray-50">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="mb-8 flex flex-col md:flex-row justify-between items-end border-b-4 border-richblack-900 pb-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-charcoal-700 tracking-tight">Why RubiKnows?</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Value 1 -->
                <div class="group relative block bg-white border-t-4 border-brand-500 shadow-lg hover:-translate-y-1 transition-transform duration-200">
                    <div class="aspect-[4/3] overflow-hidden border-b-4 border-richblack-900">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0" alt="People">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-richblack-900 uppercase tracking-tight mb-3">Our People</h3>
                        <p class="text-gray-600 font-medium leading-relaxed">We hire the best and brightest, fostering an environment where innovation and collaboration thrive on every project.</p>
                    </div>
                </div>

                <!-- Value 2 -->
                <div class="group relative block bg-white border-t-4 border-brand-500 shadow-lg hover:-translate-y-1 transition-transform duration-200">
                    <div class="aspect-[4/3] overflow-hidden border-b-4 border-richblack-900">
                        <img src="https://images.unsplash.com/photo-1541888081-3e4b1a4767e7?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0" alt="Diversity">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-richblack-900 uppercase tracking-tight mb-3">Diversity & Inclusion</h3>
                        <p class="text-gray-600 font-medium leading-relaxed">We believe that a diverse team brings unparalleled creativity, driving exceptional outcomes for our communities.</p>
                    </div>
                </div>

                <!-- Value 3 -->
                <div class="group relative block bg-white border-t-4 border-brand-500 shadow-lg hover:-translate-y-1 transition-transform duration-200">
                    <div class="aspect-[4/3] overflow-hidden border-b-4 border-richblack-900">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0" alt="Client Service">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-richblack-900 uppercase tracking-tight mb-3">Client Service</h3>
                        <p class="text-gray-600 font-medium leading-relaxed">Our clients are our partners. We share your vision and dedicate our expertise to turning your goals into reality.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== BOLD QUOTE / STATEMENT ===== -->
    <section class="py-16 bg-brand-500 relative overflow-hidden border-t-2 border-richblack-950 border-b-2">
        <!-- Abstract shape -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-richblack-950/10 transform -skew-x-12 origin-top-right"></div>
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10 text-center">
            <blockquote class="max-w-5xl mx-auto">
                <p class="text-3xl md:text-4xl font-bold text-white leading-tight mb-6 uppercase tracking-tight">
                    "With God, <br>All things are possible."
                </p>
                <footer class="text-richblack-950 font-bold tracking-[0.3em] uppercase text-lg bg-white inline-block px-6 py-2">
                    — Matthew 19:26
                </footer>
            </blockquote>
        </div>
    </section>

    <!-- ===== LEADERSHIP / OUR PEOPLE ===== -->
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="mb-6 border-b-4 border-richblack-900 pb-4 flex items-end justify-between">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-charcoal-700 tracking-tight">Our Leadership</h2>
                    <p class="mt-3 text-xl text-brand-500 font-bold uppercase tracking-widest">The minds guiding our vision</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Leader 1 -->
                <div class="bg-gray-50 border-t-4 border-brand-500 overflow-hidden group hover:bg-richblack-950 transition-colors duration-200">
                    <div class="aspect-square bg-gray-200 flex items-end justify-center relative overflow-hidden border-b-4 border-white group-hover:border-richblack-900 transition-colors">
                        <svg class="w-28 h-28 text-gray-400 transform translate-y-3 group-hover:scale-105 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <div class="absolute inset-0 bg-brand-500/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-richblack-900 group-hover:text-white uppercase tracking-tight transition-colors">Ruvelyn S. Rubinos</h3>
                        <p class="text-sm font-bold text-brand-500 uppercase tracking-widest mt-2">Founder / Owner</p>
                    </div>
                </div>

                <!-- Leader 2 -->
                <div class="bg-gray-50 border-t-4 border-brand-500 overflow-hidden group hover:bg-richblack-950 transition-colors duration-200">
                    <div class="aspect-square bg-gray-200 flex items-end justify-center relative overflow-hidden border-b-4 border-white group-hover:border-richblack-900 transition-colors">
                        <svg class="w-28 h-28 text-gray-400 transform translate-y-3 group-hover:scale-105 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <div class="absolute inset-0 bg-brand-500/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-richblack-900 group-hover:text-white uppercase tracking-tight transition-colors">Kevin C. Rubinos</h3>
                        <p class="text-sm font-bold text-brand-500 uppercase tracking-widest mt-2">Founder / Owner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>