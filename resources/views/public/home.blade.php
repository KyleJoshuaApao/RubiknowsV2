<x-public-layout>
    <x-slot name="title">Home</x-slot>

    @php
        $settings = \App\Models\Setting::allCached();
        $facts = $homeStats ?: array_values(array_filter([
            filled($settings['about_est_year'] ?? null) ? ['value' => $settings['about_est_year'], 'label' => 'Established in Tagum City'] : null,
            filled($settings['about_experience_years'] ?? null) ? ['value' => $settings['about_experience_years'].'+', 'label' => 'Years in practice'] : null,
            filled($settings['about_projects_count'] ?? null) ? ['value' => $settings['about_projects_count'].'+', 'label' => 'Projects completed'] : null,
        ]));
        $careersTitle = $homeCareers['title'] ?? 'Work with us';
        $careersText = $homeCareers['description'] ?? 'We are always glad to hear from engineers, foremen and skilled workers who take pride in their work.';
    @endphp

    <section class="rk-hero">
        <img class="rk-hero__image" src="/images/site/column-works-1600.webp" srcset="/images/site/column-works-800.webp 800w, /images/site/column-works-1600.webp 1600w" sizes="100vw" width="1600" height="1166" alt="Construction workers fixing steel reinforcement for concrete columns" fetchpriority="high">
        <div class="rk-container rk-hero__inner">
            <div class="rk-hero__copy">
                <p class="rk-kicker">Engineering · Design · Construction</p>
                <h1>Building design and construction <em>in Tagum City and across Mindanao</em></h1>
                <p class="rk-hero__lede">RubiKnows plans, engineers and builds houses, commercial buildings and civil works. Bring us in early and we will help you get the design, permits, budget and construction right.</p>
                <div class="rk-hero__actions">
                    <a class="rk-btn rk-btn--primary rk-btn--lg" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quotation</a>
                    <a class="rk-btn rk-btn--ghost rk-btn--lg" href="{{ route('public.services') }}">See our services</a>
                </div>
            </div>
            <dl class="rk-facts" data-preview="stats" @if(! $facts) hidden @endif>
                @foreach($facts as $fact)
                    <div><dt>{{ $fact['label'] }}</dt><dd>{{ $fact['value'] }}</dd></div>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="rk-section" aria-labelledby="services-title">
        <div class="rk-container">
            <div class="rk-section-head" data-reveal>
                <div class="rk-section-head__text">
                    <p class="rk-kicker">01 — Services</p>
                    <h2 id="services-title">What we do</h2>
                    <p>Hire us for the whole project, from plans to turnover, or for the part where you need an engineer.</p>
                </div>
                <a class="rk-arrow-link" href="{{ route('public.services') }}">All services</a>
            </div>

            @if($services->isNotEmpty())
                <div class="rk-service-grid" data-reveal-stagger>
                    @foreach($services as $service)
                        <article class="rk-service-card">
                            <p class="rk-service-card__tag"><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $service->category }}</p>
                            <h3><a href="{{ route('public.service-details', $service) }}">{{ $service->title }}</a></h3>
                            <p>{{ $service->short_description ?: Str::limit(strip_tags((string) $service->content), 140) }}</p>
                            <span class="rk-service-card__more" aria-hidden="true">Read more</span>
                        </article>
                    @endforeach
                </div>
            @else
                <x-public.empty-state title="Our service list is being updated" message="Call or message us and we will tell you how we can help with your project." />
            @endif
        </div>
    </section>

    <section class="rk-section rk-section--dark" aria-labelledby="process-title">
        <div class="rk-container">
            <div class="rk-section-head" data-reveal>
                <div class="rk-section-head__text">
                    <p class="rk-kicker">02 — Process</p>
                    <h2 id="process-title">How a project runs</h2>
                    <p>A clear sequence, so you always know what happens next and who is responsible for it.</p>
                </div>
            </div>
            @include('public.partials.process-steps')
        </div>
    </section>

    @if($featuredProjects->isNotEmpty())
        <section class="rk-section" aria-labelledby="projects-title">
            <div class="rk-container">
                <div class="rk-section-head" data-reveal>
                    <div class="rk-section-head__text">
                        <p class="rk-kicker">03 — Projects</p>
                        <h2 id="projects-title">Recent projects</h2>
                        <p>A selection of the work we have designed, built or managed.</p>
                    </div>
                    <a class="rk-arrow-link" href="{{ route('public.projects') }}">All projects</a>
                </div>
                <div class="rk-project-grid" data-reveal-stagger>
                    @foreach($featuredProjects as $project)
                        @include('public.partials.project-card', ['project' => $project])
                    @endforeach
                </div>
                @if($mapProjects->isNotEmpty())
                    <div class="rk-home-map">
                        <x-project-map :projects="$mapProjects" id="home-project-map" title="Where we have worked" />
                    </div>
                @endif
            </div>
        </section>
    @endif

    <section class="rk-section {{ $featuredProjects->isNotEmpty() ? 'rk-section--paper' : '' }}" aria-labelledby="about-title">
        <div class="rk-container rk-feature">
            <div class="rk-feature__media" data-reveal>
                <img src="/images/site/site-team-1600.webp" srcset="/images/site/site-team-800.webp 800w, /images/site/site-team-1600.webp 1600w" sizes="(min-width: 960px) 50vw, 100vw" width="1600" height="1066" alt="Engineers and site staff reviewing foundation work" loading="lazy">
            </div>
            <div class="rk-feature__text" data-reveal>
                <p class="rk-kicker">Company</p>
                <h2 id="about-title">Based in Tagum City</h2>
                <p>Our office is in Magugpo West, Tagum City, close to the sites we build on. You deal directly with the engineers responsible for your project, from the first meeting to turnover, and we stay reachable after the work is done.</p>
                <p>We are guided by faith, by honest work and by care for the families and communities who use what we build.</p>
                <a class="rk-arrow-link" href="{{ route('public.about') }}">More about RubiKnows</a>
            </div>
        </div>
    </section>

    @if($testimonial)
        <section class="rk-section" aria-label="What clients say">
            <div class="rk-container">
                <figure class="rk-quote" data-reveal>
                    <blockquote><p>{{ $testimonial->quote }}</p></blockquote>
                    <figcaption>
                        <strong>{{ $testimonial->client_name }}</strong>
                        @if($testimonial->role || $testimonial->company)<span>{{ collect([$testimonial->role, $testimonial->company])->filter()->join(', ') }}</span>@endif
                    </figcaption>
                </figure>
            </div>
        </section>
    @endif

    <section class="rk-section rk-section--tight" aria-labelledby="careers-title">
        <div class="rk-container">
            <div class="rk-hiring" data-reveal>
                <div>
                    <h2 id="careers-title" data-preview="careers-title">{{ $careersTitle }}</h2>
                    <p data-preview="careers-text">{{ $careersText }}</p>
                    @if($openJobs->isNotEmpty())
                        <ul class="rk-hiring__jobs">
                            @foreach($openJobs as $job)
                                <li><a href="{{ route('public.careers') }}#job-{{ $job->id }}">{{ $job->title }}</a>@if($job->location || $job->type)<span>{{ collect([$job->type, $job->location])->filter()->join(' · ') }}</span>@endif</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <a class="rk-btn rk-btn--dark" href="{{ route('public.careers') }}">{{ $openJobs->isNotEmpty() ? 'See open positions' : 'Send your application' }}</a>
            </div>
        </div>
    </section>

    <x-public.contact-band title="Planning a build?" />

    @if(request()->boolean('preview') && auth()->user()?->isAdmin())
        @push('scripts')
            <script nonce="{{ Vite::cspNonce() }}">
                // Live preview for the admin homepage editor (same-origin iframe only).
                window.addEventListener('message', function (event) {
                    if (event.origin !== window.location.origin || !event.data || event.data.type !== 'live-editor-update') return;
                    const data = event.data.data || {};
                    const stats = document.querySelector('[data-preview="stats"]');
                    if (stats && Array.isArray(data.stats)) {
                        stats.replaceChildren(...data.stats.filter(s => s && s.value && s.label).map(function (stat) {
                            const row = document.createElement('div');
                            const dt = document.createElement('dt');
                            const dd = document.createElement('dd');
                            dt.textContent = stat.label;
                            dd.textContent = stat.value;
                            row.append(dt, dd);
                            return row;
                        }));
                        stats.hidden = stats.children.length === 0;
                    }
                    if (data.careers) {
                        const title = document.querySelector('[data-preview="careers-title"]');
                        const text = document.querySelector('[data-preview="careers-text"]');
                        if (title && data.careers.title) title.textContent = data.careers.title;
                        if (text && data.careers.description) text.textContent = data.careers.description;
                    }
                });
            </script>
        @endpush
    @endif
</x-public-layout>
