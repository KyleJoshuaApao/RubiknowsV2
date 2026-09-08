<x-public-layout>
    <x-slot name="title">Privacy Policy</x-slot>

    <!-- ===== PAGE HEADER ===== -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gray-900 text-white relative kh-angled-bottom-right mb-16">
        <!-- Architectural Overlay -->
        <div class="absolute inset-0 z-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        
        <div class="max-w-screen-2xl mx-auto px-6 relative z-10 border-l-4 border-brand-500 ml-4 md:ml-8 lg:ml-12">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight max-w-4xl">
                Privacy Policy
            </h1>
            <p class="mt-8 text-xl font-bold text-gray-400">
                Last updated: {{ date('F j, Y') }}
            </p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <section class="py-24 lg:py-32 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-12">
            <div class="prose prose-gray prose-lg max-w-none rich-text font-medium text-gray-700 leading-relaxed prose-headings:font-black prose-headings:text-richblack-900 prose-headings:uppercase prose-headings:tracking-tight prose-a:text-brand-500 prose-a:font-bold hover:prose-a:text-richblack-900">
                <p>At RubiKnows, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, and safeguard the data you provide to us through our website and services.</p>
                
                <h2>1. Information We Collect</h2>
                <p>We may collect personal information that you voluntarily provide to us, such as your name, email address, phone number, and company details when you fill out contact forms, request quotations, or apply for career opportunities. We may also automatically collect certain non-personally identifiable information, such as IP addresses, browser types, and usage data to improve our website experience.</p>
                
                <h2>2. How We Use Your Information</h2>
                <p>The information we collect is used to:</p>
                <ul>
                    <li>Respond to your inquiries and provide requested services or quotations.</li>
                    <li>Process job applications and evaluate candidates for employment.</li>
                    <li>Improve our website functionality and user experience.</li>
                    <li>Send periodic emails regarding our services, updates, or related information (you may opt-out at any time).</li>
                </ul>
                
                <h2>3. Data Protection and Security</h2>
                <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. However, please note that no method of transmission over the internet or electronic storage is 100% secure.</p>
                
                <h2>4. Sharing Your Information</h2>
                <p>We do not sell, trade, or rent your personal identification information to third parties. We may share generic aggregated demographic information not linked to any personal identification information with our business partners, trusted affiliates, and advertisers for the purposes outlined above.</p>
                
                <h2>5. Changes to This Policy</h2>
                <p>RubiKnows reserves the right to update this Privacy Policy at any time. We encourage users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect.</p>
                
                <h2>6. Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please <a href="{{ route('public.contact') }}">contact us</a>.</p>
            </div>
        </div>
    </section>
</x-public-layout>
