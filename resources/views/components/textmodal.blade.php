<div class="form-group">
    <label for="{{ $id }}"
           @if(isset($hide_label))
           class="sr-only"
        @endif
    >
        {{ $label }}
    </label>
    <div class="input-group">
        <input type="text"
               name="{{ $name??$id }}"
               id="{{ $id }}"
               @if(isset($placeholder))
               placeholder="{{ $placeholder }}"
               @endif
               class="form-control {{ $class??'' }} @error($name??$id) is-invalid @enderror"
               value="{{ $value ?? old( $name??$id )  }}"
               @if(isset($required))
               required
            @endif
        />
        <button type="button"
                class="btn btn-outline-primary ml-2"
                data-toggle="modal"
                data-target="#{{ $modalid }}"
        >
            <span class="d-none d-md-inline">{{__('Suche')}}</span> <span class="fas fa-bars ml-md-2"></span>
        </button>
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
</div>
