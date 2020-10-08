@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Gerät :equip bearbeiten',['equip'=>$equipment->eq_inventar_nr])}} &triangleright; {{__('Geräte')}} @ bitpack GmbH
@endsection

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection


@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Gerät bearbeiten')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('equipment.update',$equipment) }}" method="post" class="needs-validation">
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
                           name="standort_id"
                           id="standort_id"
                           value="{{ $equipment->standort_id }}"
                    >
                    <div class="row">

                        <div class="col-md-4">
                            <x-staticCheckfield id="eq_inventar_nr" label="{{__('Inventarnummer')}}" max="100" value="{{ $equipment->eq_inventar_nr }}"/>
                        </div>

                        <div class="col-md-2">
                            <x-datepicker id="eq_ibm" label="{{__('Inbetriebnahme am')}}" value="{{ $equipment->eq_ibm }}" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <x-rtextfield id="setStandOrtId" label="{{__('Aufstellplatz / Standort')}}" value="{{ $equipment->standort->std_kurzel }}" />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="eq_serien_nr" label="{{__('Seriennummer')}}" max="100" value="{{ $equipment->eq_serien_nr }}" />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="equipment_state_id" label="{{__('Geräte Status')}}" >
                                @foreach (App\EquipmentState::all() as $equipmentState)
                                    <option value="{{ $equipmentState->id }}"
                                            @if($equipmentState->id === $equipment->equipment_state_id) selected @endif
                                    >{{ $equipmentState->estat_name_kurz }}</option>
                                @endforeach
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @foreach (\App\ProduktParam::where('produkt_id',$equipment->produkt_id )->get() as $produktParam)
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
                            <x-textarea id="eq_text" label="{{__('Beschreibung')}}" value="{{ $equipment->eq_text }}"/>
                        </div>
                    </div>
                    <x-btnMain>{{__('Gerät speichern')}} <span class="fas fa-download"></span></x-btnMain>
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

        $('#setStandOrtId').blur(function () {
            const nd = $('#setStandOrtId'),
                name = nd.val();

            if (name !== ''){
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('checkStandortValid') }}",
                    data: {name },
                    success: (res) => {
                        const sts = $('#standortStatus');
                       if (res===0) {
                           sts.text('Dieser Standort existiert nicht');
                           nd.addClass('is-invalid').attr('title', 'Dieser Standort existiert nicht!');
                       }else {
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
                $('#standort_id').val(ui.item.id).removeClass('is-invalid');
            }
        });

        $('.setFieldReadWrite').click(function () {
            ($(this).prop('checked')) ? $($(this).data('targetid')).attr('readonly',false) : $($(this).data('targetid')).attr('readonly',true)
        });
    </script>
@endsection
