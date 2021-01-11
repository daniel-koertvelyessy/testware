<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text"
           name="{{ $name??$id }}"
           id="{{ $id }}"
           @if(isset($placeholder))
           placeholder="{{ $placeholder }}"
           @endif
           class="form-control {{ $class??'' }} @error($name??$id) is-invalid @enderror"
           value="{{ $value ?? old( $name??$id )  }}"
           @if(isset($required)) required @endif
    >
    @error($name??$id)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
    <span class="small text-primary @error( $name??$id) d-none @enderror ">
     @if(isset($required)) {{__('erforderliches Feld')}}, @endif
        @if(isset($class) && !str_contains($class,'decimal'))
            {{ __('max :max Zeichen', ['max' => $max??'100']) }}
        @endif
    </span>
</div>
