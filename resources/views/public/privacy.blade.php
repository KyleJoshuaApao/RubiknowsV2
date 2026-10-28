<x-public-layout>
    <x-slot name="title">Privacy policy</x-slot>
    <x-slot name="description">How RUBIKNOWS collects, uses, shares and protects personal information submitted through this website, and your rights under the Data Privacy Act of 2012.</x-slot>

    @php
        $contact = \App\Support\ContactDetails::fromSettings();
        [$phone, $email, $address] = [$contact->phone, $contact->email, $contact->address];
        $sections = [
            'who-we-are' => 'Who we are',
            'what-we-collect' => 'Information we collect',
            'how-we-use' => 'How we use it',
            'sharing' => 'Who we share it with',
            'retention' => 'How long we keep it',
            'security' => 'How we protect it',
            'your-rights' => 'Your rights',
            'cookies' => 'Cookies',
            'changes' => 'Changes to this policy',
            'contact' => 'Contact us',
        ];
    @endphp

    <x-public.page-header title="Privacy policy" lede="Last updated 27 October 2026" :breadcrumbs="['Privacy policy' => null]" />

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
                <p>This policy explains what personal information RUBIKNOWS collects through this website, why we collect it, and how we look after it. We handle personal information in line with the Data Privacy Act of 2012 (Republic Act No. 10173) and its implementing rules.</p>

                <h2 id="who-we-are">Who we are</h2>
                <p>RUBIKNOWS is an engineering and construction company based in Tagum City, Davao del Norte{{ $address ? ' ('.$address.')' : '' }}. We decide how the information described in this policy is used, which makes us its personal information controller.</p>

                <h2 id="what-we-collect">Information we collect</h2>
                <p>We only collect what you choose to send us, plus basic technical information needed to run the site.</p>
                <ul>
                    <li><strong>Messages:</strong> your name, email address, subject and message, and optionally your mobile number and company.</li>
                    <li><strong>Quotation requests:</strong> your name and email address, optionally your mobile number and company, the service you need, the project location, budget, timeline and description, and any plans, sketches or photos you attach.</li>
                    <li><strong>Job applications:</strong> your name, email address, optional mobile number, the position you apply for, your message or cover letter, your resume or CV, and an optional portfolio.</li>
                    <li><strong>Technical information:</strong> your IP address, browser type and the pages you request, recorded in server logs and used to keep the site secure.</li>
                </ul>
                <p>Please do not send sensitive personal information, such as government ID numbers or health information, through the website forms.</p>

                <h2 id="how-we-use">How we use it</h2>
                <ul>
                    <li>To reply to your message and answer your questions.</li>
                    <li>To prepare quotations, arrange site visits and discuss your project with you.</li>
                    <li>To assess job applications and contact applicants about interviews.</li>
                    <li>To keep the website secure and to block spam and misuse.</li>
                </ul>
                <p>We do not sell your information, and we do not use it for advertising. We will only send you marketing messages if you have asked us to.</p>

                <h2 id="sharing">Who we share it with</h2>
                <p>Your information is seen only by the RUBIKNOWS staff who need it to respond to you. We also use a small number of service providers who process information on our behalf and only on our instructions:</p>
                <ul>
                    <li><strong>Render</strong>, which hosts this website.</li>
                    <li><strong>Supabase</strong>, which stores the website database and uploaded files.</li>
                    <li><strong>Resend</strong>, which delivers the email notifications the website sends.</li>
                </ul>
                <p>These providers run servers outside the Philippines, so your information may be stored or processed abroad. We use providers that protect information with encryption and access controls.</p>
                <p>Some pages load map tiles from OpenStreetMap and fonts from Bunny Fonts. Your browser connects to these services directly, so they receive your IP address. We may also disclose information when the law requires it.</p>

                <h2 id="retention">How long we keep it</h2>
                <ul>
                    <li>Messages and quotation requests: up to three years after our last contact with you, so we can follow up on projects and keep business records.</li>
                    <li>Job applications: up to one year after the position is filled, unless you ask us to delete your application earlier.</li>
                    <li>Server logs: up to 30 days.</li>
                </ul>
                <p>When information is no longer needed, we delete it.</p>

                <h2 id="security">How we protect it</h2>
                <p>The website uses an encrypted (HTTPS) connection. Resumes, portfolios and quotation attachments are stored privately and can only be opened by signed-in staff. Staff accounts are personal, and only administrators can view submissions.</p>

                <h2 id="your-rights">Your rights</h2>
                <p>Under the Data Privacy Act you have the right to:</p>
                <ul>
                    <li>be informed about how your personal information is used;</li>
                    <li>access the personal information we hold about you;</li>
                    <li>object to its processing;</li>
                    <li>have it corrected if it is inaccurate;</li>
                    <li>have it deleted or blocked when it is no longer needed or was processed unlawfully;</li>
                    <li>receive a copy in a commonly used electronic format;</li>
                    <li>be compensated for damages caused by inaccurate or unauthorised use; and</li>
                    <li>file a complaint with the National Privacy Commission (<a href="https://privacy.gov.ph" rel="noopener" target="_blank">privacy.gov.ph</a>).</li>
                </ul>
                <p>To use any of these rights, contact us using the details below. We will respond as soon as we can and within the period the law requires.</p>

                <h2 id="cookies">Cookies</h2>
                <p>The website sets only the cookies it needs to work: a session cookie and a security token that protects the forms. We do not use analytics, advertising or tracking cookies.</p>

                <h2 id="changes">Changes to this policy</h2>
                <p>If we change this policy, we will post the new version on this page with a new date.</p>

                <h2 id="contact">Contact us</h2>
                <p>For questions about this policy or your personal information, contact us:</p>
                <ul>
                    @if($email)<li>Email: <a href="mailto:{{ $email }}">{{ $email }}</a></li>@endif
                    @if($phone)<li>Phone: <a href="tel:{{ $contact->phoneHref }}">{{ $phone }}</a></li>@endif
                    @if($address)<li>Office: {{ $address }}</li>@endif
                </ul>
            </article>
        </div>
    </section>
</x-public-layout>
