@extends('layout.layout-admin')

@section('mainSection')
    Standorte
@endsection

@section('pagetitle')
    Raum {{  $room->r_name_kurz  }} &triangleright;   Raumverwaltung &triangleright; Portal @ bitpack GmbH
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.index') }}">Standort </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.show', $room->building->location) }}"> {{ $room->building->location->l_name_kurz }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('building.index') }}">Gebäude</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('building.index', $room->building) }}"> {{ $room->building->b_name_kurz }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('room.index') }}">Räume <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Raum {{  $room->r_name_kurz  }}
            </li>
        </ol>
    </nav>
@endsection

@section('modals')

    <div class="modal" id="modalAddStellPlatzType" tabindex="-1" aria-labelledby="modalAddStellPlatzTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createStellPlatzType') }}" method="POST" class="needs-validation" id="frmCreateRoomType" name="frmCreateRoomType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddStellPlatzTypeLabel">Neuen Stellplatztyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateStellPlatzType" value="room">
                        <input type="hidden" name="room_id" id="room_id" value="{{ $room->id }}">
                        @csrf
                        <x-rtextfield id="spt_name_kurz" label="Kürzel" />
                        <x-textfield id="spt_name_lang" label="Beschreibung" />
                        <x-textarea id="spt_name_text" label="Beschreibung des Typs" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button type="submit" class="btn btn-primary">Stellplatztyp speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <h1 class="h3"><span class="d-none d-md-inline">Übersicht Raum </span>{{ $room->r_name_kurz }}</h1>
          {{--      <div class="visible-print text-center">
                    {!! QrCode::size(65)->generate($room->standort_id); !!}
                    <p class="text-muted small">Standort-ID</p>
                </div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" id="roomStammDaten-tab" data-toggle="tab" href="#roomStammDaten" role="tab" aria-controls="roomStammDaten" aria-selected="true">Stammdaten</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="roomStellPlatze-tab" data-toggle="tab" href="#roomStellPlatze" role="tab" aria-controls="roomStellPlatze" aria-selected="false">Stellplätze <span class="badge {{ ($room->stellplatzs()->count()>0)? ' badge-info ' : '' }} ">{{ $room->stellplatzs()->count() }}</span></a>
                    </li>
{{--                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="roomEquip-tab" data-toggle="tab" href="#roomEquip" role="tab" aria-controls="roomEquip" aria-selected="false">Geräte</a>
                    </li>--}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2 " id="roomStammDaten" role="tabpanel" aria-labelledby="roomStammDaten-tab">
                        <form action="{{ route('room.update',['room'=>$room->id]) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <x-selectfield id="building_id" label="Raum befindet sich im Gebäude">
                                        @foreach (App\Building::all() as $bul)
                                            <option value="{{ $bul->id }}" {{ ($bul->id === $room->building_id) ? ' selected ' : '' }}>{{ $bul->b_name_kurz }}</option>
                                        @endforeach
                                    </x-selectfield>

                                    <div class="form-group">
                                        <label for="room_type_id"> </label>
                                        <div class="input-group">
                                            <select name="room_type_id" id="room_type_id" class="custom-select">
                                                @foreach (App\RoomType::all() as $bty)
                                                    <option value="{{ $bty->id }}" {{ ($bty->id === $room->room_type_id ) ? ' selected ' : '' }}>{{ $bty->rt_name_kurz }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-primary ml-2" data-toggle="modal" data-target="#modalAddStellPlatzType"><i class="fas fa-plus"></i><span class="d-none d-md-inline"> Raumtyp neu anlegen</span></button>

                                        </div>
                                    </div>
                                    <x-rtextfield id="r_name_kurz" label="Kurzbezeichnung" value="{{ $room->r_name_kurz }}"/>
                                    <x-textfield id="r_name_lang" label="Bezeichnung" value="{{ $room->r_name_lang }}"/>
                                    <x-textarea id="r_name_text" label="Beschreibung" value="{{ $room->r_name_text }}"/>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Stammdaten speichern</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="roomStellPlatze" role="tabpanel" aria-labelledby="roomStellPlatze-tab">
                        <div class="row">
                            <div class="col">
                                <form class="row gy-2 gx-3  my-3" action="{{ route('stellplatz.store') }}#roomStellPlatze" method="post" name="frmAddNewStellPlatz" id="frmAddNewStellPlatz">
                                    <input type="hidden"
                                           name="standort_id"
                                           id="standort_id"
                                           value="{{ \Illuminate\Support\Str::uuid() }}"
                                    >
                                    @csrf
                                    <input type="hidden" name="room_id" id="room_id_{{ $room->id }}" value="{{ $room->id }}">
                                    <input type="hidden" name="frmOrigin" id="frmOriginAddNewStellPlatz" value="room">
                                    <div class="col-auto">
                                        <label class="sr-only" for="sp_name_kurz">Name kurz</label>
                                        <input type="text" class="form-control" id="sp_name_kurz" name="sp_name_kurz" required placeholder="Stellplatz Name" value="{{ old('sp_name_kurz')??'' }}">
                                        @if ($errors->has('sp_name_kurz'))
                                            <span class="text-danger small">{{ $errors->first('sp_name_kurz') }}</span>
                                        @else
                                            <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <label class="sr-only" for="sp_name_lang">Beschreibung kurz</label>
                                        <input type="text" class="form-control" id="sp_name_lang" name="sp_name_lang" placeholder="Stellplatz Nummer" value="{{ old('sp_name_lang')??'' }}">
                                        @if ($errors->has('sp_name_lang'))
                                            <span class="text-danger small">{{ $errors->first('sp_name_lang') }}</span>
                                        @else
                                            <span class="small text-primary">maximal 100 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <label for="stellplatz_typ_id" class="sr-only">Stellplatz Typ angeben</label>
                                            <select name="stellplatz_typ_id" id="stellplatz_typ_id" class="custom-select">
                                                @foreach (\App\StellplatzTyp::all() as $roomType)
                                                    <option value="{{ $roomType->id }}" title="{{ $roomType->spt_name_lang  }}">{{ $roomType->spt_name_kurz  }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalAddStellPlatzType"><i class="fas fa-plus"></i></button>
                                        </div>
                                        <span class="small text-primary">Stellplatztyp</span>
                                    </div>
                                    <div class="col-auto">
                                        <button {{--@if (!env('app.makeobjekte') ) disabled @endif --}} type="submit" class="btn btn-primary">Neuen Stellplatz anlegen</button>
                                    </div>
                                </form>
                                @if ($room->stellplatzs()->count()>0)
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Platz</th>
                                            <th>Nummer</th>
                                            <th>Typ</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($room->stellplatzs as $spl)
                                            <tr>
                                                <td>{{ $spl->sp_name_kurz }}</td>
                                                <td>{{ $spl->sp_name_lang }}</td>
                                                <td>{{ \App\StellplatzTyp::find($spl->stellplatz_typ_id)->spt_name_kurz }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm btnDeleteStellPlatzItem" data-spid="{{ $spl->id }}"><span class="far fa-trash-alt"></span></button>
                                                    <form action="{{ route('destroyStellplatzAjax',$spl->id) }}" id="frmDeleteStellplatzItem_{{ $spl->id }}" target="_blank">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="id" id="id_{{ $spl->id }}" value="{{ $spl->id }}">
                                                        <input type="hidden" name="frmOrigin" id="frmOrigin_{{ $spl->id }}" value="room">
                                                        <input type="hidden" name="sp_name_kurz" id="sp_name_kurz{{ $spl->id }}" value="{{ $spl->sp_name_kurz }}">
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--<div class="tab-pane fade" id="roomEquip" role="tabpanel" aria-labelledby="roomEquip-tab">
                        <div class="row">
                            <div class="col">
                                <h2 class="h6">Folgende Geräte sind dem Standort zugeteilt</h2>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->has('spt_name_kurz'))
        <script>
            $('#modalAddStellPlatzType').modal('show');
        </script>
    @endif

    <script>
        $('.btnDeleteStellPlatzItem').click(function () {
            const spid = $(this).data('spid');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('destroyStellplatzAjax') }}",
                data: $('#frmDeleteStellplatzItem_'+spid).serialize(),
                success: function (res) {
                    if(res) location.reload();
                }
            });
        });
    </script>
@endsection

@section('locationActionMenuItems')

    <div class="btn-group dropleft">
        <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Aktion
        </button>
        <ul class="dropdown-menu">
            <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Drucke Übersicht</a>
            <a class="dropdown-item" href="#"><i class="far fa-file-pdf"></i> Standortbericht</a>
        </ul>
    </div>

@endsection()

