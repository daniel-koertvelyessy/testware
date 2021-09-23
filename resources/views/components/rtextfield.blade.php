<div class="form-group">
    <label for="{{ $id }}"
           @if(isset($hideLabel)) class="sr-only" @endif>
        {{ $label??'' }}
    </label>
    <input type="text"
           name="{{ $name??$id }}"
           id="{{ $id }}"
           class="form-control @error($name??$id) is-invalid @enderror"
           value="{{ $value ?? old( $name??$id )  }}"
           required
           @if(isset($max))
           max="{{ $max }}"
           @endif
           @if(isset($placeholder))
           placeholder="{{ $placeholder }}"
        @endif
    >
    @error($name??$id)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
    <span class="small text-muted @error( $name??$id) d-none @enderror ">{{__('erforderliches Feld')}} | {{ __('max. :max Zeichen',['max'=>$max??'20']) }}</span>
</div>
