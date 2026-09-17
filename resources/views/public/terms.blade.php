<x-public-layout>
    <x-slot name="title">Terms of Service</x-slot>

    <x-public.page-intro eyebrow="Legal" number="10" title="Terms of service" lede="Last updated: {{ now()->format('F j, Y') }}" />

    <section class="rk-section">
        <article class="rk-container rk-rich-copy rich-text">
            <p>Welcome to RubiKnows. These Terms of Service govern your use of our website and services. By accessing or using our website, you agree to be bound by these terms.</p>
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. When using particular services on the website, you may also be subject to posted guidelines or rules applicable to those services.</p>
            <h2>2. Description of Services</h2>
            <p>RubiKnows provides engineering, construction, and consultancy services. Information on this website is for general informational purposes and does not constitute professional engineering advice until a formal agreement is established.</p>
            <h2>3. Intellectual Property Rights</h2>
            <p>The content, organization, graphics, design, compilation, and other matters related to this website are protected under applicable copyright, trademark, and other proprietary rights. Copying, redistribution, use, or publication of any part of this website is prohibited without our express written permission.</p>
            <h2>4. Limitation of Liability</h2>
            <p>RubiKnows, its officers, directors, employees, and agents are not liable for direct, indirect, incidental, special, punitive, or consequential damages resulting from errors, mistakes, or inaccuracies of content, or from access to and use of this website.</p>
            <h2>5. Project Quotations</h2>
            <p>Estimates or quotations provided through the website are preliminary and may change following detailed assessment and formal agreement. They do not constitute a binding contract until a formal proposal is signed by both parties.</p>
            <h2>6. Modifications to Terms</h2>
            <p>RubiKnows may change these conditions from time to time. Continued use of the website signifies acceptance of any adjustment to these terms.</p>
            <h2>7. Contact Information</h2>
            <p>If you have questions regarding these Terms of Service, please <a href="{{ route('public.contact') }}">contact us</a>.</p>
        </article>
    </section>
</x-public-layout>
