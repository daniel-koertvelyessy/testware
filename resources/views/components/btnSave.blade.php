
<button type="{{ $type??'submit' }}" class="btn btn-outline-primary @if(isset($block)) btn-block @endif {{ $class??'' }} " @if (isset($id)) id="{{ $id }}" @endif>
    <span class="d-none d-md-inline">{{ $slot }}</span>
    <span class="fas fa-download ml-md-2"></span>
</button>
