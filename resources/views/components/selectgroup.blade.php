


<label for="{{ $id }}">{{ $label }}</label>
<div class="input-group">
    <select name="{{ $name??$id }}" id="{{ $id }}"
            class="custom-select">
        {{ $slot }}
    </select>
    <x-btnLoad id="{{ $btnT??'' }}" block>{{ $btnL??$label }}</x-btnLoad>
</div>

