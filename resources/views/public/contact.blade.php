<x-public-layout>
    <x-slot name="title">Contact Us</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    Get In Touch
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                Let's Work <span class="gold-shimmer-text italic font-black">Together</span>
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Whether you have a general question or need a detailed project estimate, we're here to help.
            </p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="py-32 lg:py-44 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">

                <!-- Contact Info Sidebar -->
                <div class="lg:col-span-1 space-y-8">
                    @php
                        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                    @endphp

                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-8 lg:p-10 border border-orange-100 rounded-[2rem]">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="h-px w-10 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                            <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Contact Information</span>
                        </div>

                        <div class="space-y-6">
                            @if(!empty($settings['office_address']))
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-[1.25rem] bg-gradient-to-br from-orange-500 to-amber-500 text-white shadow-xl shadow-orange-500/30">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-1">Head Office</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $settings['office_address'] }}</p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($settings['contact_phone']))
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-[1.25rem] bg-gradient-to-br from-orange-500 to-amber-500 text-white shadow-xl shadow-orange-500/30">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-1">Phone</h4>
                                    <p class="text-sm text-gray-600 font-mono">{{ $settings['contact_phone'] }}</p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($settings['contact_email']))
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-[1.25rem] bg-gradient-to-br from-orange-500 to-amber-500 text-white shadow-xl shadow-orange-500/30">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-1">Email</h4>
                                    <p class="text-sm text-gray-600"><a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-orange-600 transition-colors font-mono">{{ $settings['contact_email'] }}</a></p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-3 border border-orange-100 rounded-[2rem] overflow-hidden">
                        <div class="rounded-[1.5rem] overflow-hidden h-[300px] w-full border border-orange-100 relative">
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($settings['office_address'] ?? 'Manila, Philippines') }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full border-0 grayscale contrast-[110%]"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Forms Area -->
                <div class="lg:col-span-2" x-data="{ tab: '{{ request('tab', 'general') }}' }">
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-2 rounded-[2rem] border border-orange-100 flex mb-8">
                        <button @click="tab = 'general'" :class="{ 'bg-white text-gray-900 shadow-lg border border-orange-100': tab === 'general', 'text-gray-600 hover:text-orange-600': tab !== 'general' }" class="flex-1 py-2.5 text-xs uppercase tracking-wider font-mono font-bold rounded-[1.5rem] transition-all duration-300">
                            General Inquiry
                        </button>
                        <button @click="tab = 'quote'" :class="{ 'bg-gradient-to-r from-orange-600 to-amber-500 text-white shadow-xl shadow-orange-500/30': tab === 'quote', 'text-gray-600 hover:text-orange-600': tab !== 'quote' }" class="flex-1 py-2.5 text-xs uppercase tracking-wider font-mono font-bold rounded-[1.5rem] transition-all duration-300">
                            Request a Quotation
                        </button>
                    </div>

                    <!-- General Contact Form -->
                    <div x-show="tab === 'general'" class="bg-white p-8 lg:p-10 border border-gray-100 rounded-[2rem] hover:border-orange-200 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="h-px w-10 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                            <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Send us a message</span>
                        </div>

                        <form action="{{ route('public.contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Name *</label>
                                    <input type="text" name="name" id="name" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Email *</label>
                                    <input type="email" name="email" id="email" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Company (Optional)</label>
                                    <input type="text" name="company" id="company" class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Phone (Optional)</label>
                                    <input type="text" name="phone" id="phone" class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Subject *</label>
                                <input type="text" name="subject" id="subject" value="{{ request('subject') }}" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                            </div>

                            <div>
                                <label for="message" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Message *</label>
                                <textarea id="message" name="message" rows="5" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="inline-flex items-center justify-center w-full px-6 py-2.5 rounded-full shadow-lg shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 transition-all duration-500 font-semibold text-sm">
                                    Send Message
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Quotation Form -->
                    <div x-show="tab === 'quote'" style="display: none;" class="bg-white p-8 lg:p-10 border border-gray-100 rounded-[2rem] hover:border-orange-200 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-px w-10 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                            <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Project Quotation</span>
                        </div>
                        <p class="text-gray-600 mb-8 text-sm leading-relaxed">Provide details about your project to help our engineering team accurately estimate the scope and costs.</p>

                        <form action="{{ route('public.quotation.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Personal Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-orange-50/80 p-6 lg:p-8 border border-orange-100 rounded-[1.5rem]">
                                <div class="col-span-full mb-1">
                                    <h4 class="text-[11px] font-bold text-gray-700 font-mono uppercase tracking-[0.2em]">Contact Information</h4>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Full Name *</label>
                                    <input type="text" name="name" required class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Company Name</label>
                                    <input type="text" name="company" class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Email Address *</label>
                                    <input type="email" name="email" required class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Phone Number</label>
                                    <input type="text" name="phone" class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>
                            </div>

                            <!-- Project Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-full mb-1">
                                    <h4 class="text-[11px] font-bold text-gray-700 font-mono uppercase tracking-[0.2em]">Project Details</h4>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Primary Service Needed *</label>
                                    <select name="service_needed" required class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
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
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Project Location *</label>
                                    <input type="text" name="project_location" required placeholder="City, State" class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Estimated Budget Range</label>
                                    <input type="text" name="budget" placeholder="e.g. $100k - $500k" class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Expected Timeline</label>
                                    <input type="text" name="timeline" placeholder="e.g. Start in 3 months" class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Project Description *</label>
                                    <textarea name="description" rows="4" required placeholder="Please describe the scope, requirements, and any specific details..." class="block w-full bg-white border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300"></textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Attach Documents (Optional)</label>
                                    <p class="text-xs text-gray-500 mb-3">Upload architectural plans, site photos, or RFPs (Max 10MB)</p>
                                    <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png,.zip" class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border file:border-orange-100 file:text-xs file:font-mono file:font-bold file:bg-white file:text-orange-600 hover:file:bg-orange-50 cursor-pointer transition-all duration-300">
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="inline-flex items-center justify-center w-full px-6 py-2.5 rounded-full shadow-lg shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 transition-all duration-500 font-semibold text-sm">
                                    Submit Request for Quotation
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
