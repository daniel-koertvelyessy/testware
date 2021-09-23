<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
<input type="email" name="{{ $name??$id }}" id="{{ $id }}"
       class="form-control @error($name??$id) is-invalid @enderror"
       value="{{ $value ?? old( $name??$id ) }}"
       @if(isset($required))
       required
    @endif
>
@error($name??$id)
<span class="text-danger small">{{ $message }}</span>
@enderror
@if(!isset($hideLabel))
    <span class="small text-muted @error( $name??$id) d-none @enderror ">
        @if(isset($required)) {{__('erforderliches Feld')}} @endif
        @if(isset($required) && isset($max)) | @endif
        @if(isset($class) && !str_contains($class,'decimal') || isset($max))
            {{ __('max :max Zeichen', ['max' => $max??'100']) }}
        @endif
    </span>
@endif
</div>
