


<label for="{{ $id }}">{{ $label }}</label>
<div class="input-group">
    <select name="{{ $name }}" id="{{ $id }}"
            class="custom-select">
        {{ $slot }}
    </select>
    <button type="button" class="btn btn-outline-primary ml-2" id="{{ $btnT }}">
        {{ $btnL??'laden' }}
    </button>
</div>

