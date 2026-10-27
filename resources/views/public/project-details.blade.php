<x-public-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>
    @php
        $cover = \App\Support\MediaUrl::for($project->cover_image_path);
        $images = is_array($project->gallery_images ?? null) ? $project->gallery_images : (json_decode((string) ($project->gallery_images ?? '[]'), true) ?: []);
        $status = $project->status === 'Featured' ? 'Completed' : $project->status;
        $specs = array_filter([
            'Category' => $project->category,
            'Location' => $project->location,
            'Year' => $project->year,
            'Client' => $project->client,
            'Duration' => $project->duration,
            'Contract value' => $project->value,
            'Status' => $status,
        ], fn ($value) => filled($value));
        $summary = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $project->description))), 155);
    @endphp
    <x-slot name="description">{{ $summary }}</x-slot>
    <x-slot name="image">{{ $cover }}</x-slot>

    <x-public.page-header :title="$project->title" :lede="collect([$project->location, $project->year])->filter()->join(' · ') ?: null" :breadcrumbs="['Projects' => route('public.projects'), $project->title => null]" />

    <section class="rk-section">
        <div class="rk-container">
            @if($cover)
                <img class="rk-project-cover" src="{{ $cover }}" alt="{{ $project->title }}" fetchpriority="high">
            @endif

            <div class="rk-detail-grid">
                <article class="rk-prose">
                    @if(trim((string) $project->description) !== '')
                        {{ \App\Support\Markdown::render($project->description) }}
                    @else
                        <p>A full write-up of this project is being prepared. Contact us if you would like to know more about it or about similar work.</p>
                    @endif

                    @if($images)
                        <h2>Photos</h2>
                        <div class="rk-photo-grid">
                            @foreach($images as $photo)
                                <a href="{{ \App\Support\MediaUrl::for($photo) }}" target="_blank" rel="noopener">
                                    <img src="{{ \App\Support\MediaUrl::for($photo) }}" alt="{{ $project->title }}, photo {{ $loop->iteration }}" loading="lazy" decoding="async">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </article>

                <aside class="rk-aside">
                    @if($specs)
                        <div class="rk-aside-card">
                            <h2>Project details</h2>
                            <dl class="rk-specs">
                                @foreach($specs as $label => $value)
                                    <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
                                @endforeach
                            </dl>
                        </div>
                    @endif
                    <div class="rk-aside-card">
                        <h2>Planning something similar?</h2>
                        <p>We can walk you through how a project like this is planned, priced and built.</p>
                        <a class="rk-btn rk-btn--primary rk-btn--block" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quotation</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if($moreProjects->isNotEmpty())
        <section class="rk-section rk-section--paper" aria-labelledby="more-projects">
            <div class="rk-container">
                <div class="rk-section-head">
                    <div class="rk-section-head__text"><h2 id="more-projects">More projects</h2></div>
                    <a class="rk-arrow-link" href="{{ route('public.projects') }}">All projects</a>
                </div>
                <div class="rk-project-grid">
                    @foreach($moreProjects as $other)
                        @include('public.partials.project-card', ['project' => $other])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-public-layout>
