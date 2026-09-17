<x-public-layout>
    <x-slot name="title">{{ $service->title }}</x-slot>

    <x-public.page-intro :eyebrow="$service->category ?: 'Service'" number="03" :title="$service->title" :lede="$service->short_description" />

    <section class="rk-section">
        <div class="rk-container rk-service-detail">
            @if($service->image_path)
                <img class="rk-service-detail__image" loading="lazy" decoding="async" src="{{ \App\Support\MediaUrl::for($service->image_path) }}" alt="{{ $service->title }}">
            @else
                <div class="rk-service-detail__image flex items-end bg-[#e0a92a] p-8">
                    <span class="text-5xl font-extrabold tracking-[-.08em] text-[#171613]">RK</span>
                </div>
            @endif
            <div class="rk-rich-copy rich-text">
                @if($service->content)
                    {!! nl2br(e($service->content)) !!}
                @else
                    <p>Our team will tailor this service to the needs of your project. Contact RubiKnows to start a conversation.</p>
                @endif

                @php($features = is_string($service->features ?? null) ? preg_split('/\r?\n/', $service->features) : ($service->features ?? []))
                @if(!empty(array_filter((array) $features)))
                    <div class="mt-10 border-t border-black/15 pt-8">
                        <x-public.eyebrow>What this can include</x-public.eyebrow>
                        <ul class="mt-5 space-y-3 text-base leading-relaxed">
                            @foreach($features as $feature)
                                @if(trim($feature) !== '')<li class="border-l-2 border-brand-500 pl-4">{{ trim($feature) }}</li>@endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-public.action href="{{ route('public.contact', ['subject' => 'Inquiry about ' . $service->title]) }}" class="mt-10">Talk to our team</x-public.action>
            </div>
        </div>
    </section>
</x-public-layout>
