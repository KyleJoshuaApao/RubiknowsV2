@php
    // Logo base64 is baked into the PHP config at build time — no filesystem/CDN dependency
    static $logoSrc = null;
    if ($logoSrc === null) {
        $logoSrc = config('logo_base64');
    }
@endphp
<img {{ $attributes->merge(['alt' => 'RubiKnows Logo']) }} src="{{ $logoSrc }}">
