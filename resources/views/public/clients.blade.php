<x-public-layout>
    <x-slot name="title">Clients and partners</x-slot>
    <x-slot name="description">Clients, partners and sponsors who have worked with RubiKnows.</x-slot>

    <x-public.page-header title="Clients and partners" lede="Organisations that have trusted us with their projects, and the partners we work alongside." :breadcrumbs="['Clients and partners' => null]" />

    @php
        $groups = array_filter([
            'Clients' => $clients,
            'Partners' => $partners,
            'Sponsors' => $sponsors,
        ], fn ($group) => $group->isNotEmpty());
    @endphp

    <section class="rk-section">
        <div class="rk-container">
            @forelse($groups as $label => $group)
                <div class="rk-logo-group">
                    <h2>{{ $label }}</h2>
                    <ul class="rk-logo-grid">
                        @foreach($group as $client)
                            <li class="rk-logo-tile">
                                @if($client->logo_path)
                                    <img src="{{ \App\Support\MediaUrl::for($client->logo_path) }}" alt="{{ $client->name }}" loading="lazy">
                                @else
                                    <span>{{ $client->name }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @if($label === 'Clients')
                        {{ $clients->links('vendor.pagination.public') }}
                    @endif
                </div>
            @empty
                <x-public.empty-state title="No clients listed yet" message="Ask us for references from past clients and partners." />
            @endforelse
        </div>
    </section>

    <x-public.contact-band />
</x-public-layout>
