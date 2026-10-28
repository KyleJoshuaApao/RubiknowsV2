@props([
    'title' => 'Tell us about your project',
    'text' => 'Send us your plans, a sketch or a short description of the work. We will get back to you to arrange a call or a site visit.',
])

@php($contact = \App\Support\ContactDetails::fromSettings())

<section class="rk-cta" aria-labelledby="rk-cta-title">
    <div class="rk-container rk-cta__grid" data-reveal>
        <div>
            <h2 id="rk-cta-title">{{ $title }}</h2>
            <p>{{ $text }}</p>
            <div class="rk-cta__actions">
                <a class="rk-btn rk-btn--primary" href="{{ route('public.contact', ['tab' => 'quote']) }}">Request a quotation</a>
                <a class="rk-btn rk-btn--ghost" href="{{ route('public.contact') }}">Send a message</a>
            </div>
        </div>
        <dl class="rk-cta__details">
            @if($contact->phone)
                <div><dt>Call or text</dt><dd><a href="tel:{{ $contact->phoneHref }}">{{ $contact->phone }}</a></dd></div>
            @endif
            @if($contact->email)
                <div><dt>Email</dt><dd><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></dd></div>
            @endif
            @if($contact->address)
                <div><dt>Office</dt><dd>{{ $contact->address }}</dd></div>
            @endif
        </dl>
    </div>
</section>
