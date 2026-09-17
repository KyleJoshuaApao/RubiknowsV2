<x-public-layout>
    <x-slot name="title">Home</x-slot>

    <div class="rk-home" x-data="homeLivePreview">
        <section class="rk-home-hero">
            <img class="rk-home-hero__image" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=1600&auto=format&fit=crop" srcset="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=720&auto=format&fit=crop 720w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=1200&auto=format&fit=crop 1200w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=1600&auto=format&fit=crop 1600w, https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=2200&auto=format&fit=crop 2200w" sizes="100vw" alt="RubiKnows engineering and construction work" fetchpriority="high" decoding="async">
            <div class="rk-home-hero__wash" aria-hidden="true"></div>
            <div class="rk-container rk-home-hero__inner">
                <div class="rk-home-hero__copy">
                    <x-public.eyebrow>Established 2020 · Engineering excellence</x-public.eyebrow>
                    <h1>Building<br><em>what lasts.</em></h1>
                    <div class="rk-home-hero__bottom">
                        <p>We bring civil and structural engineering, construction, and practical project thinking together to make ambitious work real.</p>
                        <x-public.action href="{{ route('public.projects') }}">Explore work</x-public.action>
                    </div>
                </div>
            </div>
        </section>

        <section class="rk-stat-row" x-show="previewData.stats && previewData.stats.length" x-cloak aria-label="RubiKnows at a glance">
            <div class="rk-container rk-stat-row__inner">
                <template x-for="(stat, index) in previewData.stats" :key="`${stat.label}-${index}`">
                    <div class="rk-stat">
                        <p class="rk-stat__value" x-text="stat.value"></p>
                        <p class="rk-stat__label" x-text="stat.label"></p>
                    </div>
                </template>
            </div>
        </section>

        <section class="rk-statement rk-container">
            <div>
                <x-public.eyebrow class="text-[#171613]">The RubiKnows practice</x-public.eyebrow>
                <h2>Precision in the details. Clarity in the whole.</h2>
            </div>
            <p>RubiKnows pairs technical discipline with a hands-on understanding of place, people, and delivery. From the first drawing through close-out, we make complex work feel considered and buildable.</p>
        </section>

        <section class="rk-section rk-section--paper">
            <div class="rk-container">
                <div class="rk-section__head">
                    <div class="rk-section__head-copy">
                        <x-public.eyebrow>Capabilities</x-public.eyebrow>
                        <h2 class="rk-section__title">Ideas, engineered into enduring work.</h2>
                    </div>
                    <a class="rk-text-link" href="{{ route('public.services') }}">All services</a>
                </div>
                <div class="rk-services-rail">
                    @forelse($services as $service)
                        <a class="rk-service-link" href="{{ route('public.service-details', $service) }}">
                            <span class="rk-service-link__index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->short_description ?? Str::limit(strip_tags($service->content), 145) }}</p>
                            <span class="rk-service-link__more">Discover service →</span>
                        </a>
                    @empty
                        <p class="rk-empty col-span-full">Services are being prepared.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rk-section">
            <div class="rk-container">
                <div class="rk-section__head">
                    <div class="rk-section__head-copy">
                        <x-public.eyebrow>Selected work</x-public.eyebrow>
                        <h2 class="rk-section__title">Built for the real world.</h2>
                    </div>
                    <a class="rk-text-link" href="{{ route('public.projects') }}">Complete portfolio</a>
                </div>
                <div class="rk-project-mosaic">
                    @forelse($featuredProjects as $project)
                        <a class="rk-project-tile" href="{{ route('public.project-details', $project) }}">
                            @if($project->cover_image_path)
                                <img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($project->cover_image_path) }}" alt="{{ $project->title }}">
                            @endif
                            <div class="rk-project-tile__copy">
                                <span class="rk-project-tile__category">{{ $project->category ?: 'Project' }}</span>
                                <h3>{{ $project->title }}</h3>
                                <p class="rk-project-tile__meta">{{ $project->location ?: 'Philippines' }} <b>/</b> View project ↗</p>
                            </div>
                        </a>
                    @empty
                        <p class="rk-empty col-span-full">Projects are being prepared.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <x-project-map :projects="$mapProjects" id="home-project-map" />

        <section class="rk-section rk-section--paper">
            <div class="rk-container">
                <div class="rk-section__head">
                    <div class="rk-section__head-copy">
                        <x-public.eyebrow>Client perspective</x-public.eyebrow>
                        <h2 class="rk-section__title">Good work speaks.</h2>
                    </div>
                    <a class="rk-text-link" href="{{ route('public.testimonials') }}">All testimonials</a>
                </div>
                <div class="rk-quote-grid">
                    @forelse($testimonials->take(3) as $testimonial)
                        <article class="rk-quote">
                            <span class="rk-quote__mark" aria-hidden="true">“</span>
                            <p class="rk-quote__body">{{ $testimonial->quote }}</p>
                            <p class="rk-quote__by">{{ $testimonial->client_name }}</p>
                            <p class="rk-quote__company">{{ $testimonial->company ?? 'RubiKnows client' }}</p>
                        </article>
                    @empty
                        <p class="rk-empty col-span-full">Client stories are being prepared.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rk-dual-cta">
            <div class="rk-dual-cta__panel">
                <x-public.eyebrow class="text-[#171613]">Join the team</x-public.eyebrow>
                <h2 x-text="previewData.careers.title"></h2>
                <p x-text="previewData.careers.description"></p>
                <x-public.action href="{{ route('public.careers') }}" tone="dark" class="mt-8">Open positions</x-public.action>
            </div>
            <div class="rk-dual-cta__panel">
                <x-public.eyebrow>Start a conversation</x-public.eyebrow>
                <h2>Make your next build matter.</h2>
                <p>Tell us what you are building. Our engineers, project teams, and partners are ready to move the idea forward with you.</p>
                <x-public.action href="{{ route('public.contact') }}" class="mt-8">Get a quotation</x-public.action>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', function () {
                Alpine.data('homeLivePreview', function () {
                    return {
                        previewData: {
                            stats: @json($homeStats ?? []),
                            markets: @json($homeMarkets ?? []),
                            marquee: @json($homeMarquee ?? []),
                            careers: @json($homeCareers ?? ['title' => 'Build your career with the industry leaders.', 'description' => 'We are actively recruiting talented people.']),
                        },
                        init() {
                            window.addEventListener('message', (event) => {
                                if (event.data && event.data.type === 'live-editor-update') this.previewData = event.data.data;
                            });
                        },
                    };
                });
            });
        </script>
    @endpush
</x-public-layout>
