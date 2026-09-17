<x-public-layout>
    <x-slot name="title">Home</x-slot>

    <div x-data="homeLivePreview" class="rk-home">
        <section class="relative min-h-[calc(100vh-7rem)] overflow-hidden bg-[#0b0c0c] text-white">
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1600&auto=format&fit=crop" srcset="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=640&auto=format&fit=crop 640w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1024&auto=format&fit=crop 1024w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1600&auto=format&fit=crop 1600w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2200&auto=format&fit=crop 2200w" sizes="100vw" alt="RubiKnows engineering and construction project" fetchpriority="high" decoding="async" class="absolute inset-0 h-full w-full object-cover opacity-45 grayscale">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0c0c] via-[#0b0c0c]/75 to-transparent"></div>
            <div class="absolute right-0 top-0 h-full w-1/3 border-l border-white/10 bg-black/10 [clip-path:polygon(34%_0,100%_0,100%_100%,0_100%)]"></div>
            <div class="relative z-10 mx-auto flex min-h-[calc(100vh-7rem)] max-w-[96rem] items-end px-6 pb-16 pt-28 sm:px-10 lg:px-16 lg:pb-24">
                <div class="max-w-5xl">
                    <p class="mb-7 flex items-center gap-4 text-xs font-black uppercase tracking-[.28em] text-[#dcae32]"><span class="h-px w-14 bg-[#dcae32]"></span>Established 2020 · Engineering Excellence</p>
                    <h1 class="max-w-5xl text-white text-6xl font-black uppercase leading-[.82] tracking-[-.07em] sm:text-8xl lg:text-[clamp(5rem,11vw,11rem)]">Building<br><span class="text-[#dcae32]">what lasts.</span></h1>
                    <div class="mt-10 flex max-w-2xl flex-col gap-8 border-l-2 border-[#dcae32] pl-5 sm:flex-row sm:items-end sm:justify-between">
                        <p class="text-base leading-relaxed text-white/75 sm:max-w-md">We deliver premier civil, structural engineering, and construction services. Partner with RubiKnows to bring state-of-the-art infrastructure projects to life with precision and integrity.</p>
                        <a href="{{ route('public.projects') }}" class="rk-button shrink-0">Explore work <span>↗</span></a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-7 right-7 hidden items-center gap-3 text-[10px] font-bold uppercase tracking-[.22em] text-white/60 sm:flex"><span class="h-10 w-px bg-[#dcae32]"></span>Scroll to explore</div>
        </section>

        <section class="border-y border-black/10 bg-white px-6 text-[#0b0c0c] sm:px-10 lg:px-16" x-show="previewData.stats && previewData.stats.length" x-cloak>
            <div class="mx-auto grid max-w-[96rem] divide-y divide-black/10 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4">
                <template x-for="(stat, index) in previewData.stats" :key="`${stat.label}-${index}`">
                    <div class="py-8 sm:px-8 lg:px-10"><p class="text-4xl font-black tracking-[-.06em] text-brand-500 sm:text-5xl" x-text="stat.value"></p><p class="mt-2 text-[10px] font-black uppercase tracking-[.18em] text-black/55" x-text="stat.label"></p></div>
                </template>
            </div>
        </section>

        <section class="rk-reveal bg-[#dcae32] px-6 py-14 text-[#0b0c0c] sm:px-10 lg:px-16" x-data x-intersect.once="$el.classList.add('rk-is-visible')">
            <div class="mx-auto grid max-w-[96rem] gap-10 lg:grid-cols-[1.2fr_2fr] lg:items-end">
                <div><p class="rk-kicker text-[#0b0c0c]/70">RubiKnows / The practice</p><h2 class="mt-3 max-w-xl text-4xl font-black uppercase leading-[.9] tracking-[-.05em] sm:text-6xl">Together, we create the remarkable.</h2></div>
                <p class="max-w-2xl text-lg font-medium leading-relaxed">RubiKnows blends engineering precision, construction expertise, and strategic thinking to turn ambitious ideas into enduring places. From the first drawing to final delivery, we make complex work feel clear, considered, and built to last.</p>
            </div>
        </section>

        <section class="rk-reveal bg-[#f7f7f5] px-6 py-20 text-[#0b0c0c] sm:px-10 lg:px-16 lg:py-32" x-data x-intersect.once="$el.classList.add('rk-is-visible')">
            <div class="mx-auto max-w-[96rem]">
                <div class="mb-14 flex flex-col justify-between gap-6 md:flex-row md:items-end"><div><p class="rk-kicker">Capabilities</p><h2 class="mt-3 max-w-3xl text-5xl font-black uppercase leading-[.86] tracking-[-.06em] sm:text-7xl">Ideas into<br><span class="text-brand-500">infrastructure.</span></h2></div><a href="{{ route('public.services') }}" class="rk-text-link">View all services ↗</a></div>
                <div class="grid border-t border-black/20 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($services as $service)
                        <a href="{{ route('public.service-details', $service) }}" class="group border-b border-r border-black/20 p-7 transition-colors hover:bg-brand-500 hover:text-[#0b0c0c] sm:p-10"><span class="text-sm font-black text-brand-600 group-hover:text-[#0b0c0c]/60">0{{ $loop->iteration }}</span><h3 class="mt-16 text-2xl font-black uppercase leading-none tracking-[-.03em]">{{ $service->title }}</h3><p class="mt-5 max-w-sm text-sm leading-relaxed text-black/60 group-hover:text-[#0b0c0c]/75">{{ $service->short_description ?? Str::limit(strip_tags($service->content), 150) }}</p><span class="mt-8 block text-xs font-black uppercase tracking-[.18em] opacity-0 transition-opacity group-hover:opacity-100">Discover service →</span></a>
                    @empty
                        <p class="col-span-full py-12 text-sm uppercase tracking-[.18em] text-black/50">Services are being prepared.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rk-reveal bg-[#f1f0ec] px-6 py-20 text-[#0b0c0c] sm:px-10 lg:px-16 lg:py-32" x-data x-intersect.once="$el.classList.add('rk-is-visible')">
            <div class="mx-auto max-w-[96rem]">
                <div class="mb-14 flex flex-col justify-between gap-6 md:flex-row md:items-end"><div><p class="rk-kicker">Selected work</p><h2 class="mt-3 text-5xl font-black uppercase leading-[.86] tracking-[-.06em] sm:text-7xl">Built for<br><span class="text-[#b18716]">the real world.</span></h2></div><a href="{{ route('public.projects') }}" class="rk-text-link">See complete portfolio ↗</a></div>
                <div class="grid gap-5 lg:grid-cols-12">
                    @forelse($featuredProjects as $project)
                        <a href="{{ route('public.project-details', $project) }}" class="group relative min-h-[28rem] overflow-hidden bg-[#202527] lg:col-span-{{ $loop->first ? '7' : '5' }} {{ $loop->index === 2 ? 'lg:col-start-4' : '' }}">@if($project->cover_image_path)<img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($project->cover_image_path) }}" alt="{{ $project->title }}" class="absolute inset-0 h-full w-full object-cover opacity-75 grayscale transition duration-700 group-hover:scale-105 group-hover:opacity-100 group-hover:grayscale-0">@endif<div class="absolute inset-0 bg-gradient-to-t from-[#0b0c0c] via-[#0b0c0c]/20 to-transparent"></div><div class="absolute inset-x-0 bottom-0 p-7 text-white sm:p-10"><span class="text-[10px] font-black uppercase tracking-[.2em] text-[#dcae32]">{{ $project->category ?: 'Project' }}</span><h3 class="mt-3 max-w-lg text-3xl font-black uppercase leading-[.9] tracking-[-.04em] sm:text-5xl">{{ $project->title }}</h3><p class="mt-5 text-sm text-white/70">{{ $project->location ?: 'Philippines' }} <span class="px-2 text-[#dcae32]">/</span> View project ↗</p></div></a>
                    @empty
                        <div class="col-span-full border border-[#0b0c0c]/20 py-20 text-center text-sm uppercase tracking-[.18em]">Projects are being prepared.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <x-project-map :projects="$mapProjects" id="home-project-map" />

        <section class="rk-reveal bg-[#f1f0ec] px-6 py-20 sm:px-10 lg:px-16 lg:py-32" x-data x-intersect.once="$el.classList.add('rk-is-visible')"><div class="mx-auto max-w-[96rem]"><div class="mb-14 flex items-end justify-between gap-6"><div><p class="rk-kicker">Client perspective</p><h2 class="mt-3 text-5xl font-black uppercase leading-[.86] tracking-[-.06em] sm:text-7xl">Good work<br><span class="text-[#b18716]">speaks.</span></h2></div><a href="{{ route('public.testimonials') }}" class="rk-text-link hidden sm:block">All testimonials ↗</a></div><div class="grid gap-px bg-[#0b0c0c]/15 md:grid-cols-3">@forelse($testimonials->take(3) as $testimonial)<article class="bg-[#f1f0ec] p-8 sm:p-10"><div class="text-4xl font-black text-[#dcae32]">“</div><p class="mt-4 text-lg font-medium leading-relaxed">{{ $testimonial->quote }}</p><p class="mt-8 text-xs font-black uppercase tracking-[.16em]">{{ $testimonial->client_name }}</p><p class="mt-1 text-xs text-black/50">{{ $testimonial->company ?? 'RubiKnows client' }}</p></article>@empty<p class="col-span-full bg-[#f1f0ec] p-10 text-sm uppercase tracking-[.18em] text-black/50">Client stories are being prepared.</p>@endforelse</div></div></section>

        <section class="grid bg-[#dcae32] text-[#0b0c0c] lg:grid-cols-2"><div class="px-6 py-20 sm:px-10 lg:px-16 lg:py-28"><p class="rk-kicker text-[#0b0c0c]/70">Join the team</p><h2 class="mt-3 max-w-xl text-5xl font-black uppercase leading-[.86] tracking-[-.06em] sm:text-7xl" x-text="previewData.careers.title"></h2><p class="mt-8 max-w-lg text-lg leading-relaxed" x-text="previewData.careers.description"></p><a href="{{ route('public.careers') }}" class="rk-button rk-button-dark mt-10">View open positions <span>↗</span></a></div><div class="bg-white px-6 py-20 text-[#0b0c0c] sm:px-10 lg:px-16 lg:py-28"><p class="rk-kicker">Start a conversation</p><h2 class="mt-3 max-w-xl text-5xl font-black uppercase leading-[.86] tracking-[-.06em] sm:text-7xl">Make your next build matter.</h2><p class="mt-8 max-w-lg text-lg leading-relaxed text-black/70">Tell us what you are building. Our engineers, project teams, and partners are ready to help you move the idea forward.</p><a href="{{ route('public.contact') }}" class="rk-button mt-10">Get a quotation <span>↗</span></a></div></section>
    </div>

    @push('head')<style>
        .rk-home .rk-kicker, .rk-map-section .rk-kicker { font-size:.68rem; font-weight:900; letter-spacing:.24em; text-transform:uppercase; }
        .rk-home .rk-button { display:inline-flex; align-items:center; justify-content:space-between; gap:1.5rem; min-width:11rem; padding:.95rem 1.1rem; background:#dcae32; color:#0b0c0c; font-size:.7rem; font-weight:900; letter-spacing:.13em; text-transform:uppercase; transition:transform .2s, background .2s; }
        [x-cloak] { display:none!important; } .rk-home .rk-button:hover { transform:translateY(-3px); background:#fff; } .rk-home .rk-button-dark { background:#0b0c0c; color:#fff; } .rk-home .rk-text-link { color:inherit; font-size:.68rem; font-weight:900; letter-spacing:.16em; text-transform:uppercase; } .rk-home .rk-text-link:hover { color:#b18716; } .rk-home .rk-reveal { opacity:0; transform:translateY(1.5rem); } .rk-home .rk-reveal.rk-is-visible { animation:rk-reveal .7s cubic-bezier(.2,.65,.25,1) both; } @keyframes rk-reveal { to { opacity:1; transform:none; } } @media (prefers-reduced-motion:reduce) { .rk-home .rk-reveal { opacity:1; transform:none; } .rk-home .rk-reveal.rk-is-visible { animation:none; } }
    </style>@endpush
    @push('scripts')<script>
        document.addEventListener('alpine:init', () => { Alpine.data('homeLivePreview', () => ({ previewData: { stats: @json($homeStats ?? []), markets: @json($homeMarkets ?? []), marquee: @json($homeMarquee ?? []), careers: @json($homeCareers ?? ['title' => 'Build your career with the industry leaders.', 'description' => 'We are actively recruiting talented people.']) }, init() { window.addEventListener('message', event => { if (event.data && event.data.type === 'live-editor-update') this.previewData = event.data.data; }); } })); });
    </script>@endpush
</x-public-layout>
