<div class="form-group {{ $class??'' }}">
    <label for="{{ $id }}">{!! $label !!}</label>
    <select name="{{ $name??$id }}" id="{{ $id }}" class="custom-select">
       {{ $slot }}
    </select>
    @if(isset($required))
    <span class="text-primary small">{{__('erforderliches Feld')}}</span>
    @endif
</div>
