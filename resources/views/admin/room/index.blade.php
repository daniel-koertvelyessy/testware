@extends('layout.layout-admin')

@section('pagetitle')
    Verwaltung &triangleright; Räume | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@stop

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Räume</li>
        </ol>
    </nav>

@endsection

@section('target-app-menu-item')

    {{--    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuLocations" role="button" data-toggle="dropdown" aria-expanded="false">
                Standorte
            </a>
            <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuLocations">
                <li><a class="dropdown-item" href="/location">Übersicht</a></li>
                <li><a class="dropdown-item" href="/location/create">Neu anlegen</a></li>
                <li><hr class="dropdown-divider"></li>
                @foreach( App\Location::all() as $locListItem)
                    <li><a class="dropdown-item" href="/room/{{  $locListItem->id  }}">{{  $locListItem->r_name_kurz  }}</a></li>
                @endforeach()
            </ul>
        </li>--}}

@endsection



@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">Übersicht Räume</h1>
            </div>
        </div>
        @if  (App\Room::all()->count() >0)
            <div class="row gx-5" id="locationListField">
                @foreach (App\Room::all() as $room)
                    <div class="col-md-6 col-lg-4 col-xl-3 locationListItem mb-lg-4 mb-sm-2" id="room_id_{{$room->id}}">
                        <div class="card" style="height:20em;">
                            <div class="card-header">
                                Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/{{ $room->building->location->id  }}">{{ $room->building->location->l_name_kurz  }}</a>
                                <i class="fas fa-angle-right"></i>
                                <a href="/building/{{ $room->building->id  }}">{{ $room->building->b_name_kurz  }}</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $room->r_name_kurz }}</h5>
                                <h6 class="card-subtitletext-muted">{{ $room->r_name_lang }}</h6>
                                <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                <p class="mt-0" style="height:6em;">{{ str_limit($room->r_name_text,100) }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{$room->path()}}" class="card-link"><i class="fas fa-chalkboard"></i> Übersicht</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-6">
                    <div class="card" >
                        <form action="/admin/room" method="post" class=" needs-validation">
                            @csrf
                            <div class="card-body">
                                <h5 class="card-title">Schnellstart</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Erstellen Sie den ersten Standort</h6>

                                <div class="form-group">
                                    <label for="r_name_kurz">Kurzbezeichnung (erforderlich, max 10 Zeichen)</label>
                                    <input type="text" name="r_name_kurz" id="r_name_kurz" class="form-control @error('r_name_kurz') ' is-invalid ' @enderror()" value="{{ old('r_name_kurz','') }}">
                                    @error('r_name_kurz')
                                    <span class="text-danger small">Die Kurzbezeichung ist zwingend notwendig!</span>
                                    @enderror()
                                </div>
                                <div class="form-group">
                                    <label for="r_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                    <input type="text" name="r_name_lang" id="r_name_lang" class="form-control" maxlength="100"  value="{{ old('r_name_lang','') }}">
                                </div>
                                <p class="card-text">Sie können später weitere Informationen anlegen</p>
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

{{--@section('autocompletefield')--}}

{{--@stop--}}

@section('autocomplete')



@endsection


@section('locationActionMenuItems')

    <div class="btn-group dropleft">
        <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Aktion
        </button>
        <ul class="dropdown-menu">
            <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Drucke Übersicht</a>
            <a class="dropdown-item" href="#"><i class="far fa-file-pdf"></i> Standortbericht</a>
        </ul>
    </div>

@endsection

