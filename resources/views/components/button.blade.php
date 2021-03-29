@props([
    'type'=>'button',
    'block' => 'btn-block',
    'size' => 'md',
    'sizeclass' =>
        [
            'sm'=>'btn-sm',
            'md'=>'',
            'xl'=>'btn-xl',
            ]
])

<button type="{{$type}}" {{ $attributes->merge(['class'=>"btn btn-outline-primary $sizeclass[$size]"]) }}>{{ $slot }}</button>
