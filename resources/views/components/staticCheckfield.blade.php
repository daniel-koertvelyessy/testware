<label for="{{ $id }}">{{ $label }}</label>
<div class="input-group">
    <div class="input-group-prepend">
        <div class="input-group-text">

            <input type="checkbox" class="setFieldReadWrite" aria-label="{{ $label }}" name="setFieldReadWrite" id="setFieldReadWrite_{{ $id }}" data-targetid="#{{ $id }}" value="{{ $id }}">

        </div>
    </div>
    <input type="text" name="{{ $name??$id }}" id="{{ $id }}"
           class="form-control" readonly
           value="{{ $value ?? old( $name??$id )  }}"
    >
</div>

