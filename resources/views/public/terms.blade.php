<x-public-layout>
    <x-slot name="title">Terms of Service</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden border-b border-gray-100">
        <div class="absolute inset-0 bg-grid-pattern-light opacity-50 animate-grid-pan"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-[120px] pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-[150px] pointer-events-none transform -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-6">
                Terms of <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-amber-300 to-brand-500 font-black">Service</span>
            </h1>
            <p class="text-gray-400">Last updated: {{ date('F j, Y') }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="py-16 lg:py-24 bg-gray-900 relative">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rich-text text-gray-300 leading-relaxed text-base space-y-6">
                <p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use.</p>
                <h3>1. Acceptance of Terms</h3>
                <p>By accessing this website, we assume you accept these terms and conditions. Do not continue to use this website if you do not agree to take all of the terms and conditions stated on this page.</p>
                <h3>2. License</h3>
                <p>Unless otherwise stated, we or our licensors own the intellectual property rights for all material on this website. All intellectual property rights are reserved. You may access this from our website for your own personal use subjected to restrictions set in these terms and conditions.</p>
                <h3>3. Restrictions</h3>
                <p>You are specifically restricted from all of the following:</p>
                <ul>
                    <li>Publishing any website material in any other media.</li>
                    <li>Selling, sublicensing and/or otherwise commercializing any website material.</li>
                    <li>Using this website in any way that is or may be damaging to this website.</li>
                </ul>
                <h3>4. Governing Law</h3>
                <p>These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction, and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.</p>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-public-layout>
