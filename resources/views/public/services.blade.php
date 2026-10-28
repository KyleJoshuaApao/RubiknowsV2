<x-public-layout>
    <x-slot name="title">Services</x-slot>
    <x-slot name="description">Structural engineering, design and planning, general construction, site development, project management and technical consultancy from RUBIKNOWS in Tagum City, Davao del Norte.</x-slot>

    <x-public.page-header title="Services" lede="Engineering, design and construction under one roof. Hire us for the whole project or for the part where you need help." :breadcrumbs="['Services' => null]" />

    <section class="rk-section" aria-label="Service list">
        <div class="rk-container">
            @if($services->isNotEmpty())
                <ul class="rk-service-list" data-reveal-stagger>
                    @foreach($services as $service)
                        <li class="rk-service-row">
                            <div>
                                @if($service->category)<p class="rk-service-card__tag">{{ $service->category }}</p>@endif
                                <h2><a href="{{ route('public.service-details', $service) }}">{{ $service->title }}</a></h2>
                            </div>
                            <p>{{ $service->short_description ?: Str::limit(strip_tags((string) $service->content), 200) }}</p>
                            <a class="rk-arrow-link" href="{{ route('public.service-details', $service) }}" aria-label="Read more about {{ $service->title }}">Read more</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-public.empty-state title="Our service list is being updated" message="Call or message us and we will tell you how we can help with your project.">
                    <a class="rk-btn rk-btn--primary" href="{{ route('public.contact') }}">Contact us</a>
                </x-public.empty-state>
            @endif
        </div>
    </section>

    <section class="rk-section rk-section--paper" aria-labelledby="process-title">
        <div class="rk-container">
            <div class="rk-section-head" data-reveal>
                <div class="rk-section-head__text">
                    <h2 id="process-title">How a project runs</h2>
                    <p>Whatever the service, the work follows the same clear sequence.</p>
                </div>
            </div>
            @include('public.partials.process-steps')
        </div>
    </section>

    <section class="rk-section" aria-labelledby="unsure-title">
        <div class="rk-container rk-split rk-split--center">
            <h2 id="unsure-title">Not sure which service you need?</h2>
            <div class="rk-prose">
                <p>Most clients come to us with a lot, a sketch, or an existing building and a question. That is enough to start. Tell us what you have and what you want to achieve, and we will recommend the right next step, whether that is a site visit, a structural assessment or a full design-and-build package.</p>
            </div>
        </div>
    </section>

    <x-public.contact-band />
</x-public-layout>
