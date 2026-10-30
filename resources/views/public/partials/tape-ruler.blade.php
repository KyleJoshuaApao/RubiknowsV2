{{-- A metric tape measure edge: 1 mm ticks, longer 5 mm ticks, numbered centimetres
     and red decimetres, drawn at 50px per centimetre and clipped to the screen width. --}}
<div class="rk-ruler" aria-hidden="true">
    <svg width="4000" height="46" viewBox="0 0 4000 46">
        <defs>
            <pattern id="rk-ruler-cm" width="50" height="46" patternUnits="userSpaceOnUse">
                <path d="M0.5 0V20 M5.5 0V8 M10.5 0V8 M15.5 0V8 M20.5 0V8 M25.5 0V14 M30.5 0V8 M35.5 0V8 M40.5 0V8 M45.5 0V8"/>
            </pattern>
        </defs>
        <rect width="4000" height="46" fill="url(#rk-ruler-cm)"/>
        @for($cm = 1; $cm < 80; $cm++)
            <text x="{{ $cm * 50 }}" y="37" @class(['is-dm' => $cm % 10 === 0])>{{ $cm }}</text>
        @endfor
    </svg>
</div>
