<x-public-layout>
    <x-slot name="title">About Us</x-slot>

    @php
        $settings = Cache::remember('site_settings', 3600, fn () => \App\Models\Setting::pluck('value', 'key')->toArray());
        $storyTitle = $settings['about_story_title'] ?? 'A people-first practice for work that has to endure.';
        $storyContent = $settings['about_story_content'] ?? '<p>RubiKnows brings engineering, construction, and consultancy together around the needs of every project. We stay close to the work, communicate clearly, and keep client success in view from the earliest decisions through delivery.</p>';
    @endphp

    <x-public.page-intro eyebrow="About RubiKnows" number="01" title="Work with purpose. Build with care." lede="We approach every commission as a partnership: technically rigorous, practical in delivery, and attentive to the people who will use what we make." />

    <section class="rk-section">
        <div class="rk-container rk-editorial-copy">
            <div>
                <x-public.eyebrow>Our story</x-public.eyebrow>
                <h2 class="rk-editorial-copy__title">{{ $storyTitle }}</h2>
            </div>
            <div class="rk-editorial-copy__body rich-text">
                {!! $storyContent !!}
                <a class="rk-text-link mt-8" href="{{ route('public.contact') }}">Talk with our team</a>
            </div>
        </div>
    </section>

    <section class="rk-section rk-section--paper">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>How we work</x-public.eyebrow>
                    <h2 class="rk-section__title">The people and principles behind every project.</h2>
                </div>
            </div>
            <div class="rk-feature-grid">
                <article class="rk-feature-card">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=75&w=1200&auto=format&fit=crop" alt="RubiKnows team collaboration">
                    <div class="rk-feature-card__copy">
                        <x-public.eyebrow>People</x-public.eyebrow>
                        <h3>Collaborative from the ground up.</h3>
                        <p>We bring a connected team to the table so technical decisions stay clear and projects keep moving.</p>
                    </div>
                </article>
                <article class="rk-feature-card">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1541888081-3e4b1a4767e7?q=75&w=1400&auto=format&fit=crop" alt="Engineering work in progress">
                    <div class="rk-feature-card__copy">
                        <x-public.eyebrow>Approach</x-public.eyebrow>
                        <h3>Thoughtful work, made practical.</h3>
                        <p>We balance ambition with the details that determine whether a project can be delivered well.</p>
                    </div>
                </article>
                <article class="rk-feature-card">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=75&w=1200&auto=format&fit=crop" alt="Construction team at work">
                    <div class="rk-feature-card__copy">
                        <x-public.eyebrow>Partnership</x-public.eyebrow>
                        <h3>Committed to the work and the outcome.</h3>
                        <p>Clients work with a team that remains accountable through the final handover.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="rk-section rk-section--ink">
        <div class="rk-container rk-editorial-copy">
            <div>
                <x-public.eyebrow>Our guiding principle</x-public.eyebrow>
                <h2 class="rk-editorial-copy__title text-white">With God, all things are possible.</h2>
            </div>
            <div class="rk-editorial-copy__body text-white/75">
                <p>Our work is shaped by faith, diligence, and a belief that meaningful projects are built through service to people and communities.</p>
                <p class="mt-8 text-sm font-bold uppercase tracking-[.16em] text-brand-500">Matthew 19:26</p>
            </div>
        </div>
    </section>

    <section class="rk-section">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>Leadership</x-public.eyebrow>
                    <h2 class="rk-section__title">The people guiding our direction.</h2>
                </div>
                <a class="rk-text-link" href="{{ route('public.careers') }}">Work with us</a>
            </div>
            <div class="rk-numbered-list">
                <article class="rk-numbered-list__item">
                    <span class="rk-numbered-list__number">01</span>
                    <h3>Ruvelyn S. Rubinos</h3>
                    <p>Founder / Owner</p>
                </article>
                <article class="rk-numbered-list__item">
                    <span class="rk-numbered-list__number">02</span>
                    <h3>Kevin C. Rubinos</h3>
                    <p>Founder / Owner</p>
                </article>
            </div>
        </div>
    </section>
</x-public-layout>
