@props(['title', 'message' => null])

<div {{ $attributes->merge(['class' => 'rk-empty']) }}>
    <h2>{{ $title }}</h2>
    @if($message)
        <p>{{ $message }}</p>
    @endif
    @if(trim($slot) !== '')
        <div class="rk-empty__actions">{{ $slot }}</div>
    @endif
</div>
