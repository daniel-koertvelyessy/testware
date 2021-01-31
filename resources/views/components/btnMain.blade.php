
<button class="btn btn-primary @if (isset($block))
    btn-block
@endif {{ $class??'' }} d-flex justify-content-between align-items-center" @if (isset($id)) id="{{ $id }}" @endif>
    {{ $slot }}
</button>
