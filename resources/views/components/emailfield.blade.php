<label for="{{ $id }}">{{ $label }}</label>
<input type="email" name="{{ $name }}" id="{{ $id }}"
       class="form-control @error($name) is-invalid @enderror"
       value="{{ old( $name ) ?? '' }}"
>
@error($name)
<span class="text-danger small">{{ $message }}</span>
@enderror
<span class="small text-primary @error( $name) d-none @enderror ">max 100 Zeichen</span>
