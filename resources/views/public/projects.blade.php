<x-public-layout>
    <x-slot name="title">Our Projects</x-slot>

    <x-public.page-intro eyebrow="Project portfolio" number="02" title="Work with a clear point of view." lede="Explore the engineering and construction work our team has brought from plan to place." />

    <x-project-map :projects="$mapProjects" id="projects-map" />

    <section class="rk-section">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>Portfolio</x-public.eyebrow>
                    <h2 class="rk-section__title">Selected projects, grounded in place.</h2>
                    <p class="rk-section__lede">Each entry connects to its exact location on the map above when a CMS pin has been added.</p>
                </div>
            </div>
            <div class="rk-project-grid rk-portfolio-mosaic">
                @forelse($projects as $project)
                    <a class="rk-project-tile rk-mosaic-card" data-mosaic-index="{{ $loop->iteration }}" href="{{ route('public.project-details', $project) }}">
                        @if($project->cover_image_path)
                            <img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($project->cover_image_path) }}" alt="{{ $project->title }}">
                        @endif
                        <div class="rk-project-tile__copy">
                            <span class="rk-project-tile__category">{{ $project->category ?: 'Project' }}</span>
                            <h3>{{ $project->title }}</h3>
                            <p class="rk-project-tile__meta">{{ $project->location ?: 'Mindanao, Philippines' }} <b>/</b> View project ↗</p>
                        </div>
                    </a>
                @empty
                    <p class="rk-empty col-span-full">No projects have been published yet.</p>
                @endforelse
                <a class="rk-portfolio-mosaic__cta rk-project-mosaic__cta" href="{{ route('public.contact') }}">
                    <span class="rk-portfolio-mosaic__cta-kicker">RubiKnows / 07</span>
                    <strong>Start the<br>next build.</strong>
                    <span class="rk-portfolio-mosaic__cta-link">Discuss a project &rarr;</span>
                </a>
            </div>
            @if($projects->hasPages())
                <div class="mt-12 flex justify-center">{{ $projects->links('vendor.pagination.tailwind') }}</div>
            @endif
        </div>
    </section>

    <section class="rk-section rk-section--paper">
        <div class="rk-container rk-editorial-copy">
            <div>
                <x-public.eyebrow>Bring us in early</x-public.eyebrow>
                <h2 class="rk-editorial-copy__title">Have a project in mind?</h2>
            </div>
            <div class="rk-editorial-copy__body">
                <p>We can help turn the next important decision into a project with a clear path forward.</p>
                <x-public.action href="{{ route('public.contact') }}" class="mt-8">Discuss your project</x-public.action>
            </div>
        </div>
    </section>
</x-public-layout>
