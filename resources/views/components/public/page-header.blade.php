@props([
    'title',
    'lede' => null,
    'breadcrumbs' => [],
])

<section {{ $attributes->merge(['class' => 'rk-page-header']) }}>
    <div class="rk-container">
        @if($breadcrumbs)
            <nav aria-label="Breadcrumb">
                <ol class="rk-breadcrumb">
                    <li><a href="{{ route('public.home') }}">Home</a></li>
                    @foreach($breadcrumbs as $label => $url)
                        <li>@if($url)<a href="{{ $url }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1>{{ $title }}</h1>
        @if($lede)
            <p class="rk-lede">{{ $lede }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
