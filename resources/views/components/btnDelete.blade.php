@props([
    'block'=>false,
    'id'=>NULL,
    'type' => 'button',
    'class'=>NULL,
])

<button type="{{ $type }}"
        class="btn btn-outline-danger ml-2 {{ $class }} d-flex justify-content-between align-items-center
        @if (isset($block)) btn-block @endif"
        @if (isset($id)) id="{{ $id }}" @endif>
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="far fa-trash-alt"></span>
</button>
