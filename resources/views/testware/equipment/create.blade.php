@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
{{{__('Neu anlegen')}}} &triangleright; {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal"
         id="modalSetStandort"
         tabindex="-1"
         aria-labelledby="modalSetStandortLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalSetStandortLabel"
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
                    @forelse(App\Standort::all() as $standort)
                        <div class="custom-control custom-radio">
                            <input type="radio"
                                   id="setStandort_{{ $standort->id }}"
                                   name="setStandort[]"
                                   class="custom-control-input setStandort"
                                   value="{{ $standort->id }}"
                            >
                            <label class="custom-control-label"
                                   for="setStandort_{{ $standort->id }}"
                            >{{ $standort->std_kurzel }}</label>
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
                            id="btnSetStandortFromModal"
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
                <h1 class="h3">{{__('Neues Gerät anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('equipment.store') }}"
                      id="frmAddNewEquipment"
                      method="POST"
                      enctype="multipart/form-data"
                      class="needs-validation"
                >
                    @csrf
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id"
                           value="{{ $produkt }}"
                    >
                    <input type="hidden"
                           name="eq_uid"
                           id="eq_uid"
                           value="{{ Str::uuid() }}"
                    >
                    <input type="hidden"
                           name="standort_id"
                           id="standort_id"
                           value="{{ old('standort_id')??'' }}"
                    >
                    <div class="row">
                        <div class="col-md-4">
                            <x-textfield id="setNewEquipmentFromProdukt"
                                         label="{{__('Import aus Produkt')}}"
                                         value="{{ App\Produkt::find($produkt)->prod_name_lang  }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_inventar_nr"
                                         label="{{__('Inventarnummer')}}"
                                         max="100"
                                         required
                                         class="checkLabel"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-datepicker id="eq_ibm"
                                          label="{{__('Inbetriebname')}}"
                                          value="{{ date('Y-m-d') }}"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-datepicker id="qe_control_date_last"
                                          label="{{__('Letzte Prüfung')}}"
                                          value="{{ date('Y-m-d') }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="setStandOrtId">{{__('Aufstellplatz / Standort')}}</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="setStandOrtId"
                                           id="setStandOrtId"
                                           class="form-control @error('setStandOrtId') is-invalid @enderror"
                                           value="{{ old( 'setStandOrtId') ??''  }}"
                                           required
                                           placeholder="{{__('Eingabe startet Suche')}}"
                                    >
                                    <button type="button"
                                            class="btn btn-outline-primary ml-2"
                                            data-toggle="modal"
                                            data-target="#modalSetStandort"
                                    >
                                        <span class="d-none d-md-inline">{{__('Suche')}}</span> <span class="fas fa-search ml-md-2"></span>
                                    </button>
                                </div>
                                <span class="text-warning small d-block"
                                      id="standortStatus"
                                ></span>
                                @error('setStandOrtId')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <span class="small text-primary @error( 'setStandOrtId') d-none @enderror ">{{__('erforderliches Feld, max 20 Zeichen')}}</span>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_serien_nr"
                                         label="{{__('Seriennummer')}}"
                                         max="100"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="equipment_state_id"
                                           label="{{__('Geräte Status')}}"
                            >
                                @foreach (App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}"
                                            class="text-{{ $equipmentState->estat_color }}"
                                            @if($equipmentState->id===4) selected  @endif
                                    >{{ $equipmentState->estat_name_kurz }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @foreach (\App\ProduktParam::where('produkt_id',$produkt )->get() as $produktParam)
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
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="h5">{{__('Funktionsprüfung')}}</h2>
                            <div class="btn-group btn-group-toggle mb-3"
                                 data-toggle="buttons"
                            >
                                <label class="btn btn-outline-success active">
                                    <input type="radio"
                                           id="controlEquipmentPassed"
                                           name="function_control_pass"
                                           value="1"
                                           class="function_control_pass"
                                    > {{__('Bestanden')}}
                                </label>
                                <label class="btn btn-outline-danger">
                                    <input type="radio"
                                           id="controlEquipmentNotPassed"
                                           name="function_control_pass"
                                           value="0"
                                           class="function_control_pass"
                                           checked
                                    > {{__('NICHT Bestanden')}}
                                </label>
                            </div>
                            <x-datepicker id="function_control_date"
                                          label="{{__('Die Prüfung erfolgte am')}}"
                                          required
                                          value="{{ date('Y-m-d') }}"
                            />
                            <div class="row">
                                <div class="col-md-6">
                                    <x-selectfield id="function_control_firma"
                                                   label="{{__('durch Firma')}}"
                                    >
                                        <option value="void">{{__('bitte wählen')}}</option>
                                        @foreach(\App\Firma::all() as $firma)
                                            <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                                        @endforeach
                                    </x-selectfield>
                                </div>
                                <div class="col-md-6">
                                    <x-selectfield id="function_control_profil"
                                                   label="{{__('durch befähigte Person')}}"
                                    >
                                        <option value="void">{{__('bitte wählen')}}</option>
                                        @foreach(\App\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </x-selectfield>
                                </div>
                            </div>
                            <x-textarea id="function_control_text"
                                        label="{{__('Bemerkungen zur Prüfung')}}"
                            />
                        </div>
                        <div class="col-md-6">
                            <h2 class="h5">{{__('Bericht')}}</h2>
                            <x-selectfield id="document_type_id"
                                           label="{{__('Dokument Typ')}}"
                            >
                                @foreach (App\DocumentType::all() as $ad)
                                    <option value="{{ $ad->id }}"
                                            @if( $ad->id==5 ?? old('document_type_id')==$ad->id)
                                            selected
                                        @endif
                                    >{{ $ad->doctyp_name_kurz }}</option>
                                @endforeach
                            </x-selectfield>
                            <x-textfield id="eqdoc_name_kurz"
                                         label="{{__('Bezeichnung')}}"
                            />

                            <x-textarea id="eqdoc_name_text"
                                        label="{{__('Datei Informationen')}}"
                            />

                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file"
                                           id="equipDokumentFile"
                                           name="equipDokumentFile"
                                           data-browse="{{__('Datei')}}"
                                           class="custom-file-input"
                                           accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                    >
                                    <label class="custom-file-label"
                                           for="equipDokumentFile"
                                    >{{__('Datei wählen')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="btnAddNewEquipment"
                            type="button"
                            class="btn btn-primary"
                    >{{__('Gerät anlegen')}} <i class="fas fa-download ml-3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{--    {{ App\Produkt::find(request('produkt_id'))  }}--}}
@endsection

@section('autocomplete')
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
                                label: `(${obj.prod_nummer}) ${obj.pk_name_kurz} - ${obj.prod_name_lang}`,
                                id: obj.id,
                                value: obj.prod_name_kurz
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
                    url: "{{ route('checkStandortValid') }}",
                    data: {name},
                    success: (res) => {
                        const sts = $('#standortStatus');
                        if (res === 0) {
                            sts.text('Dieser Standort existiert nicht');
                            nd.addClass('is-invalid').attr('title', 'Dieser Standort existiert nicht!');
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
                    url: "{{ route('getStandortIdListAll') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        let resp = $.map(data, function (obj) {


                            return $.map(obj, function (res) {


                                return {
                                    label: `${res.std_kurzel} - ${res.name_lang}`,
                                    id: res.id,
                                    value: res.std_kurzel
                                };


                            });


                        });
                        response(resp);
                    }


                });
            },
            select: function (event, ui) {
                $('#standort_id').val(ui.item.id).removeClass('is-invalid');
            }
        });
    </script>
@endsection

@section('scripts')

    <script>

        function checkFunctionControl(){
            const function_control_profil = $('#function_control_profil');
            const function_control_firma = $('#function_control_firma');

            let chekResult=false;

            if (function_control_firma.val()==='void' && function_control_profil.val()==='void' ) {
                function_control_profil.addClass('is-invalid');
                function_control_firma.addClass('is-invalid');
            }

            if (function_control_firma.val()!=='void' || function_control_profil.val()!=='void'){
                function_control_profil.removeClass('is-invalid');
                function_control_firma.removeClass('is-invalid');
                chekResult = true;
            }

            return chekResult;

        }

        $('#function_control_profil').change(function () {
            checkFunctionControl();
            $('#function_control_firma').val('void');
        });

        $('#function_control_firma').change(function () {
            checkFunctionControl();
            $('#function_control_profil').val('void');
        });

        $('#btnAddNewEquipment').click(function () {
            const standort_id = $('#standort_id');
            const eq_inventar_nr = $('#eq_inventar_nr');
            const setStandOrtId = $('#setStandOrtId');

            let frmIsComplete = true;
            if (!($('#controlEquipmentPassed').prop('checked') || $('#controlEquipmentNotPassed').prop('checked'))) {
                $('.function_control_pass').addClass('is-invalid');
                frmIsComplete = false;
            }

            frmIsComplete = checkFunctionControl();

            if (standort_id.val() === '')
            {
                setStandOrtId.addClass('is-invalid');
                frmIsComplete = false;
            }

            if (eq_inventar_nr.val() === '')
            {
                eq_inventar_nr.addClass('is-invalid');
                frmIsComplete = false;
            }

            if (frmIsComplete) $('#frmAddNewEquipment').submit()
        });


        $('.function_control_pass').click(function () {
            const nd = $('#equipment_state_id');
            const eqdoc_name_kurz = $('#eqdoc_name_kurz');
            const equipDokumentFile = $('#equipDokumentFile');

            if ($('#controlEquipmentNotPassed').prop('checked')) {
                nd.val(4);
                $('#equipment_state_id > option').eq(0).attr('disabled', 'disabled');
            } else {
                $('#equipment_state_id > option').eq(0).attr('disabled', false);
                nd.val(1)
            }

            if (eqdoc_name_kurz.val() !== '' && equipDokumentFile.val() !== '') {
                $('#btnAddNewEquipment').attr('disabled', false);
            }

        });

        $('#equipDokumentFile').change(function () {
            if ($(this).val() !== '' && $('#eqdoc_name_kurz').val() !== '')
                $('#btnAddNewEquipment').attr('disabled', false);
        });

        $('#eqdoc_name_kurz').change(function () {
            if ($(this).val() !== '' && $('#equipDokumentFile').val() !== '')
                $('#btnAddNewEquipment').attr('disabled', false);
        });

        $('#btnSetStandortFromModal').click(function () {
            const setStandortNd = $('input.setStandort');
            $('#standort_id').val(setStandortNd.val());
            $('#setStandOrtId').removeClass('is-invalid').val($('.setStandort').next('label').html());
            $('#modalSetStandort').modal('hide');
        });

    </script>

@endsection
