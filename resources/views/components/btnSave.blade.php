
<button class="btn btn-outline-primary btn-block {{ $class??'' }} " @if (isset($id)) id="{{ $id }}" @endif>
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="fas fa-download"></span>
</button>
