<form action="{{ route('acidataset.store') }}"
      method="post"
      id="frmAddDataSetPoint"
>
    @csrf
    <input type="hidden"
           name="anforderung_control_item_id"
           id="anforderung_control_item_id"
           value="{{ $aciid }}"
    >
    <div class="row">
        <div class="col-md-3">
            <x-textfield id="data_point_value"
                         label="{{__('Sollwert')}}"
                         class="decimal"
                         required
            />
        </div>
        <div class="col-md-3">
            <x-tolModeSelect
                id="data_point_tol_target_mode"
                mode="eq"
            />
        </div>
        <div class="col-md-2">
            <x-textfield id="data_point_tol"
                         label="{{__('± Toleranz')}}"
                         class="decimal"
                         required=""
            />
        </div>
        <div class="col-md-2 d-lg-block d-flex flex-column">
            <label for="data_point_tol_mod_abs"
                   class="d-none d-lg-block mb-lg-2"
            >{{ __('Mod') }}</label>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio"
                       id="data_point_tol_mod_abs"
                       name="data_point_tol_mod"
                       class="custom-control-input"
                       value="abs"
                >
                <label class="custom-control-label"
                       for="data_point_tol_mod_abs"
                >abs
                </label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio"
                       id="data_point_tol_mod_pro"
                       name="data_point_tol_mod"
                       class="custom-control-input"
                       value="pro"
                >
                <label class="custom-control-label"
                       for="data_point_tol_mod_pro"
                >%
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <x-textfield id="data_point_sort" label="Sort"/>
        </div>
    </div>
    <x-btnSave >{{ __('Datenpunkt anlegen') }}</x-btnSave>
</form>