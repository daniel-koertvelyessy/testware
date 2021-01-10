@extends('layout.layout-admin')

@section('pagetitle')
{{__('Explorer')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('modals')
    <div class="modal"
         id="modalSetBuilding"
         tabindex="-1"
         aria-labelledby="modalSetBuildingLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('building.modal') }}#Explorer"
                      method="POST"
                      class="needs-validation"
                      id="frmModalSetBuilding"
                      name="frmModalSetBuilding"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalSetBuildingLabel"
                        >{{__('Gebäude erstellen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="modalType"
                               id="modalType"
                        >
                        <input type="hidden"
                               name="id"
                               id="id_modal"
                        >
                        <input type="hidden"
                               name="location_id"
                               id="location_id_modal"
                               value="{{ $location->id }}"
                        >
                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_building"
                               value="{{ Str::uuid() }}"
                        >

                        <x-textfield id="b_label"
                                     label="{{ __('Kurzbezeichnung') }}"
                                     required
                                     max="20"
                        />

                        <x-textfield id="b_name_ort"
                                     label="{{ __('Ort') }}"
                        />

                        <x-textfield id="b_name"
                                     label="{{ __('Bezeichnung') }}"
                        />

                        <x-textarea id="b_name_text"
                                    label="{{ __('Beschreibung') }}"
                        />

                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="h5">{{__('Eigenschaften')}}</h2>
                                <label for="building_type_id">{{__('Gebäudetyp festlegen')}}</label>
                                <label for="newBuildingType"
                                       class="sr-only"
                                >{{__('neuer Gebäudetyp')}}</label>
                                <div class="input-group">
                                    <select name="building_type_id"
                                            class="custom-select"
                                            id="building_type_id"
                                    >
                                        @foreach (App\BuildingTypes::all() as $bty)
                                            <option value="{{ $bty->id }}">{{ $bty->btname }}</option>
                                        @endforeach
                                        <option value="new">{{__('neu anlegen')}}</option>
                                    </select>
                                    <input type="text"
                                           id="newBuildingType"
                                           name="newBuildingType"
                                           class="form-control d-none"
                                           placeholder="{{__('neuer Gebäudetyp')}}"
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="h5">{{__('Wareneingang')}}</h2>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="1"
                                               id="b_we_has"
                                               name="b_we_has" {{ (old('b_we_has')==='1')?' checked ': '' }}>
                                        <label class="form-check-label"
                                               for="b_we_has"
                                        > {{__('Wareneingang vorhanden')}}
                                        </label>
                                    </div>
                                </div>
                                <x-textfield id="b_we_name"
                                             label="{{ __('WE Bezeichnung') }}"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{__('speichern')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal"
         id="modalSetRoom"
         tabindex="-1"
         aria-labelledby="modalSetRoomLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('room.modal') }}#Explorer"
                      method="POST"
                      class="needs-validation"
                      id="frmModalSetRoom"
                      name="frmModalSetRoom"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalSetRoomLabel"
                        >{{__('Raum erstellen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="modalType"
                               id="modalType_room"
                        >
                        <input type="hidden"
                               name="id"
                               id="id_modal_room"
                               placeholder="id_modal_room"
                        >
                        <input type="hidden"
                               name="building_id"
                               id="building_id_room_modal"
                               placeholder="building_id_room_modal"
                        >
                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_room"
                               value="{{ Str::uuid() }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="r_label"
                                             label="{{ __('Kurzbezeichnung') }}"
                                             required
                                             max="20"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="room_type_id">{{__('Raumtyp festlegen')}}</label>
                                <label for="newRoomType"
                                       class="sr-only"
                                >{{__('neuer Raumtyp')}}</label>
                                <div class="input-group">
                                    <select name="room_type_id"
                                            class="custom-select"
                                            id="room_type_id"
                                    >
                                        @foreach (App\RoomType::all() as $bty)
                                            <option value="{{ $bty->id }}">{{ $bty->rt_label }}</option>
                                        @endforeach
                                        <option value="new">{{__('neu anlegen')}}</option>
                                    </select>
                                    <input type="text"
                                           id="newRoomType"
                                           name="newRoomType"
                                           class="form-control d-none"
                                           placeholder="{{__('neuer Raumtyp')}}"
                                    >
                                </div>
                            </div>
                        </div>

                        <x-textfield id="r_name"
                                     label="{{ __('Name lang') }}"
                        />

                        <x-textarea id="r_name_text"
                                    label="{{ __('Beschreibung') }}"
                        />


                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{__('speichern')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal"
         id="modalSetStellplatz"
         tabindex="-1"
         aria-labelledby="modalSetStellplatzLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('stellplatz.modal') }}#Explorer"
                      method="POST"
                      class="needs-validation"
                      id="frmModalSetStellplatz"
                      name="frmModalSetStellplatz"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalSetStellplatzLabel"
                        >{{__('Raum erstellen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="modalType"
                               id="modalType_stellplatz"
                        >
                        <input type="hidden"
                               name="id"
                               id="id_modal_stellplatz"
                        >
                        <input type="hidden"
                               name="room_id"
                               id="room_id_stellplatz_modal"
                        >
                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_stellplatz"
                               value="{{ Str::uuid() }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="sp_label"
                                             label="{{ __('Kurzbezeichnung') }}"
                                             required
                                             max="20"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="stellplatz_typ_id">{{__('Stellplatztyp festlegen')}}</label>
                                <label for="newStellplatzType"
                                       class="sr-only"
                                >{{__('neuer Stellplatztyp')}}</label>
                                <div class="input-group">
                                    <select name="stellplatz_typ_id"
                                            class="custom-select"
                                            id="stellplatz_typ_id"
                                    >
                                        @foreach (App\StellplatzTyp::all() as $bty)
                                            <option value="{{ $bty->id }}">{{ $bty->spt_label }}</option>
                                        @endforeach
                                        <option value="new">{{__('neu anlegen')}}</option>
                                    </select>
                                    <input type="text"
                                           id="newStellplatzType"
                                           name="newStellplatzType"
                                           class="form-control d-none"
                                           placeholder="{{__('neuer Stellplatztyp')}}"
                                    >
                                </div>
                            </div>
                        </div>

                        <x-textfield id="sp_name"
                                     label="{{ __('Name lang') }}"
                        />

                        <x-textarea id="sp_name_text"
                                    label="{{ __('Beschreibung') }}"
                        />

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >{{__('speichern')}}
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
                <h1 class="h3">{{__('Explorer')}}</h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6 col-xl-4">
                <form action="{{ route('lexplorer') }}" method="get" id="frmSetLocation">
                    <label for="location">{{ __('Standort auswählen') }}</label>
                    <div class="input-group">
                        <select id="location"
                                name="location"
                                class="custom-select"
                        >
                            @foreach(\App\Location::all() as $loc)
                                <option value="{{ $loc->id }}"
                                        data-loc="{{ $loc->id }}"
                                        data-location="{{ $location->id }}"
                                        @if( $loc->id === $location->id) selected @endif
                                >{{ $loc->l_name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-primary ml-2">{{__('Daten holen')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3 mt-md-0">
                <input type="hidden"
                       name="building_id"
                       id="building_id"
                       value="{{ App\Building::where('location_id',$location->id)->first()->id??'' }}"
                >
                <h2 class="h4">{{ __('Gebäude') }}</h2>
                <div class="btn-toolbar"
                     role="toolbar"
                     aria-label="{{__('Toolbar für Gebäude')}}"
                >
                    <div class="btn-group mb-2 btn-block"
                         role="group"
                    >
                        <button type="button"
                                data-type="new"
                                class="btn btn-sm btn-outline-primary btnBuilding"
                        >
                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                        </button>
                        <button type="button"
                                data-type="edit"
                                class="btn btn-sm btn-outline-primary btnBuilding"
                        >
                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span
                                class="fas fa-edit"></span>
                        </button>
                        <button type="button"
                                data-type="copy"
                                class="btn btn-sm btn-outline-primary btnBuilding"
                        >
                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span>
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnBuildingDelete"
                        >
                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span
                                class="far fa-trash-alt"></span></button>

                    </div>
                    <form id="frmDeleteBuilding">
                        <input type="hidden"
                               name="id"
                               id="id_delete_Building"
                        > @csrf @method('delete')</form>
                </div>
                <div id="buildingSection">
                    <label for="buildingList"
                           class="sr-only"
                    >{{__('Gebäudeliste')}}</label>
                    <select class="custom-select"
                            id="buildingList"
                            multiple
                            size="10"
                    >
                        @forelse(App\Building::with('BuildingType')->where('location_id',$location->id)->get() as $building)
                            <option value="{{ $building->id }}">
                                [{{ $building->BuildingType->btname }}]
                                {{ $building->b_label }} /
                                {{ $building->b_name }}
                            </option>
                        @empty
                            <option value="void">{{__('Keine Gebäude im Standort angelegt')}}</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <input type="hidden"
                       name="room_id"
                       id="room_id"
                >
                <h2 class="h4">{{__('Räume')}}</h2>
                <div class="btn-toolbar"
                     role="toolbar"
                     aria-label="{{__('Übersicht der Räume des ausgewählten Gebäudes')}}"
                >
                    <div class="btn-group mb-2 btn-block"
                         role="group"
                         aria-label="{{__('Raumliste')}}"
                    >
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoom "
                                data-type="new"
                        >
                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoom disabled"
                                disabled
                                data-type="edit"
                        >
                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span
                                class="fas fa-edit"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoom disabled"
                                disabled
                                data-type="copy"
                        >
                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoomDelete disabled"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span
                                class="far fa-trash-alt"></span>
                        </button>
                    </div>
                    <form id="frmDeleteRoom"
                    >@csrf @method('delete')
                        <input type="hidden"
                               name="id"
                               id="id_delete_Room"
                        >
                    </form>
                </div>
                <div id="roomSection">
                    <label for="roomList"
                           class="sr-only"
                    >{{__('Gebäudeliste')}}</label>
                    <select class="custom-select"
                            id="roomList"
                            multiple
                            size="10"
                    >
                        <option value="void">{{__('Gebäude auswählen')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <input type="hidden"
                       name="stellplatz_id"
                       id="stellplatz_id"
                >
                <h2 class="h4">{{__('Stellpätze')}}</h2>
                <div class="btn-toolbar"
                     role="toolbar"
                     aria-label="{{__('Übersicht der Stellplätze des ausgewählten Raums')}}"
                >
                    <div class="btn-group mb-2 btn-block"
                         role="group"
                         aria-label="{{__('Stellplatzliste')}}"
                    >
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatz"
                                data-type="new"
                        >
                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatz disabled"
                                data-type="edit"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span
                                class="fas fa-edit"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatz disabled"
                                data-type="copy"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatzDelete disabled"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span
                                class="far fa-trash-alt"></span>
                        </button>
                    </div>
                    <form id="frmDeleteStellplatz">
                        <input type="hidden"
                               name="id"
                               id="id_delete_Stellplatz"
                        > @csrf @method('delete')</form>
                </div>
                <div id="stellplatzSectionq">
                    <label for="stellplatzList"
                           class="sr-only"
                    >{{__('Gebäudeliste')}}</label>
                    <select class="custom-select"
                            id="stellplatzList"
                            multiple
                            size="10"
                    >
                        <option value="void">{{__('Bitte erst Gebäude wählen')}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        function setBuildingValues(id) {
            $('#building_id').val(id);
            $('#id_delete_Building').val(id);
            $('#building_id_room_modal').val(id);
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getRoomListInBuilding') }}",
                data: {id},
                success: (res) => {
                    $('#roomList').html(res.html);
                    setTimeout(function () {
                        buildingList.val(id)
                    },400);
                    let text = '{{__('Bitte erst Gebäude wählen')}}';
                    if (id === 'void')
                        $('#stellplatzList').html(`<option>${text}</option>`);
                }
            });
        }

        function setRoomValues(id) {
            if (id === 'void') {
                $('.btnRoom').attr('disabled', true).addClass('disabled');
                $('.btnRoomDelete').attr('disabled', true).addClass('disabled');
            } else {
                $('.btnRoom').attr('disabled', false).removeClass('disabled');
                $('.btnRoomDelete').attr('disabled', false).removeClass('disabled');
            }
            $('#room_id').val(id);
            $('#id_modal_room').val(id);
            $('#room_id_stellplatz_modal').val(id);

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getStellplatzListInRoom') }}",
                data: {id},
                success: (res) => {
                    $('#stellplatzList').html(res.html);
                    setTimeout(function () {
                        roomList.val(id)
                    },400);
                }
            });
        }

        function setStellplatzValues(id) {
            $('#stellplatz_id').val(id);
            $('#id_modal_stellplatz').val(id);
            $('#id_delete_Stellplatz').val(id);
            setTimeout(function () {
                stellplatzList.val(id)
            },400);
            if (id === 'void') {
                $('.btnStellplatz').attr('disabled', true).addClass('disabled');
                $('.btnStellplatzDelete').attr('disabled', true).addClass('disabled');
            } else {
                $('.btnStellplatz').attr('disabled', false).removeClass('disabled');
                $('.btnStellplatzDelete').attr('disabled', false).removeClass('disabled');
            }
        }


        const locationlist = $('#location');
        const roomList = $('#roomList');
        const buildingList = $('#buildingList');
        const stellplatzList = $('#stellplatzList');

        $('#frmSetLocation').submit(function () {
            localStorage.setItem('explorer_location', $('#location :selected').val());
            localStorage.removeItem('explorer_building');
            localStorage.removeItem('explorer_room');
            localStorage.removeItem('explorer_stellplatz');
        });

        buildingList.change(function () {
            const id = $('#buildingList :selected').val();
            localStorage.setItem('explorer_building', id);
            setBuildingValues(id);
        });

        roomList.change(function () {
            const id = $('#roomList :selected').val();
            localStorage.setItem('explorer_room', id);
            setRoomValues(id);
        });

        stellplatzList.change(function () {
            const id = $('#stellplatzList :selected').val();
            localStorage.setItem('explorer_stellplatz', id);
            setStellplatzValues(id)
        });

        if (localStorage.getItem('explorer_location') !== null) {
            const lid = parseInt(localStorage.getItem('explorer_location'));
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getBuildingListInLocation') }}",
                data: {id: lid},
                success: (res) => {
                    $('#buildingList').html(res.html);
                    locationlist.val(lid);
                }
            });
        }
        if (localStorage.getItem('explorer_building') !== null) {
            const bid = (localStorage.getItem('explorer_building'));
            setBuildingValues(bid);
        }

        if (localStorage.getItem('explorer_room') !== null) {
            const rid = (localStorage.getItem('explorer_room'));
            setRoomValues(rid);
        }

        if (localStorage.getItem('explorer_stellplatz') !== null) {
            const sid = (localStorage.getItem('explorer_stellplatz'));
            setStellplatzValues(sid);
        }

        $('#building_type_id').change(function () {
            const nBtNod = $('#newBuildingType');
            ($('#building_type_id :selected').val() === 'new') ?
                nBtNod.removeClass('d-none') :
                nBtNod.addClass('d-none');
        });

        $('#room_type_id').change(function () {
            const nBtNod = $('#newRoomType');
            ($('#room_type_id :selected').val() === 'new') ?
                nBtNod.removeClass('d-none') :
                nBtNod.addClass('d-none');
        });

        $('#stellplatz_typ_id').change(function () {
            const nBtNod = $('#newStellplatzType');
            ($('#stellplatz_typ_id :selected').val() === 'new') ?
                nBtNod.removeClass('d-none') :
                nBtNod.addClass('d-none');
        });

        $('.btnBuildingDelete').click(function () {
            const id = $('#buildingList :selected').val();
            if (id !== 'new' && id !== 'void') {
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: "{{ route('destroyBuildingAjax') }}",
                    data: $('#frmDeleteBuilding').serialize(),
                    success: (res) => {
                        if (res)
                            location.reload();
                    }
                });
            }
        });

        $('.btnBuilding').click(function () {
            const type = $(this).data('type'),
                modalBuilding = $('#modalSetBuilding'),
                id = $('#buildingList :selected').val(),
                form = $('#frmModalSetBuilding');

            if (type === 'new') {
                $('#modalSetBuildingLabel').text('{{__('Bitte erst Gebäude wählen')}}');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#storage_id_building').val(res);
                        form.find('#modalType').val('new');
                        modalBuilding.modal('show');
                    }
                });
            }
            if ((type === 'edit' || type === 'copy') && id !== 'void') {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getBuildingData') }}",
                    data: {id},
                    success: (res) => {
                        form.find('#b_name_ort').val(res.b_name_ort);
                        form.find('#storage_id_building').val(res.storage_id);
                        form.find('#b_name').val(res.b_name);
                        form.find('#b_name_text').val(res.b_name_text);
                        if (res.b_we_has === 1)
                            form.find('#b_we_has').prop('checked', true);
                        form.find('#b_we_name').val(res.b_we_name);
                        form.find('#location_id').val(res.location_id);
                        form.find('#building_type_id').val(res.building_type_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetBuildingLabel').text('{{ __('Gebäude bearbeiten') }}');
                            form.find('#modalType').val('edit');
                            form.find('#b_label').val(res.b_label);
                            modalBuilding.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetBuildingLabel').text('{{ __('Gebäude kopieren') }}');
                                    form.find('#b_label').attr('placeholder', '{{__('neue Kurzbezeichnung angeben')}}');
                                    form.find('#storage_id_building').val(res);
                                    form.find('#modalType').val('copy');
                                    modalBuilding.modal('show');
                                }
                            });
                        }
                    }
                });
            }
        });

        $('.btnRoomDelete').click(function () {
            const id = $('#buildingList :selected').val();
            if (id !== 'new' && id !== 'void') {
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: "{{ route('destroyBuildingAjax') }}",
                    data: $('#frmDeleteBuilding').serialize(),
                    success: (res) => {
                        if (res)
                            location.reload();
                    }
                });
            }
        });

        $('.btnRoom').click(function () {
            const type = $(this).data('type'),
                modalRoom = $('#modalSetRoom'),
                id = $('#roomList :selected').val(),
                form = $('#frmModalSetRoom');

            if (type === 'new') {
                $('#modalSetRoomLabel').text('{{__('Neuen Raum anlegen')}}');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#storage_id_room').val(res);
                        form.find('#modalType_room').val('new');
                        // form.find('#building_id_room_modal').val(res.building_id);
                        modalRoom.modal('show');
                    }
                });
            }
            if ((type === 'edit' || type === 'copy') && id !== 'void') {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getRoomData') }}",
                    data: {id},
                    success: (res) => {
                        form.find('#r_label').val(res.r_label);
                        form.find('#storage_id_room').val(res.storage_id);
                        form.find('#r_name').val(res.r_name);
                        form.find('#r_name_text').val(res.r_name_text);
                        form.find('#building_id_room_modal').val(res.building_id);
                        form.find('#room_type_id').val(res.room_type_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetRoomLabel').text('{{__('Raum bearbeiten')}}');
                            form.find('#modalType_room').val('edit');
                            form.find('#r_label').val(res.r_label);
                            modalRoom.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetRoomLabel').text('{{__('Raum kopieren')}}');
                                    form.find('#r_label').attr('placeholder', '{{__('neue Kurzbezeichnung angeben')}}').val('');
                                    form.find('#storage_id_room').val(res);
                                    form.find('#modalType_room').val('copy');
                                    modalRoom.modal('show');
                                }
                            });
                        }
                    }
                });
            }
        });

        $('.btnStellplatzDelete').click(function () {
            const id = $('#stellplatzList :selected').val();
            if (id !== 'new' && id !== 'void') {
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: "{{ route('destroyStellplatzAjax') }}",
                    data: $('#frmDeleteStellplatz').serialize(),
                    success: (res) => {
                        if (res)
                            location.reload();
                    }
                });
            }
        });

        $('.btnStellplatz').click(function () {
            const type = $(this).data('type'),
                modalStellplatz = $('#modalSetStellplatz'),
                id = $('#stellplatzList :selected').val(),
                form = $('#frmModalSetStellplatz');

            if (type === 'new') {
                $('#modalSetStellplatzLabel').text('{{__('Neuen Stellplatz anlegen')}}');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#storage_id_stellplatz').val(res);
                        form.find('#modalType_stellplatz').val('new');
                        // form.find('#room_id_stellplatz_modal').val(res.room_id);
                        modalStellplatz.modal('show');
                    }
                });
            }
            if ((type === 'edit' || type === 'copy') && id !== 'void') {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('getStellplatzData') }}",
                    data: {id},
                    success: (res) => {
                        form.find('#sp_label').val(res.sp_label);
                        form.find('#storage_id_stellplatz').val(res.storage_id);
                        form.find('#sp_name').val(res.sp_name);
                        form.find('#sp_name_text').val(res.sp_name_text);
                        form.find('#room_id_stellplatz_modal').val(res.room_id);
                        form.find('#stellplatz_typ_id').val(res.stellplatz_typ_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetStellplatzLabel').text('{{__('Stellplatz bearbeiten')}}');
                            form.find('#modalType_stellplatz').val('edit');
                            form.find('#sp_label').val(res.sp_label);
                            modalStellplatz.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetStellplatzLabel').text('{{__('Stellplatz kopieren')}}');
                                    form.find('#sp_label').attr('placeholder', '{{__('neue Kurzbezeichnung angeben')}}').val('');
                                    form.find('#storage_id_stellplatz').val(res);
                                    form.find('#modalType_stellplatz').val('copy');
                                    modalStellplatz.modal('show');
                                }
                            });
                        }
                    }
                });
            }
        });
    </script>

@endsection
