@extends('layout.layout-admin')

@section('pagetitle')
    Gebäudeverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('standorteMain') }}">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Standorte</a></li>
            <li class="breadcrumb-item"><a href="{{ route('location.show', $building->location) }}">{{ $building->location->l_name_kurz }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('building.index') }}">Gebäude</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{  $building->b_name_kurz  }}</li>
        </ol>
    </nav>
@endsection

@section('modals')
    <div class="modal" id="modalAddBuildingType" tabindex="-1" aria-labelledby="modalAddBuildingTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createBuildingType') }}" method="POST" class="needs-validation" id="frmCreateBuildingType" name="frmCreateBuildingType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddBuildingTypeLabel">Neuen Gebäudetyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateBuildingType" value="location">
                        @csrf
                        <div class="form-group">
                            <label for="btname">Name</label>
                            <input type="text" name="btname" id="btname" class="form-control {{ $errors->has('btname') ? ' is-invalid ': '' }}" value="{{ old('btname') ?? '' }}" required>
                            @if ($errors->has('btname'))
                                <span class="text-danger small">{{ $errors->first('btname') }}</span>
                            @else
                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="btbeschreibung">Beschreibung des Gebäudetyps</label>
                            <textarea id="btbeschreibung" name="btbeschreibung" class="form-control">{{ old('btbeschreibung') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button type="submit" class="btn btn-primary">Gebäudetyp speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalAddRoomType" tabindex="-1" aria-labelledby="modalAddRoomTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createRoomType') }}" method="POST" class="needs-validation" id="frmCreateRoomType" name="frmCreateRoomType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddRoomTypeLabel">Neuen Raumtyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateRoomType" value="building">
                        @csrf
                        <div class="form-group">
                            <label for="rt_name_kurz">Name</label>
                            <input type="text" name="rt_name_kurz" id="rt_name_kurz" class="form-control {{ $errors->has('rt_name_kurz') ? ' is-invalid ': '' }}" value="{{ old('rt_name_kurz') ?? '' }}" required>
                            @if ($errors->has('rt_name_kurz'))
                                <span class="text-danger small">{{ $errors->first('rt_name_kurz') }}</span>
                            @else
                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_name_lang">Name lang</label>
                            <input type="text" name="rt_name_lang" id="rt_name_lang" class="form-control {{ $errors->has('rt_name_lang') ? ' is-invalid ': '' }}" value="{{ old('rt_name_lang') ?? '' }}">
                            @if ($errors->has('rt_name_lang'))
                                <span class="text-danger small">{{ $errors->first('rt_name_lang') }}</span>
                            @else
                                <span class="small text-primary">maximal 100 Zeichen</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_name_text">Beschreibung des Raumtyps</label>
                            <textarea id="rt_name_text" name="rt_name_text" class="form-control">{{ old('rt_name_text') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch</button>
                        <button type="submit" class="btn btn-primary">Raumtyp speichern</button>
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
                <h1 class="h3"><span class="d-none d-md-inline">Übersicht Gebäude </span>{{ $building->b_name_kurz }}</h1>
{{--                <div class="visible-print text-center">
                    {!! QrCode::size(65)->generate($building->standort_id); !!}
                    <p class="text-muted small">Standort-ID</p>
                </div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" id="gebStammDaten-tab" data-toggle="tab" href="#gebStammDaten" role="tab" aria-controls="gebStammDaten" aria-selected="true">Stammdaten</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="gebRooms-tab" data-toggle="tab" href="#gebRooms" role="tab" aria-controls="gebRooms" aria-selected="false">Räume <span class="badge {{ ($building->rooms->count()>=0)? ' badge-info ' :' badge-light ' }} ">{{ $building->rooms->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="gebStammDaten" role="tabpanel" aria-labelledby="gebStammDaten-tab">
                        <form action="{{ route('building.update',$building) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2 class="h5">Standort</h2>
                                    <div class="form-group">
                                        <label for="location_id">ist zugeordnet</label>
                                        <select name="location_id" id="location_id" class="custom-select">
                                            @foreach (App\Location::all() as $loc)
                                                <option value="{{ $loc->id }}" {{ ($loc->id === $building->locations_id) ? ' selected ' : '' }}>{{ $loc->l_name_kurz }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <h2 class="h5">Bezeichner</h2>
                                    <div class="form-group">
                                        <label for="b_name_kurz">Kurzbezeichnung (max 10 Zeichen)</label>
                                        <input type="text" name="b_name_kurz" id="b_name_kurz" class="form-control {{ $errors->has('b_name_kurz') ? ' is-invalid ': '' }}" maxlength="10" value="{{ $building->b_name_kurz }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="b_name_ort">Ort (max 100 Zeichen)</label>
                                        <input type="text" name="b_name_ort" id="b_name_ort" class="form-control" maxlength="100" value="{{ $building->b_name_ort ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="b_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                        <input type="text" name="b_name_lang" id="b_name_lang" class="form-control" maxlength="100" value="{{ $building->b_name_lang ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="b_name_text">Beschreibung</label>
                                        <textarea name="b_name_text" id="b_name_text" class="form-control" rows="3">{{ $building->b_name_text ?? '' }}</textarea>
                                    </div>


                                </div>
                                <div class="col-lg-6">
                                    <h2 class="h5">Eigenschaften</h2>
                                    <div class="form-group">
                                        <label for="building_type_id">Gebäudetyp festlegen </label>
                                        <div class="input-group">
                                            <select name="building_type_id" id="building_type_id" class="custom-select">
                                                @foreach (App\BuildingTypes::all() as $bty)
                                                    <option value="{{ $bty->id }}" {{ ($bty->id === $building->building_type_id ) ? ' selected ' : '' }}>{{ $bty->btname }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalAddBuildingType"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <h2 class="h5">Wareneingang</h2>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="b_we_has" name="b_we_has" {{ ($building->b_we_has === 1) ? ' checked ' : '' }}>
                                            <label class="form-check-label" for="b_we_has">
                                                Wareneingang vorhanden
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="b_we_name">WE Bezeichnung (max 100 Zeichen)</label>
                                        <input type="text" name="b_we_name" id="b_we_name" class="form-control" maxlength="100" value="{{ $building->b_we_name ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Stammdaten speichern</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="gebRooms" role="tabpanel" aria-labelledby="gebRooms-tab">
                        <div class="row">
                            <div class="col">
                                <form class="row gy-2 gx-3  my-3" action="{{ route('room.store') }}#gebRooms" method="post"
                                      name="frmAddNewRoom" id="frmAddNewRoom"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="standort_id"
                                           id="standort_id"
                                           value="{{ Str::uuid() }}"
                                    >
                                    <input type="hidden" name="building_id" id="building_id" value="{{ $building->id }}">
                                    <input type="hidden" name="frmOrigin" id="frmOrigin" value="building">
                                    <div class="col-auto">
                                        <label class="sr-only" for="r_name_kurz">Raum Nummer</label>
                                        <input type="text" class="form-control" id="r_name_kurz" name="r_name_kurz" required placeholder="Raum Nummer" value="{{ old('r_name_kurz')??'' }}">
                                        @if ($errors->has('r_name_kurz'))
                                            <span class="text-danger small">{{ $errors->first('r_name_kurz') }}</span>
                                        @else
                                            <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <label class="sr-only" for="r_name_lang">Raum Bezeichnung, maximal 100 Zeichen</label>
                                        <input type="text" class="form-control" id="r_name_lang" name="r_name_lang" placeholder="Raum Bezeichnung" value="{{ old('r_name_lang')??'' }}">
                                        @if ($errors->has('r_name_lang'))
                                            <span class="text-danger small">{{ $errors->first('r_name_lang') }}</span>
                                        @else
                                            <span class="small text-primary">maximal 100 Zeichen</span>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <label for="room_type_id" class="sr-only">Raumtyp angeben</label>
                                            <select name="room_type_id" id="room_type_id" class="custom-select">
                                                @foreach (\App\RoomType::all() as $roomType)
                                                    <option value="{{ $roomType->id }}">{{ $roomType->rt_name_kurz  }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary ml-2" data-toggle="modal" data-target="#modalAddRoomType"><i class="fas fa-plus"></i></button>
                                        </div>


                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" {{-- @if (!env('app.makeobjekte') ) disabled @endif --}} class="btn btn-primary">Neuen Raum anlegen</button>
                                    </div>
                                </form>
                                @if ($building->rooms->count()>0)
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nummer</th>
                                            <th>Bezeichnung</th>
                                            <th>Typ</th>
                                            <th>Stellplätze</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($building->rooms as $room)
                                            <tr>
                                                <td>{{ $room->r_name_kurz }}</td>
                                                <td>{{ $room->r_name_lang }}</td>
                                                <td>{{ \App\RoomType::find($room->room_type_id)->rt_name_kurz }}</td>
                                                <td>{{ $room->stellplatzs()->count() }}</td>
                                                <td>
                                                    <div class="btn-group dropleft">
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-primary"
                                                                id="editObjekt{{ $room->id }}"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        >
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="editObjekt{{ $room->id }}">
                                                            <a href="{{ route('room.show',$room) }}"
                                                               class="dropdown-item d-flex justify-content-between align-items-center"
                                                               title="Raum ansehen"
                                                            >
                                                                Öffnen <i class="fas fa-angle-right"></i>
                                                            </a>
                                                            <a href="#" class="btnDeleteRoom dropdown-item d-flex justify-content-between align-items-center"
                                                               data-id="{{ $room->id }}"
                                                            >
                                                                Löschen
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>

                                                            <a href="#"
                                                               class="dropdown-item d-flex justify-content-between align-items-center copyRoom {{-- @if (!env('app.makeobjekte') ) disabled @endif --}} "
                                                               data-objid="{{ $room->id }}"
                                                            >Kopieren
                                                                <i class="fas fa-copy"></i>
                                                            </a>
                                                            <form action="{{ route('room.destroy',$room->id) }}" id="frmDeleteRoom_{{ $room->id }}" target="_blank">
                                                                @csrf
                                                                @method('delete')
                                                                <input type="hidden" name="id" id="id_{{ $room->id }}" value="{{ $room->id }}">
                                                                <input type="hidden" name="frmOrigin" id="frmOrigin_{{ $room->id }}" value="building">
                                                                <input type="hidden" name="r_name_kurz" id="r_name_kurz_{{ $room->id }}" value="{{ $room->r_name_kurz }}">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('actionMenuItems')
{{--    <li class="nav-item dropdown">--}}
{{--        <a class="nav-link dropdown-toggle disabled" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>--}}
{{--        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">--}}
{{--            <a class="dropdown-item" href="#">Drucke Übersicht</a>--}}
{{--            <a class="dropdown-item" href="#">Standortbericht</a>--}}
{{--            <a class="dropdown-item" href="#">Formularhilfe</a>--}}
{{--        </ul>--}}
{{--    </li>--}}
@endsection()

@section('scripts')
    @if ($errors->has('btname'))
        <script>
            $('#modalAddBuildingType').modal('show');
        </script>
    @endif
    @if ($errors->has('rt_name_kurz'))
        <script>
            $('#modalAddRoomType').modal('show');
        </script>
    @endif

    <script>
        $('.btnDeleteRoom').click(function () {
            const rommId = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('room.destroyRoomAjax') }}",
                data: $('#frmDeleteRoom_'+rommId).serialize(),
                success: function (res) {
                    if(res) location.reload();
                }
            });
        });
        $('.copyRoom').click(function () {
            const id = $(this).data('objid');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('copyRoom') }}",
                data: {id},
                success: (res) => {
                    if (res>0) location.reload();

                }
            });
        });
    </script>
@endsection
