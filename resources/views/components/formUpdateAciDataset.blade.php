@if(isset($acidataset))
<form action="{{ route('acidataset.update',$acidataset) }}"
      method="post"
      id="frmUdaeDataSetPoint"
>
    @csrf
    @method('PUT')
    <input type="hidden"
           name="anforderung_control_item_id"
           id="anforderung_control_item_id"
           value="{{ $acidataset->anforderung_control_item_id }}"
    >
    <div class="row">
        <div class="col-md-3">
            <x-textfield id="data_point_value"
                         label="{{__('Sollwert')}}"
                         class="decimal"
                         required
                         value="{{ $acidataset->data_point_value }}"
            />
        </div>
        <div class="col-md-3">
            <x-tolModeSelect
                id="data_point_tol_target_mode"
                mode="{{ $acidataset->data_point_tol_target_mode }}"
            />
        </div>
        <div class="col-md-2">
            <x-textfield id="data_point_tol"
                         label="{{__('± Toleranz')}}"
                         class="decimal"
                         required=""
                         value="{{ $acidataset->data_point_tol }}"
            />
        </div>
        <div class="col-md-2 d-lg-block d-flex flex-column">
            <label class="d-none d-lg-block mb-lg-2"
            >{{ __('Berechung') }}</label>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio"
                       id="data_point_tol_mod_abs_{{ $acidataset->id }}"
                       name="data_point_tol_mod"
                       class="custom-control-input"
                       value="abs"
                       {{ $acidataset->data_point_tol_mod === 'abs' ? 'checked' : '' }}
                >
                <label class="custom-control-label"
                       for="data_point_tol_mod_abs_{{ $acidataset->id }}"
                >abs
                </label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio"
                       id="data_point_tol_mod_pro_{{ $acidataset->id }}"
                       name="data_point_tol_mod"
                       class="custom-control-input"
                       value="pro"
                        {{ $acidataset->data_point_tol_mod === 'pro' ? 'checked' : '' }}

                >
                <label class="custom-control-label"
                       for="data_point_tol_mod_pro_{{ $acidataset->id }}"
                >%
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <x-textfield id="data_point_sort" label="Sort" :value=" $acidataset->data_point_sort"/>
        </div>
    </div>
    <x-btnSave >{{ __('Datenpunkt aktualisieren') }}</x-btnSave>
</form>
@endif