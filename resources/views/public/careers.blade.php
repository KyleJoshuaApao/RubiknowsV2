<x-public-layout>
    <x-slot name="title">Careers</x-slot>

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
                Join Our Team
            </p>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Build Your Career
            </h1>
            <p class="mt-8 text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed font-bold">
                Join a team of dedicated professionals committed to excellence in engineering and construction.
            </p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <section class="py-24 lg:py-32 bg-gray-50" x-data="{ applyFor: '{{ request('job') }}' }">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Job Listings (Left) -->
                <div class="lg:col-span-7 xl:col-span-8">
                    <div class="mb-12 border-b-4 border-gray-200 pb-6 inline-block">
                        <h2 class="text-4xl font-black text-richblack-900 uppercase tracking-tighter">Open Positions</h2>
                    </div>

                    <div class="space-y-8">
                        @forelse($jobs as $job)
                            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                                 class="bg-white p-8 border-t-4 border-brand-500 shadow-sm hover:shadow-lg transition-shadow duration-300"
                                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                                
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 mb-6">
                                    <div>
                                        <h3 class="text-2xl font-black text-richblack-900 uppercase tracking-tight">{{ $job->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-6 text-sm font-bold text-gray-500 mt-4 uppercase tracking-wider">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $job->location }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                {{ $job->type }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <button @click="applyFor = '{{ $job->title }}'; $nextTick(() => document.getElementById('application-form').scrollIntoView({behavior: 'smooth'}))" 
                                            class="inline-flex items-center justify-center bg-gray-900 text-white font-black uppercase tracking-widest text-xs px-6 py-3 hover:bg-brand-500 transition-colors flex-shrink-0">
                                        Apply Now
                                    </button>
                                </div>
                                
                                <div class="text-base font-medium text-gray-700 leading-relaxed mb-6 line-clamp-3">
                                    {{ $job->description }}
                                </div>
                                
                                <div x-data="{ expanded: false }">
                                    <button @click="expanded = !expanded" class="text-sm font-black text-brand-500 uppercase tracking-widest hover:text-richblack-900 flex items-center transition-colors">
                                        <span x-text="expanded ? 'Hide Details' : 'View Requirements'"></span>
                                        <svg class="w-5 h-5 ml-2 transform transition-transform" stroke-width="3" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    
                                    <div x-show="expanded" x-collapse class="mt-8 pt-8 border-t-2 border-gray-100">
                                        <div class="rich-text text-sm font-medium text-gray-700">
                                            <p class="font-black text-richblack-900 uppercase tracking-widest mb-4">Requirements:</p>
                                            {!! nl2br(e($job->requirements)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-24 bg-white border-4 border-gray-100">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-bold uppercase tracking-wider">We currently have no open positions.<br>Please check back later.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($jobs->hasPages())
                        <div class="mt-16 flex justify-center">
                            {{ $jobs->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
                
                <!-- Application Form (Right) -->
                <div class="lg:col-span-5 xl:col-span-4" id="application-form">
                    <div class="sticky top-28 bg-white border-t-4 border-brand-500 p-8 shadow-xl">
                        <div class="mb-10 border-b-2 border-gray-100 pb-6">
                            <h3 class="text-2xl font-black text-richblack-900 uppercase tracking-tighter mb-3">Submit Application</h3>
                            <p class="text-sm font-bold text-gray-500">Fill out the form below to apply. If you don't see a fitting role, you can select "General Application".</p>
                        </div>
                        
                        <form action="{{ route('public.careers.apply') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Position Applied For *</label>
                                <select name="job_title" x-model="applyFor" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors cursor-pointer">
                                    <option value="">Select a position...</option>
                                    <option value="General Application">General Application</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->title }}">{{ $job->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Full Name *</label>
                                <input type="text" name="name" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" placeholder="John Doe">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Email Address *</label>
                                <input type="email" name="email" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" placeholder="john@example.com">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Phone Number *</label>
                                <input type="text" name="phone" required class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" placeholder="(555) 123-4567">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Cover Letter / Message (Optional)</label>
                                <textarea name="message" rows="4" class="w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors" placeholder="Briefly tell us why you're a good fit..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-richblack-900 uppercase tracking-widest mb-2">Resume / CV *</label>
                                <p class="text-xs font-bold text-gray-500 mb-3">PDF, DOC, DOCX (Max 5MB)</p>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx" required 
                                       class="block w-full text-sm text-gray-500 font-bold file:mr-4 file:py-3 file:px-6 file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-brand-500 file:text-white hover:file:bg-richblack-950 cursor-pointer bg-gray-50 border-0 border-b-4 border-gray-200 p-2 transition-colors">
                            </div>
                            
                            <div class="pt-6">
                                <button type="submit" class="inline-flex items-center justify-center w-full px-8 py-4 bg-brand-500 text-white font-black text-sm tracking-widest uppercase hover:bg-gray-900 transition-colors shadow-sm">
                                    Submit Application
                                    <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</x-public-layout>
