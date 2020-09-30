
<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name??$id }}" id="{{ $id }}"
              class="form-control @error($name??$id) is-invalid @enderror"
              rows="3"
    >{{  $value ?? old( $name??$id ) }}</textarea>
    @error($name??$id)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
