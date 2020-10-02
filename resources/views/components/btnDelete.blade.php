
<button type="button"
        class="btn btn-outline-danger ml-2 {{ $class??'' }}
        @if (!isset($block)) d-flex justify-content-between align-items-center btn-block @endif>"
        @if (isset($id)) id="{{ $id }}" @endif>
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="far fa-trash-alt"></span>
</button>
