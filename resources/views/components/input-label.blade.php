@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold uppercase tracking-widest text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
