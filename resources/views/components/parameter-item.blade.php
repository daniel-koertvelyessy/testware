<div class="input-group">
    <div class="input-group-prepend">
                    <span class="input-group-text"
                          id="paramName{{ $param->id }}"
                    >{{ $param->pp_name }}</span>
    </div>
    <input type="text"
           class="form-control"
           placeholder="{{ $param->pp_name }}"
           aria-label="{{ $param->pp_name }}"
           aria-describedby="button-addon2"
           id="{{ $param->pp_label . $param->id }}"
           name="{{ $param->pp_label }}"
           value="{!! $param->pp_value !!}"
    >
    <div class="input-group-append">
        <button class="btn btn-outline-primary btnEditParam btn-sm"
                type="button"
                id="btnEditParam{{ $param->id }}"
                data-id="{{ $param->id }}"
        ><i class="fas fa-edit fa-fw"></i>
        </button>
        <button type="button"
                class="btn btn-sm btn-outline-danger btnDeleteParam"
                id="btnDeleteParam{{ $param->id }}"
                data-toggle="modal"
                data-target="#modalDeleteParameter"
                data-id="{{ $param->id }}"
                data-route="{{ route('productparameter.destroy',$param) }}#Parameter"
        ><i class="fas fa-trash-alt fa-fw"></i>
        </button>
        <input type="hidden"
               name="pp_id[]"
               id="pp_id_{{ $param->id }}"
               value="{{ $param->id }}"
        >
        <input type="hidden"
               name="param_route_{{ $param->id }}"
               id="param_route_{{ $param->id }}"
               value="{{ route('productparameter.update', $param) }}">
    </div>
</div>