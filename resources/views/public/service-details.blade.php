<x-public-layout>
    <x-slot name="title">{{ $service->title }}</x-slot>
    <x-slot name="description">{{ $service->short_description }}</x-slot>
    @php
        $image = \App\Support\MediaUrl::for($service->image_path);
        $contact = \App\Support\ContactDetails::fromSettings();
        $features = is_string($service->features ?? null) ? preg_split('/\r?\n/', $service->features) : (array) ($service->features ?? []);
        $features = array_values(array_filter(array_map('trim', $features)));
    @endphp
    <x-slot name="image">{{ $image }}</x-slot>

    <x-public.page-header :title="$service->title" :lede="$service->short_description" :breadcrumbs="['Services' => route('public.services'), $service->title => null]" />

    <section class="rk-section">
        <div class="rk-container rk-detail-grid">
            <article>
                @if($image)
                    <img class="rk-detail-image" src="{{ $image }}" alt="" width="1600" height="1000">
                @endif
                <div class="rk-prose">
                    @if(trim((string) $service->content) !== '')
                        {{ \App\Support\Markdown::render($service->content) }}
                    @else
                        <p>We tailor this service to each project. Contact us and we will explain how we can help with yours.</p>
                    @endif

                    @if($features)
                        <h2>What this can include</h2>
                        <ul>
                            @foreach($features as $feature)<li>{{ $feature }}</li>@endforeach
                        </ul>
                    @endif
                </div>
            </article>

            <aside class="rk-aside">
                <div class="rk-aside-card">
                    <h2>Get a quotation</h2>
                    <p>Tell us about your project and we will reply with the next steps for {{ Str::lower($service->title) }}.</p>
                    <a class="rk-btn rk-btn--primary rk-btn--block" href="{{ route('public.contact', ['tab' => 'quote', 'service' => $service->title]) }}">Request a quotation</a>
                    @if($contact->phone)
                        <a class="rk-btn rk-btn--outline rk-btn--block" href="tel:{{ $contact->phoneHref }}">Call {{ $contact->phone }}</a>
                    @endif
                </div>

                @if($otherServices->isNotEmpty())
                    <nav class="rk-aside-links" aria-labelledby="other-services">
                        <h2 id="other-services">Other services</h2>
                        <ul>
                            @foreach($otherServices as $other)
                                <li><a href="{{ route('public.service-details', $other) }}">{{ $other->title }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                @endif
            </aside>
        </div>
    </section>

    <x-public.contact-band />
</x-public-layout>
