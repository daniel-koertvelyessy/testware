
<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text" name="{{ $name??$id }}" id="{{ $id }}"
           class="form-control @error($name??$id) is-invalid @enderror"
           value="{{ $value ?? old( $name??$id )  }}"
    >
    @error($name??$id)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
    <span class="small text-primary @error( $name??$id) d-none @enderror ">max {{ $max??'100' }} Zeichen</span>
</div>
