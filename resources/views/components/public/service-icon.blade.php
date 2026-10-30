@props(['title' => ''])

@php
    // Pick a line icon from the service name, so services added in the admin
    // still get a sensible one.
    $name = \Illuminate\Support\Str::lower((string) $title);
    $path = match (true) {
        str_contains($name, 'manage') => 'M4 3v18 M7 6h8 M10 11h10 M7 16h6',
        str_contains($name, 'structur') || str_contains($name, 'engineer') => 'M5 4h14 M5 20h14 M12 4v16 M8 9h8 M8 15h8',
        str_contains($name, 'design') || str_contains($name, 'plan') => 'M4 20 L12 4 L20 20 Z M8 14h8 M12 4v3',
        str_contains($name, 'site') || str_contains($name, 'civil') || str_contains($name, 'earth') => 'M3 18c3-4 6-4 9 0s6 4 9 0 M3 12c3-3 6-3 9 0s6 3 9 0 M3 6c3-2 6-2 9 0s6 2 9 0',
        str_contains($name, 'consult') || str_contains($name, 'assess') || str_contains($name, 'inspect') => 'M10 17a7 7 0 1 1 0-14 7 7 0 0 1 0 14z M15 15l6 6 M7 10h6',
        str_contains($name, 'construct') || str_contains($name, 'build') => 'M3 18h18 M5 18a7 7 0 0 1 14 0 M10 11V6h4v5 M3 21h18',
        default => 'M4 4h16v16H4z M4 9.3h16 M4 14.6h16 M9.3 4v16 M14.6 4v16',
    };
@endphp

<svg {{ $attributes->merge(['class' => 'rk-face__icon']) }} viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $path }}"/></svg>
