<x-public-layout>
    <x-slot name="title">Clients & Partners</x-slot>

    <x-public.page-intro eyebrow="Our network" number="05" title="Built with trusted collaborators." lede="We value the organizations and people who invite RubiKnows into important work." />

    <section class="rk-section">
        <div class="rk-container">
            <div class="rk-section__head">
                <div class="rk-section__head-copy">
                    <x-public.eyebrow>Clients</x-public.eyebrow>
                    <h2 class="rk-section__title">Organizations we are proud to work alongside.</h2>
                </div>
            </div>
            <div class="rk-logo-grid">
                @forelse($clients as $client)
                    <article class="rk-logo-tile">
                        @if($client->logo_path)
                            <img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($client->logo_path) }}" alt="{{ $client->name }}">
                        @else
                            <span>{{ $client->name }}</span>
                        @endif
                    </article>
                @empty
                    <p class="rk-empty col-span-full">No clients have been added yet.</p>
                @endforelse
            </div>
            @if($clients->hasPages())
                <div class="mt-12 flex justify-center">{{ $clients->links('vendor.pagination.tailwind') }}</div>
            @endif
        </div>
    </section>

    @if($partners->isNotEmpty() || $sponsors->isNotEmpty())
        <section class="rk-section rk-section--paper">
            <div class="rk-container">
                @if($partners->isNotEmpty())
                    <div class="rk-section__head">
                        <div class="rk-section__head-copy"><x-public.eyebrow>Partners</x-public.eyebrow><h2 class="rk-section__title">Long-term collaboration, shared standards.</h2></div>
                    </div>
                    <div class="rk-logo-grid">
                        @foreach($partners as $partner)
                            <article class="rk-logo-tile">
                                @if($partner->logo_path)<img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($partner->logo_path) }}" alt="{{ $partner->name }}">@else<span>{{ $partner->name }}</span>@endif
                            </article>
                        @endforeach
                    </div>
                @endif

                @if($sponsors->isNotEmpty())
                    <div class="mt-20">
                        <div class="rk-section__head"><div class="rk-section__head-copy"><x-public.eyebrow>Sponsors</x-public.eyebrow><h2 class="rk-section__title">Support that helps work move forward.</h2></div></div>
                        <div class="rk-logo-grid">
                            @foreach($sponsors as $sponsor)
                                <article class="rk-logo-tile">
                                    @if($sponsor->logo_path)<img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($sponsor->logo_path) }}" alt="{{ $sponsor->name }}">@else<span>{{ $sponsor->name }}</span>@endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
</x-public-layout>
