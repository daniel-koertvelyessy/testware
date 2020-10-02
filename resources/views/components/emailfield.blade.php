<label for="{{ $id }}">{{ $label }}</label>
<input type="email" name="{{ $name??$id }}" id="{{ $id }}"
       class="form-control @error($name??$id) is-invalid @enderror"
       value="{{ old( $name??$id ) ?? '' }}"
>
@error($name??$id)
<span class="text-danger small">{{ $message }}</span>
@enderror
<span class="small text-primary @error( $name??$id) d-none @enderror ">max 100 Zeichen</span>
