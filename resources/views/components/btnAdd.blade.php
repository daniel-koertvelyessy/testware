
<button class="btn btn-outline-primary ml-2 {{ $block??'d-flex justify-content-between align-items-center btn-block' }} {{ $class??'' }} " id="{{ $id??'' }}">
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="fas fa-plus"></span>
</button>
