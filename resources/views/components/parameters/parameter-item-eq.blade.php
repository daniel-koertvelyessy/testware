@if($mode==='edit')
    <div class="input-group">
        <div class="input-group-prepend">
                    <span class="input-group-text"
                          id="paramName{{ $param->id }}"
                    >{{ $param->ep_name }}</span>
        </div>
        <input type="text"
               class="form-control"
               placeholder="{{ $param->ep_name }}"
               aria-label="{{ $param->ep_name }}"
               id="{{ $param->ep_label . $param->id }}"
               name="{{ $param->ep_label }}"
               value="{!! $param->ep_value !!}"
        >
        <input type="hidden"
               name="eqp_[]"
               id="eqp_{{ $param->id }}"
               value="{{ $param->id }}"
        >
        <input type="hidden"
               name="param_route_{{ $param->id }}"
               id="param_route_{{ $param->id }}"
               value="{{ route('productparameter.update', $param) }}"
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
        </div>
    </div>
@elseif($mode==='show')
    <div class="input-group">
        <div class="input-group-prepend">
                    <span class="input-group-text"
                          id="paramName{{ $param->id }}"
                    >{{ $param->ep_name }}</span>
        </div>
        <input type="text"
               class="form-control text-right text-sm-left"
               placeholder="{{ $param->ep_name }}"
               aria-label="{{ $param->ep_name }}"
               id="{{ $param->ep_label . $param->id }}"
               name="eqp_value[{{ $param->id }}]"
               value="{!! $param->ep_value !!}"
        >
        <input type="hidden"
               name="eqp_id[]"
               id="eqp_id_{{ $param->id }}"
               value="{{ $param->id }}"
        >
    </div>
@elseif($mode==='display')
    <section class="p-2 border-bottom my-1">
        <header class="small text-muted">{{ $param->ep_name }}:</header>
        <span class="lead">{!! $param->ep_value !!}</span>
    </section>
@endif
