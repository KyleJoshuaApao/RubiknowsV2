<x-public-layout>
    <x-slot name="title">Projects</x-slot>
    <x-slot name="description">Projects designed, built and managed by RUBIKNOWS, an engineering and construction company in Tagum City, Davao del Norte.</x-slot>

    <x-public.page-header title="Projects" lede="Work we have designed, built or managed for clients in Davao del Norte and across Mindanao." :breadcrumbs="['Projects' => null]" />

    <section class="rk-section">
        <div class="rk-container">
            @if($categories->count() > 1)
                <nav aria-label="Filter projects by category">
                    <ul class="rk-filter">
                        <li><a href="{{ route('public.projects') }}" @if(! $category) aria-current="true" @endif>All projects</a></li>
                        @foreach($categories as $option)
                            <li><a href="{{ route('public.projects', ['category' => $option]) }}" @if($category === $option) aria-current="true" @endif>{{ $option }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            @endif

            @if($projects->isNotEmpty())
                <div class="rk-project-grid" data-reveal-stagger>
                    @foreach($projects as $project)
                        @include('public.partials.project-card', ['project' => $project])
                    @endforeach
                </div>
                {{ $projects->links('vendor.pagination.public') }}
            @else
                <x-public.empty-state title="Project write-ups are on the way" message="We are preparing case studies of recent work. In the meantime, ask us for references or examples of projects similar to yours.">
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact') }}">Ask about our work</a>
                    <a class="rk-btn rk-btn--outline" href="{{ route('public.services') }}">See our services</a>
                </x-public.empty-state>
            @endif

            @if($mapProjects->isNotEmpty() && ! $category)
                <div class="rk-projects-map">
                    <x-project-map :projects="$mapProjects" id="projects-map" />
                </div>
            @endif
        </div>
    </section>

    <x-public.contact-band title="Have a project in mind?" />
</x-public-layout>
