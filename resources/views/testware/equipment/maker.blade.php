@extends('layout.layout-admin')

@section('pagetitle')
{{{__('Start')}}} &triangleright; {{__('Geräte')}} @ bitpack GmbH
@endsection

@section('mainSection')
    {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal fade"
         id="modalAddProdukt"
         tabindex="-1"
         aria-labelledby="modalAddProduktLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalAddProduktLabel"
                    >{{__('Neues Produkt anlegen')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('equipment.create') }}"
                          method="get"
                          class="needs-validation"
                          id="frmAddNewProduktModal"
                    >
                        @csrf
                        <input type="text"
                               name="produkt_id"
                               id="produkt_id_modal"
                        >
                        <x-form_AddProdukt/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-dismiss="modal"
                    >{{__('Abbruch')}}</button>
                    <button type="button"
                            class="btn btn-outline-primary"
                            id="btnAddNewProduktAndProceed"
                    >{{__('Produkt anlegen und fortfahren')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Neues Gerät anlegen')}}</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                @if(App\Produkt::all()->count() >0)
                    <label for="setNewEquipmentFromProdukt">{{__('Neues Gerät aus Produkt-Vorlage erstellen')}}</label>
                    <div class="input-group">
                        <input type="text"
                               name="setNewEquipmentFromProdukt"
                               id="setNewEquipmentFromProdukt"
                               placeholder="{{__('Bitte Produktnummer oder -name eingeben')}}"
                               class="form-control getProduktListe"
                               value="{{ old('setNewEquipmentFrom' ) ?? '' }}"
                        >
                        <button
                            class="btn btn-primary ml-2"
                            onclick="frmSubmitNewEquipment()"
                        >
                            <span class="d-none d-md-inline">{{__('Gerät jetzt')}} </span>{{__('anlegen')}}
                        </button>
                    </div>
                    <form action="{{ route('equipment.create') }}"
                          method="GET"
                          id="createEquipmentFromProdukt"
                    >
                        @csrf
                        <input type="hidden"
                               required
                               name="produkt_id"
                               id="produkt_id"
                        >
                    </form>
                @else
                    <h2 class="h5">{{__('Es sind noch keine Produkte angelegt worden')}}!</h2>
                    <a href="{{ route('produkt.create') }}"
                       class="btn btn-lg btn-primary"
                    >{{__('Neues Produkt anlegen')}}</a>
                @endif
            </div>
            <div class="col-md-6 mb-2">
                <h2 class="h4">V{{__('erfügbare Produkte')}}</h2>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Produkt-Nummer')}}</th>
                        <th>{{__('Bezeichnung')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="produktListe">
                    @forelse ($produktList as $produkt)
                        <tr>
                            <td style="vertical-align: middle">
                                {{ $produkt->prod_nummer }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $produkt->prod_name_lang }}
                            </td>
                            <td>
                                <button
                                    data-produktid="{{ $produkt->id }}"
                                    data-produktname="{{ $produkt->prod_name_lang }}"
                                    class="btn btn-sm btn-outline-primary setProduktAsTemplate"
                                >{{__('verwenden')}}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Proukte angelegt')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
                @if(count($produktList)>0)
                    <div class="d-flex justify-content-center">
                        {!! $produktList->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('autocomplete')

    <link rel="stylesheet"
          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"
    >
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
                        let resp = $.map(data, function (obj) {
                            return {
                                label: `(${obj.prod_nummer}) ${obj.pk_name_kurz} - ${obj.prod_name_lang}`,
                                id: obj.id,
                                value: obj.prod_name_lang
                            };
                        });
                        resp.push(
                            {
                                label: `neues Produkt anlegen`,
                                id: '0',
                                value: 'neu'
                            }
                        );
                        response(resp);

                    }
                });
            },
            select: function (event, ui) {
                if (ui.item.id === '0') $('#modalAddProdukt').modal('show');
                $('#produkt_id').val(ui.item.id);
            }
        });


    </script>

@endsection

@section('scripts')
    <script>
        function frmSubmitNewEquipment() {
            event.preventDefault();
            ($('#produkt_id').val() !== '') ?
                document.getElementById('createEquipmentFromProdukt').submit() :
                $('#setNewEquipmentFromProdukt').addClass('is-invalid').focus();
        }

        $(document).on('click', '.setProduktAsTemplate', function () {
            $('#produkt_id').val($(this).data('produktid'));
            $('#setNewEquipmentFromProdukt').val($(this).data('produktname'));
            document.getElementById('createEquipmentFromProdukt').submit()
        });

        $('#btnAddNewProduktAndProceed').click(function () {
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "{{ route('ajaxstore') }}",
                data:
                    $('#frmAddNewProduktModal').serialize()
                ,
                success: function (res) {
                    console.debug(res);
                    const nd = $('#frmAddNewProduktModal');
                    const nummer = nd.find('#prod_nummer').val();
                    const prod_name_lang = nd.find('#prod_name_lang').val();

                    $('#produktListe').append(`
                     <tr>
                    <td style="vertical-align: middle">
                        ${nummer}
                    </td>
                    <td style="vertical-align: middle">
                        ${prod_name_lang}
                    </td>
                    <td>
                        <button
                            data-produktid="${res}"
                            data-produktname="${prod_name_lang}"
                            class="btn btn-sm btn-outline-primary setProduktAsTemplate">{{__('verwenden')}}</button>
                            </td>
                        </tr>
                    `);
                    $('#produkt_id_modal').val(res);
                    setTimeout(nd.submit(), 500);
                }
            });
        })

    </script>
@endsection
