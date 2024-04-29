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
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('storageMain') }}">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.index') }}">{{__('Standorte')}} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.show', $stellplatz->location) }}">{{ $stellplatz->location->l_label }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('building.index') }}">{{__('Gebäude')}} <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{  $stellplatz->b_label  }}</li>
        </ol>
    </nav> --}}
@endsection

@section('modals')
    <div class="modal" id="modalAddCompartmentType" tabindex="-1" aria-labelledby="modalAddCompartmentTypeLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createStellPlatzType') }}" method="POST" class="needs-validation"
                    id="frmCreateStellplatzType" name="frmCreateStellplatzType">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddCompartmentTypeLabel">Neuen Gebäudetyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateStellplatzType" value="location">
                        @csrf
                        <div class="form-group">
                            <label for="sp_name">Name</label>
                            <input type="text" name="sp_name" id="sp_name"
                                class="form-control {{ $errors->has('sp_name') ? ' is-invalid ' : '' }}"
                                value="{{ old('sp_name') ?? '' }}" required>
                            @if ($errors->has('sp_name'))
                                <span class="text-danger small">{{ $errors->first('sp_name') }}</span>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch
                        </button>
                        <button type="submit" class="btn btn-primary">Gebäudetyp speichern
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
                        <h5 class="modal-title" id="modalAddRoomTypeLabel">Neuen Raumtyp erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="frmOrigin" id="frmOriginCreateRoomType" value="building">
                        @csrf
                        <div class="form-group">
                            <label for="rt_label">Name</label>
                            <input type="text" name="rt_label" id="rt_label"
                                class="form-control {{ $errors->has('rt_label') ? ' is-invalid ' : '' }}"
                                value="{{ old('rt_label') ?? '' }}" required>
                            @if ($errors->has('rt_label'))
                                <span class="text-danger small">{{ $errors->first('rt_label') }}</span>
                            @else
                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_name">Name lang</label>
                            <input type="text" name="rt_name" id="rt_name"
                                class="form-control {{ $errors->has('rt_name') ? ' is-invalid ' : '' }}"
                                value="{{ old('rt_name') ?? '' }}">
                            @if ($errors->has('rt_name'))
                                <span class="text-danger small">{{ $errors->first('rt_name') }}</span>
                            @else
                                <span class="small text-primary">maximal 100 Zeichen</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rt_description">Beschreibung des Raumtyps</label>
                            <textarea id="rt_description" name="rt_description" class="form-control">{{ old('rt_description') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbruch
                        </button>
                        <button type="submit" class="btn btn-primary">Raumtyp speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-modal-add-note objectname="{{ $stellplatz->sp_label }}" uid="{{ $stellplatz->storage_id }}" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <h1 class="h3"><span class="d-none d-md-inline">{{ 'Übersicht Stellplatz' }}
                    </span>{{ $stellplatz->sp_label }}</h1>
                {{--                <div class="visible-print text-center">
                                    {!! QrCode::size(65)->generate($stellplatz->storage_id) !!}
                                    <p class="text-muted small">Standort-ID</p>
                                </div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" id="compartmentBaseData-tab" data-toggle="tab"
                            href="#compartmentBaseData" role="tab" aria-controls="compartmentBaseData"
                            aria-selected="true">{{ 'Stammdaten' }}</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="equipment-tab" data-toggle="tab" href="#equipment" role="tab"
                            aria-controls="equipment" aria-selected="false">{{ 'Geräte' }} <span
                                class="badge {{ $stellplatz->countTotalEquipmentInCompartment() >= 0 ? ' badge-info ' : ' badge-light ' }} ">{{ $stellplatz->countTotalEquipmentInCompartment() }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="locNotes-tab" data-toggle="tab" href="#notes" role="tab"
                            aria-controls="locNotes" aria-selected="false">{{ __('Notizen') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active p-2" id="compartmentBaseData" role="tabpanel"
                        aria-labelledby="compartmentBaseData-tab">
                        <form action="{{ route('stellplatz.update', $stellplatz) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="storage_id" id="storage_id"
                                value="{{ $stellplatz->storage_id }}">
                            <input type="hidden" name="id" id="id" value="{{ $stellplatz->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-textfield id="sp_label" label="{{ __('Kürzel') }}" required max="20"
                                        value="{{ $stellplatz->sp_label }}" />
                                </div>
                                <div class="col-md-6">
                                    <x-selectfield id="room_id" label="{{ __('Raum') }}">
                                        @foreach (\App\Room::all() as $room)
                                            <option value="{{ $room->id }}"
                                                {{ $room->id === $stellplatz->room_id ? ' selected ' : '' }}>
                                                {{ $room->r_name }}</option>
                                        @endforeach
                                    </x-selectfield>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-textfield id="sp_name" label="{{ __('Name') }}"
                                        value="{{ $stellplatz->sp_name }}" />
                                </div>
                                <div class="col-md-6">
                                    <x-selectgroup id="stellplatz_typ_id" label="{{ __('Typ') }}" btnL="Neu">
                                        @foreach (App\StellplatzTyp::all() as $stellplatzTyp)
                                            <option value="{{ $stellplatzTyp->id }}"
                                                {{ $stellplatzTyp->id === $stellplatz->stellplatz_typ_id ? ' selected ' : '' }}>
                                                {{ $stellplatzTyp->spt_name }}
                                            </option>
                                        @endforeach
                                    </x-selectgroup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <x-textarea id="sp_description" label="{{ __('Beschreibung') }}"
                                        value="{{ $stellplatz->sp_description }}" />
                                </div>
                            </div>
                            <x-btnMain>{{ __('Stammdaten speichern') }} <span
                                    class="fas fa-download ml-2"></span></x-btnMain>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="equipment" role="tabpanel" aria-labelledby="equipment-tab">
                        <div class="row">
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <x-tab-note uid="{{ $stellplatz->storage_id }}" />
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
    @if ($errors->has('sp_name'))
        <script>
            $('#modalAddCompartmentType').modal('show');
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
