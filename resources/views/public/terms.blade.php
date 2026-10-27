<x-public-layout>
    <x-slot name="title">Terms of use</x-slot>
    <x-slot name="description">The terms that apply when you use the RubiKnows website, request a quotation or send us files.</x-slot>

    @php
        $contact = \App\Support\ContactDetails::fromSettings();
        [$phone, $email] = [$contact->phone, $contact->email];
        $sections = [
            'about' => 'About these terms',
            'information' => 'Information on this website',
            'quotations' => 'Quotations',
            'submissions' => 'What you send us',
            'acceptable-use' => 'Acceptable use',
            'ownership' => 'Content and trademarks',
            'liability' => 'Liability',
            'law' => 'Governing law',
            'contact' => 'Contact us',
        ];
    @endphp

    <x-public.page-header title="Terms of use" lede="Last updated 27 October 2026" :breadcrumbs="['Terms of use' => null]" />

    <section class="rk-section">
        <div class="rk-container rk-legal">
            <nav class="rk-toc" aria-labelledby="toc-title">
                <h2 id="toc-title">On this page</h2>
                <ol>
                    @foreach($sections as $id => $label)
                        <li><a href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ol>
            </nav>

            <article class="rk-prose">
                <h2 id="about">About these terms</h2>
                <p>These terms apply to your use of the RubiKnows website. By using the site you agree to them. If you do not agree, please do not use the site.</p>

                <h2 id="information">Information on this website</h2>
                <p>We publish information about our company, services and projects for general guidance. It is not engineering or construction advice for your particular situation. Advice that you can rely on is given only after we have assessed your project and agreed the work with you in writing.</p>
                <p>We keep the site accurate and up to date, but we cannot guarantee that every detail is complete or current at all times.</p>

                <h2 id="quotations">Quotations</h2>
                <p>A quotation request sent through this website does not create a contract. Any figures we give before a site inspection are estimates and may change once we have seen the site and the plans. A contract exists only when both parties sign a written agreement.</p>

                <h2 id="submissions">What you send us</h2>
                <p>When you send a message, a quotation request or a job application, please make sure the information is accurate and that you have the right to share any files you attach. You keep ownership of your plans, photos and documents. You allow us to use them only to respond to your request, prepare a quotation or assess your application.</p>
                <p>Do not upload files that contain viruses or other harmful code, or content that is unlawful or that you do not have permission to share.</p>

                <h2 id="acceptable-use">Acceptable use</h2>
                <p>Do not use the website to send spam, to try to gain unauthorised access to any part of it, or in any way that disrupts the site or affects other people's use of it. We may block access from anyone who misuses the site.</p>

                <h2 id="ownership">Content and trademarks</h2>
                <p>The RubiKnows name and logo, and the text and design of this website, belong to RubiKnows. Some photographs are used under licence from their owners. Please do not copy or reuse our content without written permission.</p>

                <h2 id="liability">Liability</h2>
                <p>To the extent the law allows, we are not responsible for losses arising from the use of general information published on this website. Nothing in these terms limits any liability that cannot be limited under Philippine law.</p>

                <h2 id="law">Governing law</h2>
                <p>These terms are governed by the laws of the Republic of the Philippines.</p>
                <p>We may update these terms from time to time. The current version will always be on this page.</p>

                <h2 id="contact">Contact us</h2>
                <p>
                    Questions about these terms can be sent to us
                    @if($email) at <a href="mailto:{{ $email }}">{{ $email }}</a> @endif
                    @if($phone) or by phone at <a href="tel:{{ $contact->phoneHref }}">{{ $phone }}</a>@endif.
                    You can also read how we handle personal information in our <a href="{{ route('public.privacy') }}">privacy policy</a>.
                </p>
            </article>
        </div>
    </section>
</x-public-layout>
