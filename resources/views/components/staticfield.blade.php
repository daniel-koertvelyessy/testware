
<div class="form-group">
    <label class="small text-muted" for="{{ $id }}">{{ $label }}</label>
    <input type="text" name="{{ $name??$id }}" id="{{ $id }}"
           class="form-control-plaintext" readonly
           value="{{ $value ?? old( $name??$id )  }}"
    >
</div>
