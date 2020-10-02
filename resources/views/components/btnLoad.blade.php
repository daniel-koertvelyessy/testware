
<button type="button" class="btn btn-outline-primary ml-2 {{ $class??'' }} {{ $block??'d-flex justify-content-between align-items-center btn-block' }} " @if (isset($id)) id="{{ $id }}" @endif>
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="fas fa-upload"></span>
</button>
