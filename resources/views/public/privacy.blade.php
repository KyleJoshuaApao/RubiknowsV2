<x-public-layout>
    <x-slot name="title">Privacy Policy</x-slot>

    <x-public.page-intro eyebrow="Legal" number="09" title="Privacy policy" lede="Last updated: {{ now()->format('F j, Y') }}" />

    <section class="rk-section">
        <article class="rk-container rk-rich-copy rich-text">
            <p>At RubiKnows, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, and safeguard the data you provide to us through our website and services.</p>
            <h2>1. Information We Collect</h2>
            <p>We may collect personal information that you voluntarily provide to us, such as your name, email address, phone number, and company details when you fill out contact forms, request quotations, or apply for career opportunities. We may also automatically collect certain non-personally identifiable information, such as IP addresses, browser types, and usage data to improve our website experience.</p>
            <h2>2. How We Use Your Information</h2>
            <p>The information we collect is used to:</p>
            <ul><li>Respond to your inquiries and provide requested services or quotations.</li><li>Process job applications and evaluate candidates for employment.</li><li>Improve our website functionality and user experience.</li><li>Send periodic emails regarding our services, updates, or related information (you may opt-out at any time).</li></ul>
            <h2>3. Data Protection and Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure.</p>
            <h2>4. Sharing Your Information</h2>
            <p>We do not sell, trade, or rent your personal identification information to third parties. We may share generic aggregated demographic information not linked to any personal identification information with business partners, trusted affiliates, and advertisers for the purposes outlined above.</p>
            <h2>5. Changes to This Policy</h2>
            <p>RubiKnows may update this Privacy Policy from time to time. We encourage users to review this page for changes and stay informed about how we protect the information we collect.</p>
            <h2>6. Contact Us</h2>
            <p>If you have questions about this Privacy Policy or your dealings with this site, please <a href="{{ route('public.contact') }}">contact us</a>.</p>
        </article>
    </section>
</x-public-layout>
