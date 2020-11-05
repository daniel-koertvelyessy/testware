@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
{{{__('Neu anlegen')}}} &triangleright; {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
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
                                         label="Import aus Produkt"
                                         value="{{ App\Produkt::find($produkt)->prod_name_lang  }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_inventar_nr"
                                         label="Inventar - Nr"
                                         max="100"
                                         required
                                         class="checkLabel"
                            />
                        </div>

                        <div class="col-md-2">
                            <x-datepicker id="eq_ibm"
                                          label="Inbetriebname"
                                          value="{{ date('Y-m-d') }}"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-datepicker id="qe_control_date_last"
                                          label="Letzte Prüfung"
                                          value="{{ date('Y-m-d') }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="setStandOrtId">Aufstellplatz / Standort</label>
                                <input type="text"
                                       name="setStandOrtId"
                                       id="setStandOrtId"
                                       class="form-control @error('setStandOrtId') is-invalid @enderror"
                                       value="{{ old( 'setStandOrtId') ??''  }}"
                                       required
                                >
                                <span class="text-warning small d-block"
                                      id="standortStatus"
                                ></span>
                                @error('setStandOrtId')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <span class="small text-primary @error( 'setStandOrtId') d-none @enderror ">erforderliches Feld, max 20 Zeichen</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_serien_nr"
                                         label="Seriennummer"
                                         max="100"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="equipment_state_id"
                                           label="Geräte Status"
                            >
                                @foreach (App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}">{{ $equipmentState->estat_name_kurz }}</option>
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
                                        label="Beschreibung"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="h5">Funktionsprüfung</h2>
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
                                </label> <label class="btn btn-outline-danger">
                                    <input type="radio"
                                           id="controlEquipmentNotPassed"
                                           name="function_control_pass"
                                           value="0"
                                           class="function_control_pass"
                                    > {{__('NICHT Bestanden')}}
                                </label>
                            </div>

                            <x-datepicker id="function_control_date"
                                          label="Die Prüfung erfolgte am"
                                          required
                                          value="{{ date('Y-m-d') }}"
                            />
                            <x-selectfield id="function_control_firma"
                                           label="durch Firma"
                            >
                                @foreach(\App\Firma::all() as $firma)
                                    <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                                @endforeach
                            </x-selectfield>
                            <x-textarea id="function_control_text"
                                        label="{{__('Bemerkungen zur Prüfung')}}"
                            />
                        </div>
                        <div class="col-md-6">
                            <h2 class="h5">Bericht</h2>
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
                                         required
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
                                           data-browse="Datei"
                                           class="custom-file-input"
                                           accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                           required
                                    >
                                    <label class="custom-file-label"
                                           for="equipDokumentFile"
                                    >{{__('Datei wählen')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="btnAddNewEquipment"
                            class="btn btn-primary"
                    >Gerät anlegen <i class="fas fa-download ml-3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{--    {{ App\Produkt::find(request('produkt_id'))  }}--}}
@endsection

@section('autocomplete')
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

    </script>

@endsection
