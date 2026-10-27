<x-public-layout>
    <x-slot name="title">About us</x-slot>

    @php
        $settings = \App\Models\Setting::allCached();
        $established = $settings['about_est_year'] ?? '2020';
        $storyTitle = trim((string) ($settings['about_story_title'] ?? '')) ?: 'Who we are';
        $storyContent = (string) ($settings['about_story_content'] ?? '');
        if (trim(strip_tags($storyContent)) === '') {
            $storyContent = '<p>RubiKnows was started in '.e($established).' by Ruvelyn S. Rubinos and Kevin C. Rubinos to give property owners in Davao del Norte one team they can rely on for engineering and construction.</p>'
                .'<p>We design structures, prepare plans and estimates, build, and manage projects for clients who want their work done properly and explained clearly. Our office is in Magugpo West, Tagum City, and our projects take us across Mindanao.</p>'
                .'<p>We keep our promises specific: an honest estimate, regular updates, and a site that is run safely and to plan.</p>';
        }
        $facts = array_values(array_filter([
            filled($established) ? ['value' => $established, 'label' => 'Established'] : null,
            filled($settings['about_experience_years'] ?? null) ? ['value' => $settings['about_experience_years'].'+', 'label' => 'Years in practice'] : null,
            filled($settings['about_projects_count'] ?? null) ? ['value' => $settings['about_projects_count'].'+', 'label' => 'Projects completed'] : null,
        ]));
        $leaders = [
            ['name' => 'Ruvelyn S. Rubinos', 'initials' => 'RSR', 'role' => 'Founder and Owner'],
            ['name' => 'Kevin C. Rubinos', 'initials' => 'KCR', 'role' => 'Founder and Owner'],
        ];
    @endphp

    <x-slot name="description">RubiKnows is an engineering and construction company in Tagum City, Davao del Norte, working with homeowners, businesses and institutions since {{ $established }}.</x-slot>

    <x-public.page-header title="About RubiKnows" lede="An engineering and construction company in Tagum City, Davao del Norte, working with homeowners, businesses and institutions since {{ $established }}." :breadcrumbs="['About' => null]" />

    <section class="rk-section" aria-labelledby="story-title">
        <div class="rk-container rk-split">
            <div>
                <h2 id="story-title">{{ $storyTitle }}</h2>
                @if($facts)
                    <dl class="rk-facts rk-facts--stacked">
                        @foreach($facts as $fact)
                            <div><dt>{{ $fact['label'] }}</dt><dd>{{ $fact['value'] }}</dd></div>
                        @endforeach
                    </dl>
                @endif
            </div>
            <div class="rk-prose">
                {!! \App\Support\SafeHtml::clean($storyContent) !!}
            </div>
        </div>
    </section>

    <div class="rk-container">
        <img class="rk-wide-image" src="/images/site/rebar-deck-1600.webp" srcset="/images/site/rebar-deck-800.webp 800w, /images/site/rebar-deck-1600.webp 1600w" sizes="(min-width: 1240px) 1200px, 100vw" width="1600" height="1060" alt="Site crew placing steel reinforcement on a concrete deck" loading="lazy">
    </div>

    <section class="rk-section" aria-labelledby="values-title">
        <div class="rk-container">
            <div class="rk-section-head">
                <div class="rk-section-head__text">
                    <h2 id="values-title">How we work</h2>
                    <p>Three habits we hold ourselves to on every job, large or small.</p>
                </div>
            </div>
            <div class="rk-values">
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
            <figure class="rk-verse">
                <blockquote><p>“With God, all things are possible.”</p></blockquote>
                <figcaption>Matthew 19:26</figcaption>
                <p>Our work is shaped by faith, diligence and a belief that good buildings come from serving the people and communities who use them.</p>
            </figure>
        </div>
    </section>

    <section class="rk-section" aria-labelledby="leaders-title">
        <div class="rk-container">
            <div class="rk-section-head">
                <div class="rk-section-head__text">
                    <h2 id="leaders-title">Leadership</h2>
                    <p>RubiKnows is owner-managed. The founders stay involved in every project, from the first estimate to turnover.</p>
                </div>
            </div>
            <ul class="rk-people">
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

    <x-public.contact-band title="Talk to the team" text="Tell us about the project you have in mind. We will arrange a call or a site visit and give you an honest view of what it will take." />
</x-public-layout>
