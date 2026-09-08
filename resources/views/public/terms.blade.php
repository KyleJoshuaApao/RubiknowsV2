<x-public-layout>
    <x-slot name="title">Terms of Service</x-slot>

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
                Terms of Service
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
                <p>Welcome to RubiKnows. These Terms of Service govern your use of our website and services. By accessing or using our website, you agree to be bound by these terms.</p>
                
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. In addition, when using this website's particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>
                
                <h2>2. Description of Services</h2>
                <p>RubiKnows provides engineering, construction, and consultancy services. The information provided on this website is for general informational purposes and does not constitute professional engineering advice until a formal agreement is established.</p>
                
                <h2>3. Intellectual Property Rights</h2>
                <p>The content, organization, graphics, design, compilation, and other matters related to the Site are protected under applicable copyrights, trademarks, and other proprietary rights. The copying, redistribution, use, or publication by you of any such matters or any part of the Site is strictly prohibited without our express written permission.</p>
                
                <h2>4. Limitation of Liability</h2>
                <p>In no event shall RubiKnows, its officers, directors, employees, or agents, be liable to you for any direct, indirect, incidental, special, punitive, or consequential damages whatsoever resulting from any errors, mistakes, or inaccuracies of content, or personal injury or property damage, of any nature whatsoever, resulting from your access to and use of our website.</p>
                
                <h2>5. Project Quotations</h2>
                <p>Any estimates or quotations provided through our website are preliminary and subject to change upon detailed assessment and formal agreement. They do not constitute a binding contract until a formal proposal is signed by both parties.</p>
                
                <h2>6. Modifications to Terms</h2>
                <p>RubiKnows reserves the right to change these conditions from time to time as it sees fit and your continued use of the site will signify your acceptance of any adjustment to these terms.</p>
                
                <h2>7. Contact Information</h2>
                <p>If you have any questions regarding these Terms of Service, please <a href="{{ route('public.contact') }}">contact us</a>.</p>
            </div>
        </div>
    </section>
</x-public-layout>
