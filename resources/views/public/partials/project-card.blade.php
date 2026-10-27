@php($cover = \App\Support\MediaUrl::for($project->cover_image_path))
<article class="rk-project-card">
    <div class="rk-project-card__media">
        @if($cover)
            <img src="{{ $cover }}" alt="" loading="lazy" decoding="async">
        @endif
    </div>
    <div class="rk-project-card__body">
        @if($project->category)<p class="rk-project-card__tag">{{ $project->category }}</p>@endif
        <h3><a href="{{ route('public.project-details', $project) }}">{{ $project->title }}</a></h3>
        <p class="rk-project-card__meta">{{ collect([$project->location, $project->year])->filter()->join(' · ') }}</p>
    </div>
</article>
