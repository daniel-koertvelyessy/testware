@extends('layout.layout-admin')

@section('pagetitle')
{{__('Gerät :equip bearbeiten',['equip'=>$equipment->eq_inventar_nr])}} &triangleright; {{__('Geräte')}}
@endsection

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <x-modals.form_modal methode="DELETE"
                         modalRoute="{{ route('equipment.destroy',$equipment) }}"
                         modalId="modalDeleteEquipment"
                         modalType="danger"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Gerät endgültig löschen') }}"
    >
        <p class="lead">{!! __('Bitte beachten Sie, dass <strong>alle</strong> Daten und Vorgänge zu diesem Gerät gelöscht werden. Das schließt hochgeladene oder generierte Dokumente ein.') !!}</p>
        <p>{{__('Das Produkt bleibt davon unberührt.')}}</p>
        <p class="mx-3 mt-4 text-danger lead">{{__('Der Löschvorgang ist permanent und kann nicht wieder rückgängig gemacht werden.')}}</p>
    </x-modals.form_modal>

    <div class="modal"
         id="modalSetStorage"
         tabindex="-1"
         aria-labelledby="modalSetStorageLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalSetStorageLabel"
                    >{{__('Verfügbare Aufstellplätze / Standorte')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @forelse(App\Storage::all() as $storage)
                        <div class="custom-control custom-radio">
                            <input type="radio"
                                   id="setStorage_{{ $storage->id }}"
                                   name="setStorage[]"
                                   class="custom-control-input setStorage"
                                   value="{{ $storage->id }}"
                            >
                            <label class="custom-control-label"
                                   for="setStorage_{{ $storage->id }}"
                            >{{ $storage->storage_label }}</label>
                        </div>
                    @empty
                        <x-notifyer>{{__('Es sind keine Standorte angelegt')}}</x-notifyer>
                    @endforelse

                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                    >{{__('Schließen')}}</button>
                    <button type="button"
                            class="btn btn-primary"
                            id="btnSetStorageFromModal"
                    >{{__('Übernehmen')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Gerät Stammdaten bearbeiten')}}</h1>
            </div>
        </div>
        <div class="row mb-5 mt-3">
            <div class="col">
                <form action="{{ route('equipment.update',$equipment) }}"
                      method="post"
                      class="needs-validation"
                >
                    @csrf
                    @method('put')
                    <input type="hidden"
                           name="id"
                           id="id"
                           value="{{ $equipment->id }}"
                    >
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id"
                           value="{{ $equipment->produkt_id }}"
                    >
                    <input type="hidden"
                           name="storage_id"
                           id="storage_id"
                           value="{{ $equipment->storage_id??'' }}"
                    >

                    <div class="row">

                        <div class="col-md-4">
                            <x-staticCheckfield id="eq_inventar_nr"
                                                label="{{__('Inventarnummer')}}"
                                                max="100"
                                                value="{{ $equipment->eq_inventar_nr }}"
                            />
                        </div>

                        <div class="col-md-2">
                            <x-datepicker id="installed_at"
                                          label="{{__('Inbetriebnahme am')}}"
                                          value="{{ $equipment->installed_at }}"
                            />
                        </div>

                        <div class="col-md-2">
                            <x-datepicker id="purchased_at"
                                          label="{{__('Gekauft am')}}"
                                          value="{{ $equipment->purchased_at }}"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="eq_price"
                                         class="decimal price"
                                         label="{{__('Kaufpreis')}}"
                                         value="{{ $equipment->priceTag() }}"
                            />
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-4" id="setStorageID">
                            @if($equipment->storage)
                                <x-rtextfield id="setStandOrtId"
                                              label="{{__('Aufstellplatz / Standort')}}"
                                              value="{{ $equipment->storage->storage_label }}"
                                />
                            @else
                                    <label class="text-warning">{{ __('Es ist kein Standort für das Gerät festgelegt') }}</label>
                                    <button type="button"
                                            class="btn btn-outline-warning"
                                            data-toggle="modal"
                                            data-target="#modalSetStorage"
                                    >
                                        <span class="d-none d-md-inline">{{__('Standort festlegen')}}</span> <span class="fas fa-exclamation-triangle ml-md-2"></span>
                                    </button>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_serien_nr"
                                         label="{{__('Seriennummer')}}"
                                         max="100"
                                         value="{{ $equipment->eq_serien_nr }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="equipment_state_id"
                                           label="{{__('Geräte Status')}}"
                            >
                                @foreach (App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}"
                                            @if($equipmentState->id === $equipment->equipment_state_id) selected @endif
                                    >{{ $equipmentState->estat_label }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @foreach (\App\ProduktParam::where('produkt_id',$equipment->produkt_id )->get() as $produktParam)
                                <x-textfield id="{{ $produktParam->pp_label }}"
                                             name="ep_value[]"
                                             label="{{ $produktParam->pp_name }}"
                                             value="{{ $produktParam->pp_value }}"
                                             max="150"
                                />
                                <input type="hidden"
                                       name="pp_id[]"
                                       id="pp_id_{{ $produktParam->id }}"
                                       value="{{ $produktParam->id }}"
                                >
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="eq_text"
                                        label="{{__('Beschreibung')}}"
                                        value="{{ $equipment->eq_text }}"
                            />
                        </div>
                    </div>
                    <div class="d-md-none">
                        <a role="button"
                           class="btn btn-outline-secondary mt-2 btn-block"
                           href="{{ route('equipment.show',$equipment) }}"
                        >
                            <span class="fas fa-angle-double-left"></span>
                            {{ __('Abbruch') }}</a>

                        <button class="btn btn-primary mt-2 btn-block">
                            {{__('Gerät speichern ')}}<span class="fas fa-download ml-2"></span>
                        </button>

                        <button type="button"
                                class="btn btn-outline-danger mt-2 btn-block"
                                data-toggle="modal"
                                data-target="#modalDeleteEquipment"
                        >
                            {{__('Gerät löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
                        </button>
                    </div>
                    <div class="d-none d-md-inline-block">
                        <a role="button"
                           class="btn btn-outline-secondary mt-2"
                           href="{{ route('equipment.show',$equipment) }}"
                        >
                            <span class="fas fa-angle-double-left"></span>
                            {{ __('Abbruch') }}</a>

                        <button class="btn btn-primary mt-2 ml-2">
                            {{__('Gerät speichern ')}}<span class="fas fa-download ml-2"></span>
                        </button>

                        <button type="button"
                                class="btn btn-outline-danger mt-2 ml-2"
                                data-toggle="modal"
                                data-target="#modalDeleteEquipment"
                        >
                            {{__('Gerät löschen ')}} <i class="fas fa-trash-alt ml-2"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
    {{--    {{ App\Produkt::find(request('produkt_id'))  }}--}}
@endsection
@section('scripts')
    <script>
        $('#btnSetStorageFromModal').click(function () {
            const setStorageNd = $('input.setStorage:checked');
            console.log(setStorageNd.val());
            $('#storage_id').val(setStorageNd.val());
            let storageLabel = setStorageNd.next('label').html();
           let label="{{__('Aufstellplatz / Standort')}}";
            $('#setStorageID').html(`
        <div class="form-group">
            <label for="setStandOrtId">${label}</span>
            <input type="text" id="setStandOrtId" name="setStandOrtId" class="form-control" value="${storageLabel}">
        </div>
            `);

            $('#modalSetStorage').modal('hide');
        });
    </script>
@endsection
@section('autocomplete')

    <link rel="stylesheet"
          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"
    >
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $("#setNewEquipmentFromProdukt").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('produkt.getProduktIdListAll') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data, function (obj) {
                            return {
                                label: `(${obj.prod_nummer}) ${obj.pk_label} - ${obj.prod_name}`,
                                id: obj.id,
                                value: obj.prod_label
                            };
                        });
                        response(resp);
                    }
                });
            },
            select: function (event, ui) {
                $('#produkt_id').val(ui.item.id);
            }
        });

        $('#setStandOrtId').blur(function () {
            const nd = $('#setStandOrtId'),
                name = nd.val();

            if (name !== '') {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('checkStorageValid') }}",
                    data: {name},
                    success: (res) => {
                        const sts = $('#storageStatus');
                        if (res === 0) {
                            let text = '{{__('Dieser Standort existiert nicht!')}}';
                            sts.text(text);
                            nd.addClass('is-invalid').attr('title', text);
                        } else {
                            sts.text('');
                            nd.removeClass('is-invalid')
                        }

                    }
                });
            }
        });

        $("#setStandOrtId").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getStorageIdListAll') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data, function (obj) {


                            return $.map(obj, function (res) {


                                return {
                                    label: `${res.storage_label} - ${res.name}`,
                                    id: res.id,
                                    value: res.storage_label
                                };


                            });


                        });
                        response(resp);
                    }


                });
            },
            select: function (event, ui) {
                $('#storage_id').val(ui.item.id).removeClass('is-invalid');
            }
        });

        $('.setFieldReadWrite').click(function () {
            ($(this).prop('checked')) ? $($(this).data('targetid')).attr('readonly', false) : $($(this).data('targetid')).attr('readonly', true)
        });


    </script>
@endsection
