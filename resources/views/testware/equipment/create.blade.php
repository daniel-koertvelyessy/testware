@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection


@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Neues Gerät anlegen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{ request('produkt_id') }}
                <form action="{{ route('equipment.store') }}" method="post" class="needs-validation">
                    @csrf
                    <input type="hidden"
                           name="produkt_id"
                           id="produkt_id"
                           value="{{request('produkt_id')}}"
                    >
                    <input type="hidden"
                           name="standort_id"
                           id="standort_id"
                    >
                    <div class="row">
                        <div class="col-md-4">
                            <x-textfield id="setNewEquipmentFromProdukt" label="Import aus Produkt"
                                         value="{{ App\Produkt::find(request('produkt_id'))  }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-rtextfield id="eq_inventar_nr" label="Inventar - Nr" max="100"/>
                        </div>

                        <div class="col-md-2">
                            <x-datepicker id="eq_ibm" label="Inbetriebname" value="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-2">
                            <x-datepicker id="qe_control_date_last" label="Letzte Prüfung" value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <x-rtextfield id="setStandOrtId" label="Standort"/>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_serien_nr" label="Seriennummer" max="100" />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="equipment_state_id" label="Geräte Status" >
                                @foreach (App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}">{{ $equipmentState->estat_name_kurz }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @foreach (\App\ProduktParam::where('produkt_id',request('produkt_id'))->get() as $produktParam)
                                <x-textfield id="{{ $produktParam->pp_label }}" name="ep_value[]"
                                             label="{{ $produktParam->pp_name }}"
                                             value="{{ $produktParam->pp_value }}" max="150"
                                />
                                <input type="hidden" name="pp_id[]" id="pp_id_{{ $produktParam->id }}" value="{{ $produktParam->id }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-textarea id="eq_text" label="Beschreibung"/>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block">Gerät anlegen</button>
                </form>
            </div>
        </div>
    </div>
{{--    {{ App\Produkt::find(request('produkt_id'))  }}--}}
@endsection

@section('autocomplete')

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
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
                        let resp = $.map(data,function(obj){
                            return {
                                label : `(${obj.prod_nummer}) ${obj.pk_name_kurz} - ${obj.prod_name_lang}` ,
                                id:obj.id,
                                value:obj.prod_name_kurz
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
                        let resp = $.map(data,function(obj){


                          return  $.map(obj,function(res){


                                return {
                                    label : `${res.std_kurzel} - ${res.name_lang}` ,
                                    id:res.id,
                                    value:res.std_kurzel
                                };


                            });


                        });
                        response(resp);
                    }



                });
            },
            select: function (event, ui) {
                $('#standort_id').val(ui.item.id);
            }
        });


    </script>
    </script>
@endsection
