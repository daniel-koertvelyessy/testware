@extends('layout.layout-admin')

@section('pagetitle')
    {{ __('Gebäudeverwaltung') }} &triangleright; {{ __('Start') }}
@endsection

@section('mainSection')
    {{ __('memStandorte') }}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('portal-main') }}">{{ __('Portal') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storageMain') }}">{{ __('memStandorte') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.index') }}">{{ __('Standorte') }} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.show', $building->location) }}">{{ $building->location->l_label }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('building.index') }}">{{ __('Gebäude') }} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $building->b_label }}</li>
        </ol>
    </nav>
@endsection

@section('modals')
    <div class="modal" id="modalAddBuildingType" tabindex="-1" aria-labelledby="modalAddBuildingTypeLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createBuildingType') }}" method="POST" class="needs-validation"
                    id="frmCreateBuildingType" name="frmCreateBuildingType">
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
                            <label for="btname">{{ __('Name') }}</label>
                            <input type="text" name="btname" id="btname"
                                class="form-control {{ $errors->has('btname') ? ' is-invalid ' : '' }}"
                                value="{{ old('btname') ?? '' }}" required>
                            @if ($errors->has('btname'))
                                <span class="text-danger small">{{ $errors->first('btname') }}</span>
                            @else
                                <span class="small text-primary">{{ __('erforderlich, maximal 20 Zeichen') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <x-textarea id="btbeschreibung" label="{{ __('Beschreibung des Gebäudetyps') }}" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Abbruch') }}
                        </button>
                        <button type="submit" class="btn btn-primary">{{ __('Gebäudetyp speichern') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalAddRoomType" tabindex="-1" aria-labelledby="modalAddRoomTypeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createRoomType') }}" method="POST" class="needs-validation" id="frmCreateRoomType"
                    name="frmCreateRoomType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddRoomTypeLabel">{{ __('Neuen Raumtyp erstellen') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateRoomType" value="building">
                        @csrf
                        <div class="form-group">
                            <label for="rt_label">{{ __('Kürzel') }}</label>
                            <input type="text" name="rt_label" id="rt_label"
                                class="form-control {{ $errors->has('rt_label') ? ' is-invalid ' : '' }}"
                                value="{{ old('rt_label') ?? '' }}" required>
                            @if ($errors->has('rt_label'))
                                <span class="text-danger small">{{ $errors->first('rt_label') }}</span>
                            @else
                                <span class="small text-primary">{{ __('erforderlich, maximal 20 Zeichen') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_name">{{ __('Name') }}</label>
                            <input type="text" name="rt_name" id="rt_name"
                                class="form-control {{ $errors->has('rt_name') ? ' is-invalid ' : '' }}"
                                value="{{ old('rt_name') ?? '' }}">
                            @if ($errors->has('rt_name'))
                                <span class="text-danger small">{{ $errors->first('rt_name') }}</span>
                            @else
                                <span class="small text-primary">{{ __('maximal 100 Zeichen') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_description">{{ __('Beschreibung des Raumtyps') }}</label>
                            <textarea id="rt_description" name="rt_description" class="form-control">{{ old('rt_description') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Abbruch') }}
                        </button>
                        <button type="submit" class="btn btn-primary">{{ __('Raumtyp speichern') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-modal-add-note objectname="{{ $building->b_label }}" uid="{{ $building->storage_id }}" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <h1 class="h3">
                    <span class="d-none d-md-inline">{{ 'Übersicht Gebäude' }} </span>
                    <span>{{ $building->b_label }}</span>
                </h1>

                {{--                <div class="visible-print text-center">
                                    {!! QrCode::size(65)->generate($building->storage_id) !!}
                                    <p class="text-muted small">Standort-ID</p>
                                </div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" id="gebStammDaten-tab" data-toggle="tab" href="#gebStammDaten"
                            role="tab" aria-controls="gebStammDaten" aria-selected="true">{{ __('Stammdaten') }}</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="gebRooms-tab" data-toggle="tab" href="#gebRooms" role="tab"
                            aria-controls="gebRooms" aria-selected="false">{{ __('Räume') }} <span
                                class="badge {{ $building->room->count() >= 0
                                    ? ' badge-info '
                                    : '
                                                                                                                                                                                        badge-light ' }} ">{{ $building->room->count() }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="locNotes-tab" data-toggle="tab" href="#notes" role="tab"
                            aria-controls="locNotes" aria-selected="false">{{ __('Notizen') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="gebStammDaten" role="tabpanel"
                        aria-labelledby="gebStammDaten-tab">
                        <form action="{{ route('building.update', $building) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="storage_id" id="storage_id"
                                value="{{ $building->storage_id }}">
                            <input type="hidden" name="id" id="id" value="{{ $building->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2 class="h5">{{ 'Standort' }}</h2>
                                    <x-selectfield id="location_id" label="{{ __('ist zugeordnet') }}">
                                        @foreach (App\Location::all() as $loc)
                                            <option value="{{ $loc->id }}"
                                                {{ $loc->id === $building->location_id ? ' selected ' : '' }}>
                                                {{ $loc->l_label }}
                                            </option>
                                        @endforeach
                                    </x-selectfield>
                                    <h2 class="h5">{{ 'Bezeichner' }}</h2>

                                    <x-textfield id="b_label" label="{{ __('Kürzel') }}"
                                        value="{{ $building->b_label }}" max="20" required />

                                    <x-textfield id="b_name_ort" label="{{ __('Ort') }}"
                                        value="{{ $building->b_name_ort }}" max="100" />

                                    <x-textfield id="b_name" label="{{ __('Name') }}"
                                        value="{{ $building->b_name }}" max="100" />
                                    <x-textarea id="b_description" label="{{ __('Beschreibung') }}"
                                        value="{{ $building->b_description }}" />

                                </div>
                                <div class="col-lg-6">
                                    <h2 class="h5">{{ __('Eigenschaften') }}</h2>
                                    <x-selectModalgroup id="building_type_id" label="{{ __('neu anlegen') }}"
                                        modalid="modalAddBuildingType" btnL="neu">
                                        @foreach (App\BuildingTypes::all() as $bty)
                                            <option value="{{ $bty->id }}"
                                                {{ $bty->id === $building->building_type_id ? ' selected ' : '' }}>
                                                {{ $bty->btname }}</option>
                                        @endforeach
                                    </x-selectModalgroup>

                                    <h2 class="h5">{{ __('Wareneingang') }}</h2>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="b_we_has" name="b_we_has"
                                                {{ $building->b_we_has === 1 ? ' checked ' : '' }}>
                                            <label class="form-check-label" for="b_we_has">
                                                {{ __(' Wareneingang vorhanden') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="b_we_name">{{ __('WE Bezeichnung (max 100 Zeichen)') }}</label>
                                        <input type="text" name="b_we_name" id="b_we_name" class="form-control"
                                            maxlength="100" value="{{ $building->b_we_name ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <x-btnMain>{{ __('Stammdaten speichern') }} <span
                                    class="fas fa-download
                            ml-2"></span></x-btnMain>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="gebRooms" role="tabpanel" aria-labelledby="gebRooms-tab">
                        <div class="row">
                            <div class="col">
                                <form class="row gy-2 gx-3  my-3" action="{{ route('room.store') }}#gebRooms"
                                    method="post" name="frmAddNewRoom" id="frmAddNewRoom">
                                    @csrf
                                    <input type="hidden" name="storage_id" id="room_storage_id"
                                        value="{{ Str::uuid() }}">
                                    <input type="hidden" name="building_id" id="building_id"
                                        value="{{ $building->id }}">
                                    <input type="hidden" name="frmOrigin" id="frmOrigin" value="building">
                                    <div class="col-auto">
                                        <x-rtextfield id="r_label" label=""
                                            placeholder="{{ __('Raum Nummer') }}" hideLabel="1" />

                                    </div>
                                    <div class="col-auto">
                                        <x-textfield id="r_name" placeholder="{{ __('Raum Bezeichnung') }}"
                                            max="100" hideLabel="1" />

                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <label for="room_type_id" class="sr-only">Raumtyp angeben
                                            </label>
                                            <select name="room_type_id" id="room_type_id" class="custom-select">
                                                @foreach (\App\RoomType::all() as $roomType)
                                                    <option value="{{ $roomType->id }}">{{ $roomType->rt_label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary ml-2"
                                                data-toggle="modal" data-target="#modalAddRoomType"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>

                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" {{-- @if (!env('app.makeobjekte')) disabled @endif --}} class="btn btn-primary">Neuen Raum
                                            anlegen
                                        </button>
                                    </div>
                                </form>
                                @if ($building->room->count() > 0)
                                    <table class="table table-responsive-md table-striped" id="tabRoomListe">
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
                                            @foreach ($building->room as $room)
                                                <tr>
                                                    <td>{{ $room->r_label }}</td>
                                                    <td>{{ $room->r_name }}</td>
                                                    <td>{{ \App\RoomType::find($room->room_type_id)->rt_label }}</td>
                                                    <td>{{ $room->stellplatzs()->count() }}</td>
                                                    <td class="text-right">
                                                        <x-menu_context :object="$room"
                                                            routeOpen="{{ route('room.show', $room) }}"
                                                            routeCopy="{{ route('copyRoom', $room) }}"
                                                            routeDestory="{{ route('room.destroy', $room) }}"
                                                            tabName="gebRooms" objectVal="{{ $room->r_label }}"
                                                            objectName="r_label" />

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <x-tab-note uid="{{ $building->storage_id }}" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('actionMenuItems')
    {{--    <li class="nav-item dropdown"> --}}
    {{--        <a class="nav-link dropdown-toggle disabled" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a> --}}
    {{--        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems"> --}}
    {{--            <a class="dropdown-item" href="#">Drucke Übersicht</a> --}}
    {{--            <a class="dropdown-item" href="#">Standortbericht</a> --}}
    {{--            <a class="dropdown-item" href="#">Formularhilfe</a> --}}
    {{--        </ul> --}}
    {{--    </li> --}}
@endsection()

@section('scripts')
    @if ($errors->has('btname'))
        <script>
            $('#modalAddBuildingType').modal('show');
        </script>
    @endif
    @if ($errors->has('rt_label'))
        <script>
            $('#modalAddRoomType').modal('show');
        </script>
    @endif

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

    <script>
        $('#tabRoomListe').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
            },
            "columnDefs": [{
                "orderable": false,
                "targets": 4
            }],
            "dom": 't'
        });

        $('.btnDeleteRoom').click(function() {
            const rommId = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('room.destroyRoomAjax') }}",
                data: $('#frmDeleteRoom_' + rommId).serialize(),
                success: function(res) {
                    if (res) location.reload();
                }
            });
        });
        $('.copyRoom').click(function() {
            const id = $(this).data('objid');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('copyRoom') }}",
                data: {
                    id
                },
                success: (res) => {
                    if (res > 0) location.reload();

                }
            });
        });
    </script>
@endsection
