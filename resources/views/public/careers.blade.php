<x-public-layout>
    <x-slot name="title">Careers</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(ellipse at top right, rgba(224,123,42,0.08), transparent 55%);"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.02] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial mb-8">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-[0.3em] border border-orange-100">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    Join Our Team
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-8 animate-fade-in-up delay-200">
                Build Your <span class="gold-shimmer-text italic font-black">Career</span> With Us
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" style="animation-delay: 0.2s">
                Join a team of passionate engineers and builders shaping the future of infrastructure.
            </p>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="py-32 lg:py-44 bg-white" x-data="{ applyingFor: null, jobTitle: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-6">
                @forelse($jobs as $job)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0-initial bg-white border border-gray-100 rounded-[2rem] p-8 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-700">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">{{ $job->title }}</h3>
                                <div class="mt-4 flex flex-wrap gap-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-100 text-orange-700 font-mono text-[11px] font-bold rounded-full uppercase tracking-wider">
                                        {{ $job->type }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-100 text-orange-700 font-mono text-[11px] rounded-full uppercase tracking-wider">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $job->location }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <button @click="applyingFor = {{ $job->id }}; jobTitle = '{{ addslashes($job->title) }}'; setTimeout(() => document.getElementById('applyFormContainer').scrollIntoView({behavior: 'smooth'}), 100);" class="inline-flex items-center justify-center px-5 py-2.5 border border-orange-500 rounded-full text-sm font-semibold text-orange-600 bg-white hover:bg-orange-500 hover:text-white hover:shadow-xl hover:shadow-orange-500/30 transition-all duration-500 w-full md:w-auto">
                                    Apply Now
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="rich-text text-gray-600 text-sm leading-relaxed">
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4 font-mono">Description</h4>
                            <p class="whitespace-pre-wrap mb-8">{{ $job->description }}</p>

                            @if($job->requirements)
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4 font-mono">Requirements</h4>
                                <p class="whitespace-pre-wrap">{{ $job->requirements }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-orange-50 border border-orange-100 rounded-[2rem]">
                        <svg class="mx-auto h-16 w-16 text-orange-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-6 text-lg font-bold text-gray-900">No Open Positions</h3>
                        <p class="mt-2 text-base text-gray-600">We don't have any open roles right now. Check back later!</p>
                    </div>
                @endforelse
            </div>

            <!-- Application Form (Alpine controlled) -->
            <div id="applyFormContainer" x-show="applyingFor !== null" style="display: none;" class="mt-20 bg-white border border-gray-100 rounded-[2rem] overflow-hidden">
                <div class="bg-gradient-to-r from-orange-600 to-amber-500 px-8 py-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white font-mono text-sm uppercase tracking-wider">Application: <span x-text="jobTitle" class="font-sans normal-case tracking-normal text-xl"></span></h3>
                    <button @click="applyingFor = null" class="text-white hover:text-orange-100 focus:outline-none transition-colors p-2 rounded-full hover:bg-white/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 md:p-10">
                    @if($errors->any())
                        <div class="mb-8 bg-orange-50 border-l-4 border-orange-500 p-6 rounded-r-[1.25rem]">
                            <p class="text-base text-gray-900 font-medium">Please fix the errors below and try again.</p>
                        </div>
                    @endif

                    <form x-bind:action="'/careers/' + applyingFor + '/apply'" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                @error('name')<p class="mt-2 text-sm text-orange-600 font-medium">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" required class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                                @error('email')<p class="mt-2 text-sm text-orange-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300">
                        </div>

                        <div>
                            <label for="cover_letter" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Cover Letter / Message</label>
                            <textarea name="cover_letter" id="cover_letter" rows="4" class="block w-full bg-orange-50 border border-gray-100 text-gray-900 rounded-[1.25rem] focus:ring-orange-500 focus:border-orange-500 py-2.5 px-4 text-sm transition-all duration-300"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-orange-50/85 border border-orange-100 rounded-[1.5rem]">
                            <div>
                                <label for="resume" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Resume (PDF, DOCX) *</label>
                                <input type="file" name="resume" id="resume" required accept=".pdf,.doc,.docx" class="mt-3 block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border file:border-orange-100 file:text-xs file:font-mono file:font-bold file:bg-white file:text-orange-600 hover:file:bg-orange-50 cursor-pointer transition-all duration-300">
                                @error('resume')<p class="mt-2 text-sm text-orange-600 font-medium">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="portfolio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider font-mono mb-2">Portfolio (PDF, ZIP) (Optional)</label>
                                <input type="file" name="portfolio" id="portfolio" accept=".pdf,.zip" class="mt-3 block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border file:border-orange-100 file:text-xs file:font-mono file:font-bold file:bg-white file:text-orange-600 hover:file:bg-orange-50 cursor-pointer transition-all duration-300">
                                @error('portfolio')<p class="mt-2 text-sm text-orange-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-6 flex flex-col md:flex-row justify-end gap-4">
                            <button type="button" @click="applyingFor = null" class="px-5 py-2.5 border border-gray-100 text-sm font-semibold rounded-full text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-200 focus:outline-none transition-all duration-300">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full shadow-lg shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 transition-all duration-500 font-semibold text-sm">
                                Submit Application
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
