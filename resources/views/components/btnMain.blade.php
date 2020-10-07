
<button {{--@if (!env('app.makeobjekte') ) disabled @endif --}} class="btn btn-primary btn-block {{ $class??'' }} d-flex justify-content-between align-items-center" @if (isset($id)) id="{{ $id }}" @endif>
    {{ $slot }}
</button>
