@extends('layout.layout-admin')

@section('pagetitle')
    Gebäudeverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gebäude</li>
        </ol>
    </nav>

@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">Übersicht Gebäude</h1>
            </div>
        </div>
        @if  (App\Building::all()->count() >0)
            <div class="row" id="buildingListField">
                @foreach (App\Building::all() as $building)
                    <div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="geb_id_{{$building->id}}">
                        <div class="card">
                            <div class="card-header">
                                Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/{{ $building->location->id  }}">{{ $building->location->l_name_kurz  }}</a>
                            </div>
                                <div class="card-body" style="height:18em;">
                                    <h5 class="card-title">{{ $building->BuildingType->btname }}: {{ $building->b_name_kurz }}</h5>
                                    <h6 class="card-subtitletext-muted">{{ $building->b_name_lang }}</h6>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Ort:</strong><span class="ml-2" >{{ $building->b_name_ort }}</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Räume:</strong><span class="ml-2" >{{ $building->rooms()->count() }}</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Stellplätze:</strong><span class="ml-2" >{{ $building->countStellPlatzs($building) }}</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                    <p class="mt-0" style="height:6em;">
                                        {{ str_limit($building->b_name_text,100) }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{$building->path()}}" class="card-link mr-auto"><i class="fas fa-chalkboard"></i> Übersicht</a>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-6">
                    <div class="card" >
                        <form action="/bulding" method="post" class=" needs-validation">
                            @csrf
                            <div class="card-body">
                                <h5 class="card-title">Schnellstart</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Erstellen Sie den ersten Standort</h6>
                                <div class="form-group">
                                    <label for="b_name_kurz">Kurzbezeichnung (erforderlich, max 10 Zeichen)</label>
                                    <input type="text" name="b_name_kurz" id="b_name_kurz" class="form-control @error('b_name_kurz') ' is-invalid ' @enderror()" value="{{ old('b_name_kurz','') }}">
                                    @error('b_name_kurz')
                                    <span class="text-danger small">Die Kurzbezeichung ist zwingend notwendig!</span>
                                    @enderror()
                                </div>
                                <div class="form-group">
                                    <label for="b_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                    <input type="text" name="b_name_lang" id="b_name_lang" class="form-control" maxlength="100"  value="{{ old('b_name_lang','') }}">
                                </div>
                                <p class="card-text">Sie können später weitere Informationen hinzufügen</p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-block"><i class="far fa-save"></i> Raum anlegen</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endif

    </div>

@endsection

@section('autocomplete')

@stop


@section('actionMenuItems')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="#">Drucke Übersicht</a>
            <a class="dropdown-item" href="#">Standortbericht</a>
            <a class="dropdown-item" href="#">Formularhilfe</a>
        </ul>
    </li>
@endsection()

