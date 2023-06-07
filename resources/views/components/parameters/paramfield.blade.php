@props([
    'params'=> $params,
    'isproduct' => $isproduct,
    ])


@forelse ($params as $param)

    @if($isproduct)
        <div class="mb-3 col-md-3">
            <x-parameters.parameter-item :param="$param"/>
        </div>
    @else
        <div class="mb-3 col-md-3">
            <x-textfield id="{{ $param->pp_label . $param->id }}" name="{{ $param->pp_label }}"
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
@endforelse
<div class="col">
    <a class="btn btn-primary"
       href="#"
       data-toggle="modal"
       data-target="#modalAddParameter"
    >{{ __('Neuen Paramter anlegen') }}</a>
</div>
<x-modals.form_modal
        title="{{ __('Edit parameter') }}"
        method="PUT"
        modalId="modalEditParams"
        modalRoute="#"
        btnSubmit="{{ __('Parameter aktualisieren') }}"
        modalType="sd"
        modalCenter="true"
>
    <input type="hidden"
           name="produkt_id"
           id="produkt_id_param_edit"
    >
    <input type="hidden"
           name="id"
           id="pp_id_edit"
    >
    <div class="row">
        <div class="col">
            <x-textfield id="pp_label_edit"
                         name="pp_label"
                         label="{{__('Label')}}"
            />
            <x-textfield id="pp_name_edit"
                         name="pp_name"
                         label="{{__('Name')}}"
            />
            <x-textfield id="pp_value_edit"
                         name="pp_value"
                         label="{{__('Standardwert')}}"
            />
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkUpdateEquipmentToo"
                       name="checkUpdateEquipmentToo">
                <label class="custom-control-label"
                       for="checkUpdateEquipmentToo">{{ __('Änderung auch für Geräte vollziehen') }}</label>
            </div>
        </div>
    </div>
</x-modals.form_modal>

<x-modals.form_modal
        title="{{ __('Parameter löschen') }}"
        method="DELETE"
        modalId="modalDeleteParameter"
        modalRoute="#"
        btnSubmit="{{ __('Parameter löschen') }}"
        modalType="danger"
        modalCenter="true"
>
    <input type="hidden"
           name="id"
           id="pp_id_delete"
    >
    <input type="hidden"
           name="produkt_id"
           id="produkt_id_pp_delete"
    >
    <div class="row">
        <div class="col">
            <p class="lead">{{ __('Der Parameter wird gelöscht.') }}</p>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkDeleteParamOnEquipment"
                       name="checkDeleteParamOnEquipment">
                <label class="custom-control-label"
                       for="checkDeleteParamOnEquipment">{{ __('Änderung auch für Geräte vollziehen') }}</label>
            </div>
        </div>
    </div>
</x-modals.form_modal>

<script>
    $(document).on('click', '.btnEditParam', function () {
        const id = $(this).data('id');
        $.ajax({
            type: "get",
            dataType: 'json',
            url: "{{ route('getParamData') }}",
            data: {id},
            success: (paramData) => {
                $('#frmmodalEditParams').attr('action', $('#param_route_' + id).val() + '#Parameter');
                $('#pp_id_edit').val(paramData.id);
                $('#pp_label_edit').val(paramData.pp_label);
                $('#pp_name_edit').val(paramData.pp_name);
                $('#pp_value_edit').val(paramData.pp_value);
                $('#produkt_id_param_edit').val(paramData.produkt_id);
                $('#modalEditParams').modal('show');

            }
        });

    });

    $(document).on('click','.btnDeleteParam',function(){
        $('#frmmodalDeleteParameter').attr('action', $(this).data('route'));
        $('#pp_id_delete').val($(this).data('id'));
        $('#produkt_id_pp_delete').val($(this).data('id'));

    })
</script>
