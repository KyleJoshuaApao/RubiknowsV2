<x-public-layout>
    <x-slot name="title">Privacy Policy</x-slot>

    <!-- Header -->
    <div class="relative bg-white pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden border-b border-gray-100">
        <div class="absolute inset-0 bg-grid-pattern-light opacity-50 animate-grid-pan"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-[120px] pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-[150px] pointer-events-none transform -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-sans font-black tracking-tight leading-[1.05] mb-6">
                Privacy <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-amber-300 to-brand-500 font-black">Policy</span>
            </h1>
            <p class="text-gray-400">Last updated: {{ date('F j, Y') }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="py-16 lg:py-24 bg-gray-900 relative">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rich-text text-gray-300 leading-relaxed text-base space-y-6">
                <p>Welcome to our Privacy Policy. Your privacy is critically important to us.</p>
                <h3>1. Information We Collect</h3>
                <p>We only ask for personal information when we truly need it to provide a service to you. We collect it by fair and lawful means, with your knowledge and consent.</p>
                <h3>2. Use of Information</h3>
                <p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>
                <ul>
                    <li>To personalize your experience and to allow us to deliver the type of content and product offerings in which you are most interested.</li>
                    <li>To improve our website in order to better serve you.</li>
                    <li>To allow us to better service you in responding to your customer service requests.</li>
                </ul>
                <h3>3. Security</h3>
                <p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>
                <h3>4. Contact Us</h3>
                <p>If you have any questions about this Privacy Policy, please contact us via our contact page.</p>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-public-layout>
