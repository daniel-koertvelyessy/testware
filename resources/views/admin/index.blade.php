@extends('layout.layout-admin')

@section('pagetitle')
{{__('Systemeinstellungen')}} &triangleright;
@endsection

@section('mainSection')
    {{__('Admin')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Portal</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >Verwaltung
            </li>
        </ol>
    </nav>
@endsection

@section('modals')

    <div class="modal fade"
         id="modalBuyObjects"
         tabindex="-1"
         aria-labelledby="modalBuyObjectsLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('lizenz.store') }}"
                      method="post"
                      id="frmPurchaseNewObjects"
                >
                    @csrf
                    <input type="hidden"
                           name="lizenz_id"
                           id="lizenz_id"
                           value="{{ config('app.lizenzid') }}"
                    >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalBuyObjectsLabel"
                        >{{ __('Objekte kaufen') }} [DEMO!!]</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">Sie können hier weitere Kontingente bequem einkaufen.</p>
                        <p>Wähen Sie die Anzahl an zusätzlichen Objekten aus.</p>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="buy100"
                                   name="buyObjectAmount"
                                   class="custom-control-input"
                                   value="100"
                                   checked
                            >
                            <label class="custom-control-label"
                                   for="buy100"
                            >100 Objekte
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="buy500"
                                   name="buyObjectAmount"
                                   class="custom-control-input"
                                   value="500"
                            >
                            <label class="custom-control-label"
                                   for="buy500"
                            >500 Objekte
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="buy1000"
                                   name="buyObjectAmount"
                                   class="custom-control-input"
                                   value="1000"
                            >
                            <label class="custom-control-label"
                                   for="buy1000"
                            >1000 Objekte
                            </label>
                        </div>

                        <p class="lead mt-4">Zahlung</p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="paybyPayPal"
                                   name="paymentMethode"
                                   class="custom-control-input"
                                   checked
                            >
                            <label class="custom-control-label"
                                   for="paybyPayPal"
                            >via PayPal
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="paybyDebitCard"
                                   name="paymentMethode"
                                   class="custom-control-input"
                            >
                            <label class="custom-control-label"
                                   for="paybyDebitCard"
                            >via Kreditkarte
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   id="paybyInvoice"
                                   name="paymentMethode"
                                   class="custom-control-input"
                            >
                            <label class="custom-control-label"
                                   for="paybyInvoice"
                            >via Rechnung
                            </label>
                        </div>
                        <div id="purchaseStatus"  class=" d-none">
                            <div class="my-5 d-flex align-items-center justify-content-center">
                                <span class="lead mr-3">Arbeite</span>
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="my-5 alert alert-success p-3 d-none" id="purchaseResult">
                            <p class="lead">Erfolg</p>
                            <p>Ihre Zahlung wurde erfolgreich abgewickelt. Die Anzahl der Objekte wurde entsprechend erhöht.<br>Vielen Dank!</p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{ __('Abbruch') }}
                        </button>
                        <button type="button"
                                id="btnPurchaseObjects"
                                class="btn btn-success"
                        >{{ __('Zahlungspflichtig bestellen') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Systemverwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <h2 class="h4">Lizenzdaten</h2>
                <ul class="list-unstyled">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Lizenznehmer</span> <span class="text-info">thermo-control Körtvélyessy GmbH</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Lizenznummer</span> <span class="text-info">{{ config('app.lizenzid') }}</span>
                    </li>
                </ul>
                <h3 class="h5">Objektliste</h3>
                <ul class="list-unstyled">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Standorte</span> <span>{{$countLocation =  \App\Location::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Gebäude</span> <span>{{$countBuilding =  \App\Building::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Räume</span> <span>{{ $countRoom = \App\Room::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Stellplätze</span> <span>{{$countStelplatz =  \App\Stellplatz::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Geräte</span> <span>{{$countEquipment =  \App\Equipment::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="lead">Gesamt</span> <span class="lead text-info">{{ App\Lizenz::getNumObjekte() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Kontingent</span> <span>{{ \App\Lizenz::getMaxObjects(config('app.lizenzid')) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                        <span class="lead">Verfügbar</span> <span class="lead">{{ \App\Lizenz::getMaxObjects(config('app.lizenzid'))-App\Lizenz::getNumObjekte()}}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-primary"
                            data-toggle="modal"
                            data-target="#modalBuyObjects"
                    >Objekte kaufen <i class="fas fa-shopping-cart"></i></button>

                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')

    <script>
        $('#btnPurchaseObjects').click(function () {
            $('#purchaseStatus').removeClass('d-none');
            setTimeout(function () {
                $('#purchaseResult').removeClass('d-none');
                $('#purchaseStatus').addClass('d-none');
                setTimeout(function () {
                    $('#frmPurchaseNewObjects').submit();
                },1000)
            },2000);
        });
    </script>

@endsection
