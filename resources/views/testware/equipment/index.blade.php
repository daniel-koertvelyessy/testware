@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">Neues Gerät anlegen</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <label for="setNewEquipmentFromProdukt">Neues Gerät aus Produkt-Vorlage erstellen</label>
                <div class="input-group">
                    <input type="text" name="setNewEquipmentFromProdukt" id="setNewEquipmentFromProdukt"
                           placeholder="Bitte Produktnummer oder -name eingeben"
                           class="form-control getProduktListe"
                           value="{{ old('setNewEquipmentFrom' ) ?? '' }}"
                    >
                    <button
                        class="btn btn-primary"
                        onclick="frmSubmitNewEquipment()">
                        <span class="d-none d-md-inline">Gerät jetzt </span>anlegen
                    </button>
                </div>
                <form action="{{ route('equipment.create') }}" method="GET" id="createEquipmentFromProdukt">
                    @csrf
                    <input type="hidden" required
                           name="produkt_id"
                           id="produkt_id"
                    >
                </form>
            </div>
            <div class="col-md-6 mb-2">
                <label for="setNewEquipmentFromKategorie">Neues Gerät aus Produkt-Kategorie erstellen</label>
                <div class="input-group">
                    <select name="setNewEquipmentFromKategorie" class="custom-select"
                            id="setNewEquipmentFromKategorie"
                    >
                        @foreach (\App\ProduktKategorie::all() as $produktKategorie)
                            <option value="{{ $produktKategorie->id }}">{{ $produktKategorie->pk_name_kurz }}</option>
                        @endforeach
                    </select>
                    <button class="btn-primary btn"><span class="d-none d-md-inline">Gerät jetzt </span>anlegen</button>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 class="h4">Geräte Übersicht</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Inventar-Nr</th>
                        <th>Stellplatz</th>
                        <th>Status</th>
                        <th>Prüfung</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(App\Equipment::all() as $equipment)
                        <tr>
                            <td>{{ $equipment->produkt->prod_name_lang }}</td>
                            <td>{{ $equipment->eq_inventar_nr }}</td>
                            <td>{{ $equipment->standort->std_kurzel }}</td>
                            <td><span class="text-{{ $equipment->EquipmentState->estat_color }}">{{ $equipment->EquipmentState->estat_name_kurz }}</span></td>
                            <td>{{ $equipment->id }}</td>
                            <td><a href="{{ route('equipment.show',['equipment'=>$equipment]) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-info text-center">Keine Geräte angelegt!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('autocomplete')

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(".getProduktListe").autocomplete({
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
                                value:obj.prod_name_lang
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


        </script>

@endsection

@section('scripts')
    <script>
        function frmSubmitNewEquipment(){
            event.preventDefault();
            ($('#produkt_id').val()!=='') ?
                document.getElementById('createEquipmentFromProdukt').submit() :
                $('#setNewEquipmentFromProdukt').addClass('is-invalid').focus();
        }

    </script>
@stop
