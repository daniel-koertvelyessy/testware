@extends('layout.layout-admin')

@section('pagetitle')
{{__('Übersicht Räume')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{__('Portal')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Räume')}}</li>
        </ol>
    </nav>

@endsection

@section('actionMenuItems')

{{--
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navTargetAppMenuRooms" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bars"></i> {{__('Aktionen')}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navTargetAppMenuRooms">
                <li><a class="dropdown-item" href="/location">Übersicht</a></li>
                <li><a class="dropdown-item" href="/location/create">Neu anlegen</a></li>
            </ul>
        </li>
--}}

@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Räume')}}</h1>
            </div>
        </div>
        @if(isset($roomList))
            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">{{__('Standort')}}</th>
                            <th>{{__('Gebäude')}}</th>
                            <th>{{__('Nummer')}}</th>
                            <th class="d-none d-md-table-cell">{{__('Name')}}</th>
                            <th>{{__('Typ')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
               @foreach ($roomList as $room)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                <a href="/location/{{ $room->building->location->id??''  }}">
                                    {{ $room->building->location->l_name_kurz??''  }}
                                </a>
                            </td>
                            <td><a href="/building/{{ $room->building->id  }}">{{ $room->building->b_name_kurz  }}</a></td>
                            <td>{{ $room->r_name_kurz }}</td>
                            <td class="d-none d-md-table-cell">{{ $room->r_name_lang }}</td>
                            <td>{{ $room->RoomType->rt_name_kurz }}</td>
                            <td>
                                <a href="{{$room->path()}}">
                                    <i class="fas fa-chalkboard"></i>
                                    <span class="d-none d-md-table-cell">{{__('Übersicht')}}</span>
                                </a>
                            </td>
                        </tr>
               @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $roomList->appends(['sort' => 'l_name_kurz'])->onEachSide(2)->links() !!}
                    </div>
                </div>
            </div>
        @else
            @if  (App\Room::all()->count() > 10)
                <nav class="d-flex justify-content-end align-items-center mb-2">

                    <button type="button"
                            class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                            data-targetid="#roomListField"
                            data-src="{{ route('getRoomListeAsTable') }}"
                    >
                        <i class="fas fa-list"></i>
                    </button>

                    <button type="button"
                            class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                            data-targetid="#roomListField"
                            data-src="{{ route('getRoomListeAsKachel') }}"
                    >
                        <i class="fas fa-th"></i>
                    </button>
                </nav>
                <div class="row gx-5" id="roomListField">
                    @foreach (App\Room::all() as $room)
                        <div class="col-md-6 col-lg-4 col-xl-3 locationListItem mb-lg-4 mb-sm-2" id="room_id_{{$room->id}}">
                            <div class="card" style="height:20em;">
                                <div class="card-header">
                                    Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                    <a href="/location/{{ $room->building->location->id??''  }}">{{ $room->building->location->l_name_kurz  }}</a>
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
                            <form action="{{ route('room.index') }}" method="post" class=" needs-validation">
                                @csrf
                                <div class="card-body">
                                    <h5 class="card-title">{{__('Schnellstart')}}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{__('Erstellen Sie den ersten Standort')}}</h6>

                                    <x-textfield id="r_name_kurz" label="Kurzbezeichnung" />

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
        @endif
    </div>

@endsection


