<div class="form-group {{ $class??'' }}">
    <label for="{{ $id }}">{!! $label !!}</label>
    <select name="{{ $name??$id }}" id="{{ $id }}" class="custom-select">
       {{ $slot }}
    </select>
</div>
