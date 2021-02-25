@props([
    'block'=>'',
])


<button {{ $attributes->merge(['class'=>"btn btn-primary btn-block d-md-none {$block}"]) }}>
    {{ $slot }}
</button>

<button {{ $attributes->merge(['class'=>"btn btn-primary d-none d-md-inline-block"]) }}>
    {{ $slot }}
</button>
