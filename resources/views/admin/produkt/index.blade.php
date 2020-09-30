@extends('layout.layout-admin')

@section('pagetitle')
    Produktübersicht @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
{{--    <nav aria-label="breadcrumb">--}}
{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item"><a href="/">Portal</a></li>--}}
{{--            <li class="breadcrumb-item"><a href="/building">Gebäude</a></li>--}}
{{--            <li class="breadcrumb-item active" aria-current="page">{{  $building->b_name_kurz  }}</li>--}}
{{--        </ol>--}}
{{--    </nav>--}}
@endsection

@section('modals')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h4 mb-0">Übersicht Produkte</h1>
            <span class="small mt-0">Gesamt: <span class="badge badge-light">{{ number_format(App\Produkt::all()->count(),0,',','.') }}</span></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <link href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css" rel="stylesheet">
            <script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.js"></script>
            <script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table-locale-all.min.js"></script>

            <nav>
                <div class="nav nav-pills  nav-fill" id="nav-tab" role="tablist">
                    <?php $r=true; ?>
                    @foreach (App\ProduktKategorie::all() as $produktKategorie)

                        <a class="nav-link {{ ($r)?' active ':'' }}" id="nav-{{ $produktKategorie->id }}-tab" data-toggle="tab" href="#nav-{{ $produktKategorie->id }}" role="tab" aria-controls="nav-{{ $produktKategorie->id }}" aria-selected="{{ ($r)?'true':'' }}">
                            {{ $produktKategorie->pk_name_kurz}}
                            {!! ($produktKategorie->Produkt->count()>0)?'<span class="ml-1 badge badge-light">'.$produktKategorie->Produkt->count().'</span>' : '' !!}
                        </a>
                    <?php $r=false; ?>
                    @endforeach
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <?php $r=true; ?>
                @foreach (App\ProduktKategorie::all() as $produktKategorie)
                <div class="tab-pane {{ ($r)?' active show ':'' }} fade" id="nav-{{ $produktKategorie->id }}" role="tabpanel" aria-labelledby="nav-{{ $produktKategorie->id }}-tab">


           <table class="table table-sm table-striped"
                        id="table{{ $produktKategorie->id }}"
                        data-locale="de-DE"
                        data-show-refresh="true"
                        data-toggle="table"
                        data-flat="true"
                        data-search="true"
                        data-search-align="left"
                        data-click-to-select="true"
                        data-pagination="true"
                        data-show-columns="true"
                        data-loadingFontSize="12px"
                        data-url="{{ route('getProduktListe',['id'=> $produktKategorie->id ]) }}">
                        <thead>
                        <tr>
                            <th data-field="id" data-radio="true"></th>
                            <th data-field="prod_nummer" data-sortable="true">Nummer</th>
                            <th data-field="created_at" data-sortable="true">Erstellt</th>
                            <th data-field="prod_name_kurz" data-sortable="true">Bezeichnung / Spezifikation</th>
                            <th data-field="prod_status" data-sortable="true">Status</th>
                            <th data-field="prod_active" data-sortable="true">Aktiv</th>
                            <th data-field="prod_link">Öffnen</th>
                        </tr>
                        </thead>
                    </table>

                </div>
                        <?php $r=false; ?>
                    @endforeach
            </div>



        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection


