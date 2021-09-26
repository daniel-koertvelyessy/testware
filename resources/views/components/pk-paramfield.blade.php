<div class="row">
    @forelse ($params as $param)
        <div class="mb-3 col-md-3">
            <x-parameter-item-pk :param="$param" mode="edit"/>
        </div>
    @empty
        <div class="col">
            <x-notifyer>{{ __('Keine Daten gefunden') }}</x-notifyer>
        </div>
    @endforelse
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
           value=""
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
                         label="{{__('Wert')}}"
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

    $(document).on('click', '.btnDeleteParam', function () {
        $('#frmmodalDeleteParameter').attr('action', $(this).data('route'));

    })
</script>
