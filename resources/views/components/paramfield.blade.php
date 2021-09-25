@props([
    'params'=> $params,
    'isproduct' => $isproduct,
    ])


@forelse ($params as $param)

    @if($isproduct)
        <div class="mb-3 col-md-3">
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
                    <button class="btn btn-outline-secondary btnEditParam"
                            type="button"
                            id="btnEditParam{{ $param->id }}"
                            data-id="{{ $param->id }}"
                    ><i class="fas fa-edit"></i>
                    </button>
                    <input type="hidden"
                           name="pp_id[]"
                           id="pp_id_{{ $param->id }}"
                           value="{{ $param->id }}"
                    >
                </div>
            </div>
        </div>
    @else
        <div class="mb-3 col-md-3">
            <x-textfield id="{{ $param->pp_label . $param->id }}"
                         label="{{ $param->pp_name }}"
                         value="{!! $param->pp_value !!}"
                         max="150"
            />
            <input type="hidden"
                   name="pp_id[]"
                   id="pp_id_{{ $param->id }}"
                   value="{{ $param->id }}"
            >
        </div>
    @endif
@empty
    {{--
        @forelse ($produkt->ProduktKategorie->ProduktKategorieParam as $pkParam)
            <input type="hidden"
                   name="pp_id[]"
                   id="pp_id_{{ $pkParam->id }}"
                   value="{{ $pkParam->id }}"
            >
            <x-textfield id="{{ $pkParam->pkp_label }}"
                         name="pp_label[]"
                         label="{{ $pkParam->pkp_name }}"
                         value="{!! $pkParam->pkp_value !!}"
                         max="150"
            />
        @empty
            <x-notifyer>
                {{__('Es wurden bislang keine Datenfelder angelegt')}}
            </x-notifyer>
        @endforelse
    --}}
    <x-notifyer>
        {{__('Es wurden bislang keine Datenfelder angelegt')}}
    </x-notifyer>
@endforelse

<x-modals.form_modal
    title="{{ __('Edit parameter') }}"
    method="POST"
    modalId="modalEditParams"
    modalRoute="{{ route('updateProduktParams') }}"
    btnSubmit="{{ __('Parameter aktualisieren') }}"
    modalType="sd"
    modalCenter="true"
>
    <input type="hidden"
           name="produkt_id"
           id="produkt_id_param_edit"
           value=""
    >
    <input type="hidden"
           name="id"
           id="pp_id_edit"
    >
    <div class="row">
        <div class="col">
            <x-textfield id="pp_label_edit"
                         label="{{__('Label')}}"
            />
            <x-textfield id="pp_name_edit"
                         label="{{__('Name')}}"
            />
            <x-textfield id="pp_value_edit"
                         label="{{__('Wert')}}"
            />
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkUpdateEquipmentToo" name="checkUpdateEquipmentToo">
                <label class="custom-control-label" for="checkUpdateEquipmentToo">{{ __('Änderung auch für Geräte vollziehen') }}</label>
            </div>
        </div>
    </div>
</x-modals.form_modal>

<script>
    $(document).on('click','.btnEditParam',function () {
        const id = $(this).data('id');
        $.ajax({
            type: "get",
            dataType: 'json',
            url: "{{ route('getParamData') }}",
            data: {id},
            success: (paramData) => {
                $('#pp_id_edit').val(paramData.id);
                $('#pp_label_edit').val(paramData.pp_label);
                $('#pp_name_edit').val(paramData.pp_name);
                $('#pp_value_edit').val(paramData.pp_value);
                $('#produkt_id_param_edit').val(paramData.produkt_id);
                $('#modalEditParams').modal('show');

           }
        });

    });
</script>
