<x-public-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>

    <!-- Header / Hero Image -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black h-[300px] md:h-[400px] flex items-end overflow-hidden">
        @if($project->cover_image_path)
            <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}" class="absolute inset-0 w-full h-full object-cover opacity-50">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/70 to-transparent"></div>
        <div class="absolute inset-0 bg-grid-pattern-dark opacity-[0.08] pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            <span class="inline-block px-4 py-2 bg-white border border-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase tracking-wider mb-6 shadow-md">{{ $project->category }}</span>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-white tracking-tight mb-4">
                {{ $project->title }}
            </h1>
            <div class="flex items-center text-gray-300 text-sm font-mono">
                <svg class="w-4 h-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $project->location }}
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">

                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-28 bg-gradient-to-r from-orange-500 to-amber-300"></div>
                        <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em]">Project Overview</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-sans font-black text-gray-900 tracking-tight mb-8">About This Project</h2>
                    <div class="rich-text text-gray-600 leading-relaxed text-sm whitespace-pre-wrap">
                        {{ $project->description }}
                    </div>
                </div>

                <!-- Sidebar Details -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 rounded-[2rem] p-8 lg:p-10">
                        <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-[0.2em] font-mono mb-8 pb-4 border-b border-orange-200">Project Specifications</h3>

                        <dl class="space-y-6">
                            @if($project->client_name)
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono mb-1">Client</dt>
                                <dd class="text-base font-bold text-gray-900">{{ $project->client_name }}</dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono mb-1">Status</dt>
                                <dd class="text-base font-bold text-gray-900">{{ $project->status === 'Featured' ? 'Completed' : $project->status }}</dd>
                            </div>

                            @if($project->completion_date)
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono mb-1">Completion Date</dt>
                                <dd class="text-base font-bold text-gray-900">{{ \Carbon\Carbon::parse($project->completion_date)->format('F Y') }}</dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono mb-1">Category</dt>
                                <dd class="text-base font-bold text-gray-900">{{ $project->category }}</dd>
                            </div>
                        </dl>

                        <div class="mt-10 pt-6 border-t border-orange-200">
                            <a href="{{ route('public.contact', ['subject' => 'Inquiry: Project ' . $project->title]) }}" class="inline-flex items-center justify-center w-full px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-500 text-white font-bold rounded-full shadow-xl shadow-orange-500/30 hover:shadow-2xl hover:shadow-orange-500/40 hover:-translate-y-1 transition-all duration-500 text-sm">
                                Discuss a Similar Project
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20 pt-8 border-t border-gray-100 text-center">
                <a href="{{ route('public.projects') }}" class="inline-flex items-center text-gray-600 hover:text-orange-600 font-bold transition-colors text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                    Back to Portfolio
                </a>
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
                    <span class="text-amber-300 text-xs font-bold uppercase tracking-[0.3em]">Ready to Build?</span>
                    <div class="h-px w-20 bg-gradient-to-l from-yellow-500 to-orange-300"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-sans font-black text-white tracking-tight mb-6 leading-tight">
                    Let's Create Your <span class="gold-shimmer-text italic font-black">Next Project</span>
                </h2>
                <p class="text-gray-300 text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                    Inspired by this project? Let's work together to create something even more amazing.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-2xl shadow-orange-500/30 text-white bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 hover:scale-105 transition-all duration-500 font-bold text-sm">
                        Get in Touch Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
