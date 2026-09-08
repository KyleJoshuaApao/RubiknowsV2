<x-public-layout>
    <x-slot name="title">Contact Us</x-slot>

    @php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    @endphp

    <!-- ===== PAGE HEADER ===== -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gray-900 text-white relative kh-angled-bottom-right mb-16">
        <!-- Architectural Overlay -->
        <div class="absolute inset-0 z-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-screen-2xl mx-auto px-6 relative z-10 border-l-4 border-brand-500 ml-4 md:ml-8 lg:ml-12">
            <p class="text-white font-bold tracking-[0.2em] uppercase text-sm mb-6 flex items-center">
                Get In Touch
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Let's Work Together
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                Whether you have a general question or need a detailed project estimate, we're here to help.
            </p>
        </div>
    </section>

    <!-- ===== CONTACT CONTENT ===== -->
    <section class="py-24 lg:py-32 bg-white">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

                <!-- Info Sidebar (Left) -->
                <div class="lg:col-span-4 lg:col-start-1" x-data x-intersect.once="$el.classList.add('animate-fade-in-left')">

                    <div class="mb-12 bg-gray-50 p-8 border-t-4 border-brand-500 shadow-lg">
                        <h2 class="text-3xl font-black text-richblack-900 uppercase tracking-tighter mb-8 border-b-2 border-brand-500 inline-block pb-2">Contact Information</h2>

                        <dl class="space-y-8 mt-6">
                            @if(!empty($settings['office_address']))
                            <div class="flex items-start group">
                                <div class="mt-1 bg-white p-3 border-l-4 border-brand-500 group-hover:bg-richblack-950 transition-colors">
                                    <svg class="h-6 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-black text-richblack-900 uppercase tracking-widest mb-1">Head Office</dt>
                                    <dd class="text-base text-gray-700 font-medium leading-relaxed">{{ $settings['office_address'] }}</dd>
                                </div>
                            </div>
                            @endif

                            @if(!empty($settings['contact_phone']))
                            <div class="flex items-start group">
                                <div class="mt-1 bg-white p-3 border-l-4 border-brand-500 group-hover:bg-richblack-950 transition-colors">
                                    <svg class="h-6 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-black text-richblack-900 uppercase tracking-widest mb-1">Phone</dt>
                                    <dd class="text-base text-gray-700 font-bold"><a href="tel:{{ $settings['contact_phone'] }}" class="hover:text-brand-500 transition-colors">{{ $settings['contact_phone'] }}</a></dd>
                                </div>
                            </div>
                            @endif

                            @if(!empty($settings['contact_email']))
                            <div class="flex items-start group">
                                <div class="mt-1 bg-white p-3 border-l-4 border-brand-500 group-hover:bg-richblack-950 transition-colors">
                                    <svg class="h-6 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-black text-richblack-900 uppercase tracking-widest mb-1">Email</dt>
                                    <dd class="text-base text-gray-700 font-bold"><a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-brand-500 transition-colors">{{ $settings['contact_email'] }}</a></dd>
                                </div>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Map (Grayscale & Sharp) -->
                    <div class="h-64 border-4 border-richblack-900 relative group overflow-hidden mt-8">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d294.26295893005766!2d125.81667390731634!3d7.4508161115632126!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f953b3b7d922c3%3A0x21927934c5a5b49c!2sRUBIKNOWS%20Engineering%20and%20Construction!5e1!3m2!1sen!2sph!4v1788847905162!5m2!1sen!2sph" class="w-full h-full border-0 filter grayscale group-hover:grayscale-0 transition-all duration-700" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        <div class="absolute inset-0 border-4 border-transparent group-hover:border-brand-500 pointer-events-none transition-colors"></div>
                    </div>

                </div>

                <!-- Forms Area (Right) -->
                <div class="lg:col-span-8 lg:col-start-5" x-data="{ tab: '{{ request('tab', 'general') }}' }" x-intersect.once="$el.classList.add('animate-fade-in-up')">

                    <!-- Clean Tab Switcher -->
                    <div class="flex flex-wrap items-center gap-4 lg:gap-8 border-b-4 border-gray-100 mb-12">
                        <button @click="tab = 'general'"
                            :class="tab === 'general' ? 'text-richblack-900 border-b-4 border-brand-500' : 'text-gray-400 hover:text-richblack-900'"
                            class="pb-4 text-sm font-black uppercase tracking-widest transition-colors relative top-[4px]">
                            General Inquiry
                        </button>
                        <button @click="tab = 'quote'"
                            :class="tab === 'quote' ? 'text-richblack-900 border-b-4 border-brand-500' : 'text-gray-400 hover:text-richblack-900'"
                            class="pb-4 text-sm font-black uppercase tracking-widest transition-colors relative top-[4px]">
                            Request a Quotation
                        </button>
                    </div>

                    <!-- General Contact Form -->
                    <div x-show="tab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <form action="{{ route('public.contact.submit') }}" method="POST" class="space-y-8 max-w-3xl">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Name *</label>
                                    <input type="text" name="name" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Email *</label>
                                    <input type="email" name="email" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Company (Optional)</label>
                                    <input type="text" name="company" class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Phone (Optional)</label>
                                    <input type="text" name="phone" class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Subject *</label>
                                <input type="text" name="subject" value="{{ request('subject') }}" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Message *</label>
                                <textarea name="message" rows="5" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors"></textarea>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="inline-flex items-center px-10 py-5 bg-brand-500 text-white font-black text-sm tracking-widest uppercase hover:bg-richblack-950 transition-colors shadow-lg">
                                    Send Message
                                    <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Quotation Form -->
                    <div x-show="tab === 'quote'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="text-gray-600 mb-10 text-lg font-bold leading-relaxed max-w-2xl border-l-4 border-brand-500 pl-6">Provide details about your project to help our engineering team accurately estimate the scope and costs.</p>

                        <form action="{{ route('public.quotation.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-12 max-w-3xl">
                            @csrf

                            <!-- Section 1 -->
                            <div class="bg-gray-50 p-8 border-t-4 border-brand-500 shadow-sm">
                                <h3 class="text-xl font-black text-richblack-900 uppercase tracking-tighter mb-6">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Full Name *</label>
                                        <input type="text" name="name" required class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Company Name</label>
                                        <input type="text" name="company" class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Email Address *</label>
                                        <input type="email" name="email" required class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Phone Number</label>
                                        <input type="text" name="phone" class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="bg-gray-50 p-8 border-t-4 border-brand-500 shadow-sm">
                                <h3 class="text-xl font-black text-richblack-900 uppercase tracking-tighter mb-6">Project Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Primary Service Needed *</label>
                                        <select name="service_needed" required class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                            <option value="">Select a service...</option>
                                            <option value="General Construction">General Construction</option>
                                            <option value="Structural Engineering">Structural Engineering</option>
                                            <option value="Civil Engineering">Civil Engineering</option>
                                            <option value="Project Management">Project Management</option>
                                            <option value="Consultancy">Consultancy</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Project Location *</label>
                                        <input type="text" name="project_location" required placeholder="City, State" class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Estimated Budget Range</label>
                                        <input type="text" name="budget" placeholder="e.g. $100k - $500k" class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Expected Timeline</label>
                                        <input type="text" name="timeline" placeholder="e.g. Start in 3 months" class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Project Description *</label>
                                        <textarea name="description" rows="4" required placeholder="Please describe the scope, requirements, and any specific details..." class="w-full bg-white border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-3 font-bold text-gray-900 transition-colors"></textarea>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Attach Documents (Optional)</label>
                                        <p class="text-xs text-gray-500 font-bold mb-3">PDF, DOC, JPG (Max 10MB)</p>
                                        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png,.zip"
                                            class="block w-full text-sm text-gray-500 font-bold file:mr-4 file:py-3 file:px-6 file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-brand-500 file:text-white hover:file:bg-richblack-950 cursor-pointer bg-white border-0 border-b-4 border-gray-200 p-2 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="inline-flex items-center px-10 py-5 bg-brand-500 text-white font-black text-sm tracking-widest uppercase hover:bg-richblack-950 transition-colors shadow-lg">
                                    Submit Request
                                    <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</x-public-layout>