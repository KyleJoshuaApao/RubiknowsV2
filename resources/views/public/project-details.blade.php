<x-public-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>

    <!-- ===== PROJECT HERO ===== -->
    <section class="relative bg-gray-900 pt-32 pb-20 lg:pt-40 lg:pb-32 kh-angled-bottom-right mb-16 border-b-8 border-brand-500">
        <!-- Hero Background -->
        @if($project->cover_image_path)
        <div class="absolute inset-0 z-0">
            <img src="{{ Storage::url($project->cover_image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover grayscale opacity-50">
        </div>
        @else
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(255,255,255,0.5) 40px, rgba(255,255,255,0.5) 41px);"></div>
        @endif

        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="max-w-4xl" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <div class="w-16 h-2 bg-brand-500 mb-8"></div>

                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('public.projects') }}" class="inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-brand-500 hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        All Projects
                    </a>
                    <span class="text-white/30">/</span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-white/50">{{ $project->category }}</span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white leading-none tracking-tight mb-8">
                    {{ $project->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 lg:gap-10 text-gray-300 text-sm font-bold uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $project->location }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        <span class="{{ $project->status === 'Completed' || $project->status === 'Featured' ? 'text-white' : 'text-gray-400' }}">
                            {{ $project->status === 'Featured' ? 'Completed' : $project->status }}
                        </span>
                    </div>
                    @if($project->completion_date)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($project->completion_date)->format('F Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PROJECT CONTENT ===== -->
    <section class="py-16 lg:py-24 bg-white relative">
        <div class="max-w-screen-2xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

                <!-- Main Content (Left) -->
                <div class="lg:col-span-8 order-2 lg:order-1">
                    <div class="prose prose-lg prose-gray max-w-none rich-text font-medium text-gray-700 leading-relaxed">
                        {!! $project->content !!}
                    </div>

                    @if($project->gallery_images)
                    @php
                    $images = is_array($project->gallery_images) ? $project->gallery_images : json_decode($project->gallery_images, true);
                    @endphp

                    @if(!empty($images))
                    <div class="mt-16 pt-16 border-t-4 border-gray-100">
                        <h3 class="text-3xl font-black text-richblack-900 mb-8 uppercase tracking-tighter">Project Gallery</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($images as $image)
                            <div class="aspect-w-16 aspect-h-12 bg-gray-100 overflow-hidden cursor-zoom-in border-b-4 border-transparent hover:border-brand-500 transition-colors" onclick="window.open('{{ Storage::url($image) }}', '_blank')">
                                <img src="{{ Storage::url($image) }}" alt="Gallery Image" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Metadata Sidebar (Right) -->
                <div class="lg:col-span-4 order-1 lg:order-2">
                    <div class="sticky top-28 bg-gray-50 border-t-4 border-brand-500 p-8 shadow-lg">
                        <h3 class="text-sm font-black text-richblack-900 uppercase tracking-widest mb-6 pb-4 border-b-2 border-brand-500 inline-block">Project Details</h3>

                        <dl class="space-y-6">
                            @if($project->client_name)
                            <div>
                                <dt class="text-xs font-black text-brand-500 uppercase tracking-widest mb-1">Client</dt>
                                <dd class="text-lg font-bold text-richblack-900">{{ $project->client_name }}</dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-xs font-black text-brand-500 uppercase tracking-widest mb-1">Category</dt>
                                <dd class="text-lg font-bold text-richblack-900">{{ $project->category }}</dd>
                            </div>

                            <div>
                                <dt class="text-xs font-black text-brand-500 uppercase tracking-widest mb-1">Location</dt>
                                <dd class="text-lg font-bold text-richblack-900">{{ $project->location }}</dd>
                            </div>

                            @if($project->status)
                            <div>
                                <dt class="text-xs font-black text-brand-500 uppercase tracking-widest mb-1">Status</dt>
                                <dd class="text-lg font-bold text-richblack-900">{{ $project->status === 'Featured' ? 'Completed' : $project->status }}</dd>
                            </div>
                            @endif
                        </dl>

                        <div class="mt-10 pt-8 border-t border-gray-200">
                            <p class="text-sm font-bold text-gray-600 mb-6 uppercase tracking-wider">Interested in a similar project?</p>
                            <div class="mt-4">
                                <x-kh-button href="{{ route('public.contact', ['subject' => 'Inquiry regarding project: ' . $project->title]) }}" text="Contact Us" class="w-full justify-center" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>