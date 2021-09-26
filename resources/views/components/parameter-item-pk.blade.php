<div class="input-group">
    <div class="input-group-prepend">
                    <span class="input-group-text"
                          id="paramName{{ $param->id }}"
                    >{{ $param->pkp_name }}</span>
    </div>
    @if($mode==='edit')
        <input type="text"
               class="form-control"
               placeholder="{{ $param->pkp_name }}"
               aria-label="{{ $param->pkp_name }}"
               id="{{ $param->pkp_label . $param->id }}"
               name="{{ $param->pkp_label }}"
               value="{!! $param->pkp_value !!}"
        >
    <div class="input-group-append">
        <button class="btn btn-sm btn-outline-primary btnEditParam"
                type="button"
                id="btnEditParam{{ $param->id }}"
                data-id="{{ $param->id }}"
        >
            <i class="fas fa-edit"></i>
        </button>
        <button type="button"
                class="btn btn-sm btn-outline-danger btnDeleteParam"
                id="btnDeleteParam{{ $param->id }}"
                data-toggle="modal"
                data-target="#modalDeleteParameter"
                data-id="{{ $param->id }}"
                data-route="{{ route('productparameter.destroy',$param) }}#Parameter"
        >
            <i class="fas fa-trash-alt"></i>
        </button>
        <input type="hidden"
               name="pkp_id[]"
               id="pkp_id_{{ $param->id }}"
               value="{{ $param->id }}"
        >
        <input type="hidden"
               name="param_route_{{ $param->id }}"
               id="param_route_{{ $param->id }}"
               value="{{ route('productparameter.update', $param) }}">
    </div>
    @else
        <input type="hidden"
               name="pp_label[]"
               id="pp_label{{ $param->id }}"
               value="{{ $param->pkp_label }}"
        >
        <input type="hidden"
               name="pp_name[]"
               id="pp_name_{{ $param->id }}"
               value="{{ $param->pkp_name }}"
        >
        <input type="text"
               class="form-control"
               placeholder="{{ $param->pkp_name }}"
               aria-label="{{ $param->pkp_name }}"
               id="{{ $param->pkp_label }}_{{ $param->id }}"
               name="pp_value[]"
               value="{!! $param->pkp_value !!}"
        >
    @endif
</div>