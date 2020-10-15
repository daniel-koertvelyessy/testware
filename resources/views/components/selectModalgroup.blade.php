


<label for="{{ $id }}">{{ $label }}</label>
<div class="input-group">
    <select name="{{ $name??$id }}" id="{{ $id }}"
            class="custom-select">
        {{ $slot }}
    </select>
    <button
        type="button"
        class="btn btn-outline-primary ml-2 {{ $class??'' }} "
        data-toggle="modal" data-target="#{{ $modalid??'' }}"
    >
        <span class="d-none d-md-inline">{{ $btnL??'Neu' }}</span>
        <span class="fas fa-plus"></span>
    </button>
</div>



