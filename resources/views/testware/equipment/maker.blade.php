@extends('layout.layout-admin')

@section('pagetitle')
{{{__('Gerät anlegen')}}} &triangleright; {{__('Geräte')}}
@endsection

@section('mainSection')
    {{__('Gerät anlegen')}}
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
                <form action="{{ route('produkt.ajaxstore') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="needs-validation"
                      id="frmAddNewProduktModal"
                >
                    @csrf
                    <div class="modal-body">
                        <input type="hidden"
                               name="produkt_id"
                               id="produkt_id_modal"
                        >
                        <nav>
                            <div class="nav nav-tabs"
                                 id="nav-tab"
                                 role="tablist"
                            >
                                <a class="nav-link active"
                                   id="new-prod-stamm-tab"
                                   data-toggle="tab"
                                   href="#new-prod-stamm"
                                   role="tab"
                                   aria-controls="new-prod-stamm"
                                   aria-selected="true"
                                >{{ __('Stammdaten') }}</a>
                                <a class="nav-link"
                                   id="new-prod-requirements-tab"
                                   data-toggle="tab"
                                   href="#new-prod-requirements"
                                   role="tab"
                                   aria-controls="new-prod-requirements"
                                   aria-selected="false"
                                >{{ __('Anforderungen') }}</a>
                                <a class="nav-link"
                                   id="new-prod-proddocs-tab"
                                   data-toggle="tab"
                                   href="#new-prod-proddocs"
                                   role="tab"
                                   aria-controls="new-prod-proddocs"
                                   aria-selected="false"
                                >{{ __('Dokumente') }}</a>
                            </div>
                        </nav>
                        <div class="tab-content"
                             id="nav-tabContent"
                        >
                            <div class="tab-pane fade show active"
                                 id="new-prod-stamm"
                                 role="tabpanel"
                                 aria-labelledby="new-prod-stamm-tab"
                            >
                                <x-frm_AddProdukt/>
                                <div class="border-top pt-2 mt-5 d-flex justify-content-end">
                                    <button type="button"
                                            class="btn btn-sm btn-primary bentNextTab"
                                            data-showtab="#new-prod-requirements-tab"
                                            data-required="#prod_name,#prod_label"

                                    >{{__('weiter')}}</button>
                                </div>
                            </div>
                            <div class="tab-pane fade"
                                 id="new-prod-requirements"
                                 role="tabpanel"
                                 aria-labelledby="new-prod-requirements-tab"
                            >
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-selectfield id="anforderung_id"
                                                       label="{{__('Anforderung wählen')}}"
                                        >
                                            <option value="void">{{__('bitte wählen')}}</option>
                                            @foreach (App\Anforderung::all() as $anforderung)
                                                <option value="{{ $anforderung->id }}">{{ $anforderung->an_label }}</option>
                                            @endforeach
                                        </x-selectfield>
                                        <button type="button"
                                                class="btn btn-outline-primary mt-1 btnAddAnforderung"
                                        >{{__('Anforderung auswählen')}} <i class="fas fa-angle-right"></i></button>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled"
                                            id="newProduktAnforderungListe"
                                        >

                                        </ul>
                                    </div>
                                </div>
                                <div class="border-top mt-5 pt-2 d-flex justify-content-end">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary bentBackTab mr-2"
                                            data-showtab="#new-prod-stamm-tab"
                                    >{{__('zurück')}}</button>
                                    <button type="button"
                                            class="btn btn-sm btn-primary bentNextTab"
                                            data-showtab="#new-prod-proddocs-tab"
                                    >{{__('weiter')}}</button>
                                </div>
                            </div>
                            <div class="tab-pane"
                                 id="new-prod-proddocs"
                                 role="tabpanel"
                                 aria-labelledby="new-prod-proddocs-tab"
                            >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document_type_id">{{__('Dokument Typ')}}</label>
                                            <div class="input-group">
                                                <select name="document_type_id"
                                                        id="document_type_id"
                                                        class="custom-select"
                                                >
                                                    @foreach (App\DocumentType::all() as $ad)
                                                        <option value="{{ $ad->id }}">{{ $ad->doctyp_label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       id="prodDokumentFile"
                                                       name="prodDokumentFile"
                                                       data-browse="{{__('Datei')}}"
                                                       class="custom-file-input"
                                                       accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                                >
                                                <label class="custom-file-label"
                                                       for="prodDokumentFile"
                                                >{{__('Datei wählen')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-textfield id="proddoc_label"
                                                     label="{{ __('Bezeichnung') }}"
                                        />
                                        <x-textarea id="proddoc_description"
                                                    label="{{ __('Dateiinformationen') }}"
                                        />
                                    </div>
                                </div>
                                <div class="border-top pt-2 mt-5 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            id="btnAddNewProduktAndProceed"
                                    >{{__('Produkt anlegen und fortfahren')}} <i class="fas fa-angle-right ml-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                    <label for="setNewEquipmentFromProdukt">{{__('Neues Gerät aus Produkt erstellen')}}</label>
                    <form autocomplete="off">
                        <div class="input-group">
                            <input type="text"
                                   name="setNewEquipmentFromProdukt"
                                   id="setNewEquipmentFromProdukt"
                                   placeholder="{{__('Bitte Produkt- / Artikelnummer oder Name eingeben')}}"
                                   class="form-control getProduktListe"
                                   value="{{ old('setNewEquipmentFrom' ) ?? '' }}"
                                   autocomplete="off"
                            >
                            <button type="button"
                                    class="btn btn-primary ml-2"
                                    onclick="frmSubmitNewEquipment()"
                            >
                                {{__('Gerät anlegen')}}
                            </button>

                        </div>
                    </form>
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
                       data-toggle="modal"
                       data-target="#modalAddProdukt"
                       class="btn btn-lg btn-primary"
                    >{{__('Neues Produkt anlegen')}}</a>
                @endif
            </div>
            <div class="col-md-6 mb-2">
                <h2 class="h4">{{__('Verfügbare Produkte')}}</h2>
                <table class="table table-responsive-md table-sm">
                    <thead>
                    <tr>
                        <th>@sortablelink('prod_nummer', __('Produktnummer'))</th>
                        <th>@sortablelink('prod_name', __('Bezeichnung'))</th>
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
                                {{ $produkt->prod_name }}
                            </td>
                            <td>
                                <button
                                    data-produktid="{{ $produkt->id }}"
                                    data-produktname="{{ $produkt->prod_name }}"
                                    class="btn btn-sm btn-outline-primary setProduktAsTemplate"
                                >{{__('verwenden')}}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Produkte angelegt')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if(count($produktList)>1)
                    <div class="d-flex justify-content-center">
                        {!! $produktList->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('autocomplete')
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
                                label: `(${obj.prod_nummer}) ${obj.pk_label} - ${obj.prod_name}`,
                                id: obj.id,
                                value: obj.prod_name
                            };
                        });
                        resp.push(
                            {
                                label: `{{__('Neues Produkt anlegen')}}`,
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

        $(document).on('click', '.btnAddAnforderung', function () {
            const nd = $('#anforderung_id :selected');
            if (nd.val() !== 'void')

                $('#newProduktAnforderungListe').append(`
        <li class="list-group-item d-flex justify-content-between align-items-center" id="anforderungListItem${nd.val()}">
            ${nd.text()}
            <input type="hidden" name="anforderung_id[]" id="${nd.val()}" value="${nd.val()}">
            <button type="button" class="btn m-0 deleteAnforderungsListItem" data-id="#anforderungListItem${nd.val()}">
                  <i class="fas fa-times"></i>
            </button>
        </li>
                `);
            nd.attr('disabled', true);
        });
        $(document).on('click', '.deleteAnforderungsListItem', function () {
            console.log($(this).data('id'));
            $($(this).data('id')).remove();
        });

        $(document).on('change', '#produkt_kategorie_id', function () {
            const nd = $('#newProduktKategorie');
            ($('#produkt_kategorie_id :selected').val() === 'new') ?
                nd.removeClass('d-none') :
                nd.addClass('d-none');
        });

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

        $('#prod_name').change(function () {
            const name = $('#document_type_id :selected').text() + ' ' + $('#prod_name').val();
            $('#proddoc_label').val(name);
        });

        $('#document_type_id').change(()=>{
            $('#proddoc_label').val(
                $('#document_type_id :selected').text() + ' ' + $('#prod_name').val()
            );
        });
    </script>

    @if($errors->any())
        <script>
            $('#modalAddProdukt').modal('show');
        </script>

    @endif
@endsection
