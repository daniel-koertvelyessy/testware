
<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name??$id }}" id="{{ $id }}"
              class="form-control @error($name??$id) is-invalid @enderror"
              rows="3"
              @if (isset($required))
                  required
              @endif
    >{{  $value ?? old( $name??$id ) }}</textarea>
    @if (isset($required))
        <span class="small text-primary">Erforderliches Feld</span>
    @endif
    @error($name??$id)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
