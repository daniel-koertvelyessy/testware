<a href="{{ $link??'#' }}" class="col p-1 text-decoration-none">

    <span class="btn-outline-primary rounded border border-primary pt-3 p-2 align-content-stretch d-flex flex-column justify-content-center align-items-center">
        {{ $slot }}

    {{ $label??'-' }}
    </span>

</a>
