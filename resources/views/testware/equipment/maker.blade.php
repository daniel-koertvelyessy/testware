@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Geräte @ bitpack GmbH
@endsection

@section('mainSection')
    Geräte
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h4">Neues Gerät anlegen</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                @if(App\Produkt::all()->count() >0)
                    <label for="setNewEquipmentFromProdukt">Neues Gerät aus Produkt-Vorlage erstellen</label>
                    <div class="input-group">
                        <input type="text" name="setNewEquipmentFromProdukt" id="setNewEquipmentFromProdukt"
                               placeholder="Bitte Produktnummer oder -name eingeben"
                               class="form-control getProduktListe"
                               value="{{ old('setNewEquipmentFrom' ) ?? '' }}"
                        >
                        <button
                            class="btn btn-primary ml-2"
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
                @else
                    <h2 class="h5">Es sind noch keine Produkte angelegt worden!</h2>
                    <a href="{{ route('produkt.create') }}" class="btn btn-lg btn-primary">Neues Produkt anlegen</a>
                @endif
            </div>
            <div class="col-md-6 mb-2">
                <h2 class="h4">Verfügbare Produkte</h2>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Nummer</th>
                        <th>Bezeichnung</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Produkt::all() as $produkt)
                        <tr>
                            <td>
                                {{ $produkt->prod_nummer }}
                            </td>
                            <td>
                                {{ $produkt->prod_name_lang }}
                            </td>
                            <td>
                                <a href="{{ route('produkt.create') }}" data-produktid="{{ $produkt->id }}" class="setProduktAsTemplate">verwenden</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>Keine Proukte angelegt</x-notifyer>
                            </td>
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

        $('.setProduktAsTemplate').click(function () {
            $('#produkt_id').val($(this).data('produktid'));
            document.getElementById('createEquipmentFromProdukt').submit()
        });

    </script>
@endsection
