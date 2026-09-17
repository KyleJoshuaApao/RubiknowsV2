<x-public-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>

    <section class="rk-detail-hero">
        @if($project->cover_image_path)
            <img class="rk-detail-hero__image" src="{{ \App\Support\MediaUrl::for($project->cover_image_path) }}" alt="{{ $project->title }}" fetchpriority="high" decoding="async">
        @endif
        <div class="rk-detail-hero__inner">
            <a class="rk-back-link" href="{{ route('public.projects') }}">← All projects</a>
            <h1>{{ $project->title }}</h1>
            <div class="rk-detail-meta">
                @if($project->category)<span><b>Category</b>{{ $project->category }}</span>@endif
                @if($project->location)<span><b>Location</b>{{ $project->location }}</span>@endif
                @if($project->status)<span><b>Status</b>{{ $project->status === 'Featured' ? 'Completed' : $project->status }}</span>@endif
                @if($project->completion_date)<span><b>Completed</b>{{ \Carbon\Carbon::parse($project->completion_date)->format('F Y') }}</span>@endif
            </div>
        </div>
    </section>

    <section class="rk-section">
        <div class="rk-container rk-detail-layout">
            <article class="rk-rich-copy rich-text">
                @if($project->content)
                    {!! $project->content !!}
                @else
                    <p>Project details will be shared here soon. Contact RubiKnows to discuss related work or a similar brief.</p>
                @endif

                @php($images = is_array($project->gallery_images) ? $project->gallery_images : json_decode($project->gallery_images ?? '[]', true))
                @if(!empty($images))
                    <div class="rk-detail-gallery">
                        @foreach($images as $image)
                            <a href="{{ \App\Support\MediaUrl::for($image) }}" target="_blank" rel="noopener" aria-label="Open project image in a new tab">
                                <img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($image) }}" alt="{{ $project->title }} project gallery image">
                            </a>
                        @endforeach
                    </div>
                @endif
            </article>

            <aside class="rk-detail-aside">
                <h2>Project details</h2>
                <dl>
                    @if($project->client_name)<div><dt>Client</dt><dd>{{ $project->client_name }}</dd></div>@endif
                    @if($project->category)<div><dt>Category</dt><dd>{{ $project->category }}</dd></div>@endif
                    @if($project->location)<div><dt>Location</dt><dd>{{ $project->location }}</dd></div>@endif
                    @if($project->status)<div><dt>Status</dt><dd>{{ $project->status === 'Featured' ? 'Completed' : $project->status }}</dd></div>@endif
                </dl>
                <x-public.action href="{{ route('public.contact', ['subject' => 'Inquiry regarding project: ' . $project->title]) }}" class="mt-8 w-full">Discuss similar work</x-public.action>
            </aside>
        </div>
    </section>
</x-public-layout>
