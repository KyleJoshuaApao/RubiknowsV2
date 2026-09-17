<x-public-layout>
    <x-slot name="title">Testimonials</x-slot>

    <x-public.page-intro eyebrow="Client perspective" number="06" title="The work is remembered by the people it serves." lede="A few words from clients and collaborators who have trusted RubiKnows with their projects." />

    <section class="rk-section rk-section--paper">
        <div class="rk-container">
            <div class="rk-testimonial-grid">
                @forelse($testimonials as $testimonial)
                    <article class="rk-testimonial-card">
                        <span class="rk-testimonial-card__quote" aria-hidden="true">“</span>
                        <p class="rk-testimonial-card__body">{{ $testimonial->quote }}</p>
                        <div class="rk-testimonial-card__person">
                            @if($testimonial->avatar_path)
                                <img loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($testimonial->avatar_path) }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <span class="rk-avatar">{{ strtoupper(substr($testimonial->client_name, 0, 1)) }}</span>
                            @endif
                            <div>
                                <p class="rk-testimonial-card__name">{{ $testimonial->client_name }}</p>
                                <p class="rk-testimonial-card__role">{{ collect([$testimonial->role, $testimonial->company])->filter()->join(' · ') }}</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="rk-empty col-span-full">No testimonials have been added yet.</p>
                @endforelse
            </div>
            @if($testimonials->hasPages())
                <div class="mt-12 flex justify-center">{{ $testimonials->links('vendor.pagination.tailwind') }}</div>
            @endif
        </div>
    </section>
</x-public-layout>
