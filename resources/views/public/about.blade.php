<x-public-layout>
    <x-slot name="title">About Us</x-slot>

    @php
        $settings = Cache::remember('site_settings', 3600, fn () => \App\Models\Setting::pluck('value', 'key')->toArray());
        $storyTitle = $settings['about_story_title'] ?? 'A people-first practice for work that has to endure.';
        $storyContent = $settings['about_story_content'] ?? '';
        if (trim(strip_tags($storyContent)) === '') {
            $storyContent = '<p>RubiKnows brings engineering, construction, and consultancy together around the needs of every project. We stay close to the work, communicate clearly, and keep client success in view from the earliest decisions through delivery.</p><p>Our team brings practical thinking to every stage: understanding the brief, coordinating the moving parts, and staying accountable until the work is ready to serve its purpose.</p>';
        }
    @endphp

    <x-public.page-intro eyebrow="About RubiKnows" number="01" title="People, precision, and work built to last." lede="We approach every commission as a partnership: technically rigorous, practical in delivery, and attentive to the people who will use what we make." />

    <section class="rk-section rk-about-story">
        <div class="rk-container rk-about-story__grid">
            <div class="rk-about-story__lead">
                <x-public.eyebrow>Our story</x-public.eyebrow>
                <h2>{{ $storyTitle }}</h2>
                <a class="rk-text-link" href="{{ route('public.contact') }}">Talk with our team</a>
            </div>
            <div class="rk-about-story__body rich-text">
                {!! $storyContent !!}
            </div>
            <div class="rk-about-metrics" aria-label="RubiKnows at a glance">
                <div><strong>{{ $settings['about_est_year'] ?? '2020' }}</strong><span>Established</span></div>
                <div><strong>{{ $settings['about_experience_years'] ?? '5' }}+</strong><span>Years of experience</span></div>
                <div><strong>{{ $settings['about_projects_count'] ?? '100' }}+</strong><span>Projects delivered</span></div>
            </div>
        </div>
    </section>

    <section class="rk-about-visual" aria-label="The work behind the work">
        <div class="rk-about-visual__image rk-about-visual__image--large">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=78&w=1600&auto=format&fit=crop" alt="Construction team working on a structure">
        </div>
        <div class="rk-about-visual__image rk-about-visual__image--small">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1541888081-3e4b1a4767e7?q=78&w=1000&auto=format&fit=crop" alt="Construction detail in progress">
        </div>
        <div class="rk-about-visual__caption">
            <x-public.eyebrow>In the field</x-public.eyebrow>
            <p>Good outcomes start with people who stay close to the details.</p>
        </div>
    </section>

    <section class="rk-section rk-section--paper">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>How we work</x-public.eyebrow>
                    <h2 class="rk-section__title">A connected team, from first idea to final handover.</h2>
                </div>
                <p class="rk-section__lede">The work is technical, but the way we work is human: clear conversations, shared accountability, and practical decisions made at the right time.</p>
            </div>
            <div class="rk-principle-grid">
                <article>
                    <span>01</span>
                    <h3>Listen closely.</h3>
                    <p>We begin with the brief, the site, and the people who will live with the result.</p>
                </article>
                <article>
                    <span>02</span>
                    <h3>Make it buildable.</h3>
                    <p>We turn design intent into decisions that teams, budgets, and schedules can carry.</p>
                </article>
                <article>
                    <span>03</span>
                    <h3>Stay accountable.</h3>
                    <p>We keep communication open and remain present through delivery and close-out.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="rk-section rk-about-faith">
        <div class="rk-container rk-editorial-copy">
            <div>
                <x-public.eyebrow>Our guiding principle</x-public.eyebrow>
                <h2 class="rk-editorial-copy__title">With God, all things are possible.</h2>
            </div>
            <div class="rk-editorial-copy__body">
                <p>Our work is shaped by faith, diligence, and a belief that meaningful projects are built through service to people and communities.</p>
                <p class="mt-8 text-sm font-bold uppercase tracking-[.16em] text-brand-500">Matthew 19:26</p>
            </div>
        </div>
    </section>

    <section class="rk-section rk-section--paper rk-about-team-section">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>The people behind the work</x-public.eyebrow>
                    <h2 class="rk-section__title">Leadership with both hands on the work.</h2>
                </div>
                <a class="rk-text-link" href="{{ route('public.careers') }}">Work with us</a>
            </div>
            <div class="rk-people-grid">
                <article class="rk-person-card" tabindex="0" aria-label="Ruvelyn S. Rubinos, Founder and Owner">
                    <div class="rk-person-card__portrait">
                        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=78&w=1000&auto=format&fit=crop" alt="Team members collaborating around a table">
                        <span>RSR</span>
                        <div class="rk-person-card__role-overlay" aria-hidden="true">
                            <span class="rk-person-card__role-kicker">What is your role?</span>
                            <strong>Founder / Owner</strong>
                            <span class="rk-person-card__role-name">Ruvelyn S. Rubinos</span>
                        </div>
                    </div>
                    <div class="rk-person-card__meta">
                        <span class="rk-person-card__number">01</span>
                        <div><h3>Ruvelyn S. Rubinos</h3><p>Founder / Owner</p></div>
                    </div>
                </article>
                <article class="rk-person-card" tabindex="0" aria-label="Kevin C. Rubinos, Founder and Owner">
                    <div class="rk-person-card__portrait">
                        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=78&w=1000&auto=format&fit=crop" alt="Construction team at work on site">
                        <span>KCR</span>
                        <div class="rk-person-card__role-overlay" aria-hidden="true">
                            <span class="rk-person-card__role-kicker">What is your role?</span>
                            <strong>Founder / Owner</strong>
                            <span class="rk-person-card__role-name">Kevin C. Rubinos</span>
                        </div>
                    </div>
                    <div class="rk-person-card__meta">
                        <span class="rk-person-card__number">02</span>
                        <div><h3>Kevin C. Rubinos</h3><p>Founder / Owner</p></div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</x-public-layout>
