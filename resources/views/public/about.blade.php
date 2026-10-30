<x-public-layout>
    <x-slot name="title">About us</x-slot>

    @php
        $settings = \App\Models\Setting::allCached();
        $established = $settings['about_est_year'] ?? '2020';
        $storyTitle = trim((string) ($settings['about_story_title'] ?? '')) ?: 'Who we are';
        $storyContent = (string) ($settings['about_story_content'] ?? '');
        if (trim(strip_tags($storyContent)) === '') {
            $storyContent = '<p>RUBIKNOWS was started in '.e($established).' by Ruvelyn S. Rubinos and Kevin C. Rubinos to give property owners in Davao del Norte one team they can rely on for engineering and construction.</p>'
                .'<p>We design structures, prepare plans and estimates, build, and manage projects for clients who want their work done properly and explained clearly. Our office is in Magugpo West, Tagum City, and our projects take us across Mindanao.</p>'
                .'<p>We keep our promises specific: an honest estimate, regular updates, and a site that is run safely and to plan.</p>';
        }
        $leaders = [
            ['name' => 'Ruvelyn S. Rubinos', 'initials' => 'RSR', 'role' => 'Founder and Owner'],
            ['name' => 'Kevin C. Rubinos', 'initials' => 'KCR', 'role' => 'Founder and Owner'],
        ];
    @endphp

    <x-slot name="description">RUBIKNOWS is an engineering and construction company in Tagum City, Davao del Norte, started in {{ $established }}.</x-slot>

    <x-public.page-header tone="light" title="About RUBIKNOWS" lede="An engineering and construction company in Tagum City, started in {{ $established }}." :breadcrumbs="['About' => null]" />

    <div class="rk-container">
        <img class="rk-wide-image" src="/images/site/rebar-deck-1600.webp" srcset="/images/site/rebar-deck-800.webp 800w, /images/site/rebar-deck-1600.webp 1600w" sizes="(min-width: 1240px) 1200px, 100vw" width="1600" height="1060" alt="Site crew placing steel reinforcement on a concrete deck">
    </div>

    <section class="rk-section" aria-labelledby="story-title">
        <div class="rk-container rk-split">
            <div>
                <h2 id="story-title">{{ $storyTitle }}</h2>
            </div>
            <div class="rk-prose">
                {!! \App\Support\SafeHtml::clean($storyContent) !!}
            </div>
        </div>
    </section>

    <section class="rk-section" aria-labelledby="values-title">
        <div class="rk-container">
            <div class="rk-section-head" data-reveal>
                <div class="rk-section-head__text">
                    <h2 id="values-title">How we work</h2>
                </div>
            </div>
            <div class="rk-values" data-reveal-stagger>
                <div>
                    <h3>Straight answers</h3>
                    <p>We tell you what your project needs, what it will cost and how long it will take, even when the answer is not the one you hoped for.</p>
                </div>
                <div>
                    <h3>Work done to plan</h3>
                    <p>We build what was designed and approved. Changes are discussed, priced and agreed with you before they happen.</p>
                </div>
                <div>
                    <h3>Safety and care on site</h3>
                    <p>We keep sites orderly and safe for our workers, your neighbours and everyone who will use the building.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="rk-section rk-section--paper" aria-labelledby="faith-title">
        <div class="rk-container rk-split rk-split--center">
            <h2 id="faith-title">What guides us</h2>
            <figure class="rk-verse" data-reveal>
                <blockquote><p>“With God, all things are possible.”</p></blockquote>
                <figcaption>Matthew 19:26</figcaption>
                <p>Our faith shapes how we work and how we treat the people we build for.</p>
            </figure>
        </div>
    </section>

    <section class="rk-section" aria-labelledby="leaders-title">
        <div class="rk-container">
            <div class="rk-section-head" data-reveal>
                <div class="rk-section-head__text">
                    <h2 id="leaders-title">Leadership</h2>
                    <p>The two founders run the company and stay involved in every project.</p>
                </div>
            </div>
            <ul class="rk-people" data-reveal-stagger>
                @foreach($leaders as $leader)
                    <li class="rk-person">
                        <span class="rk-person__initials" aria-hidden="true">{{ $leader['initials'] }}</span>
                        <div>
                            <h3>{{ $leader['name'] }}</h3>
                            <p>{{ $leader['role'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @if($testimonial)
        <section class="rk-section rk-section--paper" aria-label="What clients say">
            <div class="rk-container">
                <figure class="rk-quote">
                    <blockquote><p>{{ $testimonial->quote }}</p></blockquote>
                    <figcaption>
                        <strong>{{ $testimonial->client_name }}</strong>
                        @if($testimonial->role || $testimonial->company)<span>{{ collect([$testimonial->role, $testimonial->company])->filter()->join(', ') }}</span>@endif
                    </figcaption>
                </figure>
            </div>
        </section>
    @endif

    <x-public.contact-band title="Talk to the team" />
</x-public-layout>
