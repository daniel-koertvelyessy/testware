<div class="row">
    @forelse ($params as $param)
        <div class="mb-3 {{ $mode==='edit' ? 'col' : 'col-md-3' }}">
            <x-parameters.parameter-item-pk :param="$param"
                                 :mode="$mode"
            />
        </div>
    @empty
        <div class="col">
            <x-notifyer>{{ __('Die Kategorie hat keine Parameter') }}</x-notifyer>
        </div>
    @endforelse
</div>
@if($mode==='edit')
    <x-modals.form_modal
        title="{{ __('Parameter bearbeiten') }}"
        method="PUT"
        modalId="modalEditCategoryParams"
        modalRoute="#"
        btnSubmit="{{ __('Parameter aktualisieren') }}"
        modalType="sd"
        modalCenter="true"
    >
        <input type="hidden"
               name="produkt_kategorie_id"
               id="produkt_id_param_category_edit"
               value=""
        >
        <input type="hidden"
               name="id"
               id="pkp_id_edit"
        >
        <div class="row">
            <div class="col">
                <x-textfield id="pkp_label_edit"
                             name="pkp_label"
                             label="{{__('Label')}}"
                />
                <x-textfield id="pkp_name_edit"
                             name="pkp_name"
                             label="{{__('Name')}}"
                />
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="checkUpdateRelatedObjects"
                           name="checkUpdateRelatedObjects"
                    >
                    <label class="custom-control-label"
                           for="checkUpdateRelatedObjects"
                    >{{ __('Änderung auch für verknüpfte Objekte durchführen') }}</label>
                </div>
            </div>
        </div>
    </x-modals.form_modal>

    <x-modals.form_modal
        title="{{ __('Parameter löschen') }}"
        method="DELETE"
        modalId="modalDeleteCategoryParameter"
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
                    <input type="checkbox"
                           class="custom-control-input"
                           id="checkDeleteParamOnEquipment"
                           name="checkDeleteParamOnEquipment"
                    >
                    <label class="custom-control-label"
                           for="checkDeleteParamOnEquipment"
                    >{{ __('Änderung auch für verknüpfte Objekte durchführen') }}</label>
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
                url: "{{ route('getCategogryParam') }}",
                data: {id},
                success: (paramData) => {
                    $('#frmmodalEditCategoryParams').attr('action', $(this).data('route'));
                    $('#pkp_id_edit').val(paramData.id);
                    $('#pkp_label_edit').val(paramData.pkp_label);
                    $('#pkp_name_edit').val(paramData.pkp_name);
                    $('#produkt_id_param_category_edit').val(paramData.produkt_kategorie_id);
                    $('#modalEditCategoryParams').modal('show');
                }
            });

        });

        $(document).on('click', '.btnDeleteParam', function () {
            $('#frmmodalDeleteCategoryParameter').attr('action', $(this).data('route'));
        })
    </script>
@endif
