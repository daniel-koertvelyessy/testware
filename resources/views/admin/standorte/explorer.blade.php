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
                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_building"
                               value="{{ Str::uuid() }}"
                        >

                        <x-selectfield name="location_id"
                                       id="location_id_modal"
                                       label="{{ __('befindet sich in ') . __('Standort') }}"
                        >
                            @foreach(\App\Location::all() as $loc)
                                <option value="{{ $loc->id }}"
                                        @if($loc->id === $location->id)selected @endif >{{ $loc->l_name }}</option>
                            @endforeach
                        </x-selectfield>

                        <div class="row">
                            <div class="col-md-4">
                                <x-textfield id="b_label"
                                             label="{{ __('Kurzbezeichnung') }}"
                                             required
                                             max="20"
                                />
                            </div>
                            <div class="col-md-8">
                                <x-textfield id="b_name_ort"
                                             label="{{ __('Ort') }}"
                                />
                            </div>
                        </div>


                        <x-textfield id="b_name"
                                     label="{{ __('Bezeichnung') }}"
                        />

                        <x-textarea id="b_description"
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
                                    <input type="hidden"
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

                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_room"
                               value="{{ Str::uuid() }}"
                        >
                        <x-selectfield label="{{__('Befindet sich in Gebäude')}}"
                                       name="building_id"
                                       id="building_id_room_modal"
                        >
                            @foreach(App\Building::all() as $build)
                                <option value="{{ $build->id }}">{{ $build->b_label . ' - ' . $build->b_name }}</option>
                            @endforeach
                        </x-selectfield>
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
                                    <input type="hidden"
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

                        <x-textarea id="r_description"
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
                               id="modalType_compartment"
                        >
                        <input type="hidden"
                               name="id"
                               id="id_modal_compartment"
                        >

                        @csrf
                        <input type="hidden"
                               name="storage_id"
                               id="storage_id_compartment"
                               value="{{ Str::uuid() }}"
                        >
                        <x-selectfield name="room_id"
                                       id="room_id_compartment_modal"
                                       label="{{__('Befindet sich im Raum')}}"
                        >
                            @foreach(App\Room::all() as $room)
                                <option value="{{ $room->id }}">{{ $room->r_label . ' ' . $room->r_name }}</option>
                            @endforeach
                        </x-selectfield>
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="sp_label"
                                             label="{{ __('Kurzbezeichnung') }}"
                                             required
                                             max="20"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="compartment_typ_id">{{__('Stellplatztyp festlegen')}}</label>
                                <label for="newStellplatzType"
                                       class="sr-only"
                                >{{__('neuer Stellplatztyp')}}</label>
                                <div class="input-group">
                                    <select name="compartment_typ_id"
                                            class="custom-select"
                                            id="compartment_typ_id"
                                    >
                                        @foreach (App\StellplatzTyp::all() as $bty)
                                            <option value="{{ $bty->id }}">{{ $bty->spt_label }}</option>
                                        @endforeach
                                        <option value="new">{{__('neu anlegen')}}</option>
                                    </select>
                                    <input type="hidden"
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

                        <x-textarea id="sp_description"
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

    <x-modals.form_modal methode="DELETE"
                         modalRoute="{{ route('destroyBuildingAjax') }}"
                         modalId="modalDeleteBuilding"
                         modalType="danger"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Geäude endgültig löschen') }}"
    >
        <input type="hidden"
               name="id"
               id="modal_id_delete_Building"
        >
        <p>{!! __('Bitte beachten Sie, dass die Löschung des Gebäude alle enthaltenen Räume und Geräte den Bezug verlieren.') !!}</p>

        <div id="BuildingObjectList"></div>

        <p class="mx-3 mt-4 text-danger lead">{{__('Der Löschvorgang ist permanent und kann nicht wieder rückgängig gemacht werden.')}}</p>
    </x-modals.form_modal>

    <x-modals.form_modal methode="DELETE"
                         modalRoute="{{ route('room.destroyRoomAjax') }}"
                         modalId="modalDeleteRoom"
                         modalType="danger"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Raum endgültig löschen') }}"
    >
        <input type="hidden"
               name="id"
               id="modal_id_delete_Room"
        >
        <p>{!! __('Bitte beachten Sie, dass die Löschung des Raums alle enthaltenen Stellplätze und Geräte den Bezug verlieren.') !!}</p>

        <div id="RoomObjectList"></div>

        <p class="mx-3 mt-4 text-danger lead">{{__('Der Löschvorgang ist permanent und kann nicht wieder rückgängig gemacht werden.')}}</p>
    </x-modals.form_modal>

    <x-modals.form_modal methode="DELETE"
                         modalRoute="{{ route('destroyStellplatzAjax') }}"
                         modalId="modalDeleteCompartment"
                         modalType="danger"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Stellplatz endgültig löschen') }}"
    >
        <input type="hidden"
               name="id"
               id="modal_id_delete_Compartment"
        >
        <p>{!! __('Bitte beachten Sie, dass die Löschung des Raums alle enthaltenen Geräte den Bezug verlieren.') !!}</p>

        <div id="CompartmentObjectList"></div>

        <p class="mx-3 mt-4 text-danger lead">{{__('Der Löschvorgang ist permanent und kann nicht wieder rückgängig gemacht werden.')}}</p>
    </x-modals.form_modal>

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
                <form action="{{ route('lexplorer') }}"
                      method="get"
                      id="frmSetLocation"
                >
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
                                class="fas fa-edit"
                            ></span>
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
                                class="far fa-trash-alt"
                            ></span></button>

                    </div>
                    <form id="frmDeleteBuilding">
                        <input type="hidden"
                               name="id"
                               id="id_delete_Building"
                        > @csrf @method('delete')</form>
                </div>
                <div id="buildingSection">
                @php($buildings = App\Building::with('BuildingType')->where('location_id',$location->id))
                <!--
                      #  Full - widescreen select block
                      #  visible < md - breakpoint
                -->
                    <div style="height: 35vh; overflow-y: auto;"
                         class="d-none d-md-block"
                    >
                        <div class="btn-group-toggle d-flex flex-column"
                             data-toggle="buttons"
                             id="radio_building_list"
                        >
                            @forelse($buildings->get() as $building)
                                <label class="btn btn-outline-primary my-0"
                                       style="border-radius: 0!important; margin-top: 5px !important;"
                                >
                                    <input type="radio"
                                           name="radio_set_building_id"
                                           id="building_list_item_{{ $building->id }}"
                                           class="radio_set_building_id"
                                           value="{{ $building->id }}"
                                    >
                                    [{{ $building->BuildingType->btname }}]
                                    {{ $building->b_label }} /
                                    {{ $building->b_name }}
                                </label>
                            @empty
                                <label class="btn btn-outline-info">
                                    {{__('Keine Gebäude im Standort angelegt')}}
                                </label>
                            @endforelse
                        </div>
                    </div>

                    <!--
                      #  Mobile view of select block
                      #  visible > md - breakpoint
                    -->
                    <div class="d-md-none">
                        <label id="labelBuildingSecton"
                        >{{ $buildings->count() }} {{ __('Gebäude zu Auswahl') }}</label>
                        <label for="buildingList"
                               class="sr-only"
                        >{{__('Gebäudeliste')}}</label>
                        <select class="custom-select"
                                id="buildingList"
                        >
                            <option value="0">{{ __('Bitte wählen') }}</option>
                            @forelse($buildings->get() as $building)
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
                                class="btn btn-sm btn-outline-primary btnRoom disabled resetBtn"
                                disabled
                                data-type="edit"
                        >
                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span class="fas fa-edit"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoom disabled resetBtn"
                                disabled
                                data-type="copy"
                        >
                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnRoomDelete disabled resetBtn"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span class="far fa-trash-alt"></span>
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
                    <!--
                          #  Full - widescreen select block
                          #  visible < md - breakpoint
                    -->
                    <div style="height: 35vh; overflow-y: auto;"
                         class="d-none d-md-block"
                    >
                        <div class="btn-group-toggle d-flex flex-column"
                             data-toggle="buttons"
                             id="radio_room_list"
                        ></div>
                    </div>

                    <!--
                      #  Mobile view of select block
                      #  visible > md - breakpoint
                    -->
                    <div class="d-md-none">
                        <label id="labelRoomSection">0 {{ __('Räume zu Auswahl') }}</label>
                        <label for="roomList"
                               class="sr-only"
                        >{{__('Gebäudeliste')}}</label>
                        <select class="custom-select"
                                id="roomList"
                        >
                            <option value="void">{{__('Gebäude auswählen')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <input type="hidden"
                       name="compartment_id"
                       id="compartment_id"
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
                                class="btn btn-sm btn-outline-primary btnStellplatz disabled resetBtn"
                                data-type="edit"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span class="fas fa-edit"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatz disabled resetBtn"
                                data-type="copy"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary btnStellplatzDelete disabled resetBtn"
                                disabled
                        >
                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span class="far fa-trash-alt"></span>
                        </button>
                    </div>
                    <form id="frmDeleteStellplatz">
                        <input type="hidden"
                               name="id"
                               id="id_delete_Stellplatz"
                        > @csrf @method('delete')</form>
                </div>
                <div id="compartmentSection">
                    <!--
                     #  Full - widescreen select block
                     #  visible < md - breakpoint
                   -->
                    <div style="height: 35vh; overflow-y: auto;"
                         class="d-none d-md-block"
                    >
                        <div class="btn-group-toggle d-flex flex-column"
                             data-toggle="buttons"
                             id="radio_compartment_list"
                        ></div>
                    </div>

                    <!--
                      #  Mobile view of select block
                      #  visible > md - breakpoint
                    -->
                    <div class="d-md-none">
                        <label id="labelCompartmentSection">0 {{ __('Stellplätze zu Auswahl') }}</label>
                        <label for="compartment_select_list"
                               class="sr-only"
                        >{{__('Stellplatzliste')}}</label>
                        <select class="custom-select"
                                id="compartment_select_list"
                        >
                            <option value="void">{{__('Bitte erst Gebäude wählen')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>

        $(document).on('click', '.radio_set_building_id', function () {
            setBuildingValues($(this).val())
        });
        $(document).on('click', '.radio_set_room_id', function () {
            setRoomValues($(this).val())
        });
        $(document).on('click', '.radio_set_compartment_id', function () {
            setCompartmentValues($(this).val())
        });

        function resetDeleteModal(modalId) {
            $(modalId).html(`
            <div class="d-flex align-items-center justify-content-around">
                <div class="fa-3x">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <span class="lead">{{ __('Suche') }}</span>
            </div>
            `)
        }

        function setBuildingValues(id) {
            resetDeleteModal('#BuildingObjectList');
            $('#building_id').val(id);
            $('#id_delete_Building').val(id);
            $('#building_id_room_modal').val(id);
            $('#building_list_item_' + id).attr('checked', true);

            /**
             *  Disable Room and Compartment buttons
             */
            $('.resetBtn').attr('disabled', true).addClass('disabled');

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getRoomListInBuilding') }}",
                data: {id},
                success: (res) => {
                    $('#roomList').html(res.select);
                    $('#radio_room_list').html(res.radio);
                    $('#labelRoomSection').html(res.msg);
                    setTimeout(function () {
                        buildingList.val(id)
                    }, 50);
                    let text = '{{__('Bitte erst Gebäude wählen')}}';
                    if (id === 'void')
                        $('#compartment_select_list').html(`<option>${text}</option>`);
                }
            });
        }

        function setRoomValues(id) {
            resetDeleteModal('#RoomObjectList');
            if (id === 'void') {
                $('.btnRoom').attr('disabled', true).addClass('disabled');
                $('.btnRoomDelete').attr('disabled', true).addClass('disabled');
            } else {
                $('.btnRoom').attr('disabled', false).removeClass('disabled');
                $('.btnRoomDelete').attr('disabled', false).removeClass('disabled');
            }
            $('#room_id').val(id);
            $('#id_delete_Room').val(id);
            $('#id_modal_room').val(id);
            $('#room_id_compartment_modal').val(id);
            $('#room_list_item_' + id).attr('checked', true);
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getStellplatzListInRoom') }}",
                data: {id},
                success: (res) => {
                    $('#compartment_select_list').html(res.select);
                    $('#radio_compartment_list').html(res.radio);
                    $('#labelCompartmentSection').html(res.msg);
                    setTimeout(function () {
                        roomList.val(id)
                    }, 50);
                }
            });
        }

        function setCompartmentValues(id) {
            resetDeleteModal('#CompartmentObjectList');
            $('#compartment_id').val(id);
            $('#id_modal_compartment').val(id);
            $('#id_delete_Stellplatz').val(id);
            $('#compartment_list_item_' + id).attr('checked', true);
            setTimeout(function () {
                compartment_select_list.val(id)
            }, 50);
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
        const compartment_select_list = $('#compartment_select_list');

        $('#frmSetLocation').submit(function () {
            localStorage.setItem('explorer_location', $('#location :selected').val());
            localStorage.removeItem('explorer_building');
            localStorage.removeItem('explorer_room');
            localStorage.removeItem('explorer_compartment');
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

        compartment_select_list.change(function () {
            const id = $('#compartment_select_list :selected').val();
            localStorage.setItem('explorer_compartment', id);
            setCompartmentValues(id)
        });

        if (localStorage.getItem('explorer_location') !== null) {
            const lid = parseInt(localStorage.getItem('explorer_location'));
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getBuildingListInLocation') }}",
                data: {id: lid},
                success: (res) => {
                    $('#buildingList').html(res.select);

                    $('#labelBuildingSection').html(res.msg);
                    locationlist.val(lid);
                    console.log(lid);
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

        if (localStorage.getItem('explorer_compartment') !== null) {
            const sid = (localStorage.getItem('explorer_compartment'));
            setCompartmentValues(sid);
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

        $('#compartment_typ_id').change(function () {
            const nBtNod = $('#newStellplatzType');
            ($('#compartment_typ_id :selected').val() === 'new') ?
                nBtNod.removeClass('d-none') :
                nBtNod.addClass('d-none');
        });

        $('.btnBuildingDelete').click(function () {
            const id = $('#buildingList :selected').val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '{{route('getObjectsInBuilding')}}',
                data: {id},
                success: function (res) {
                    $('#BuildingObjectList').html(res.html)
                }
            });
            $('#modal_id_delete_Building').val(id);
            $('#modalDeleteBuilding').modal('show');
        });

        $('.btnRoomDelete').click(function () {
            const id = $('#roomList :selected').val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '{{route('getObjectsInRoom')}}',
                data: {id},
                success: function (res) {
                    $('#RoomObjectList').html(res.html)
                }
            });
            $('#modal_id_delete_Room').val(id);
            $('#modalDeleteRoom').modal('show');
        });

        $('.btnStellplatzDelete').click(function () {
            const id = $('#compartment_select_list :selected').val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '{{route('getObjectsInCompartment')}}',
                data: {id},
                success: function (res) {
                    $('#CompartmentObjectList').html(res.html)
                }
            });
            $('#modal_id_delete_Compartment').val(id);
            $('#modalDeleteCompartment').modal('show');
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
                        form.find('#b_description').val(res.b_description);
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
                        form.find('#r_description').val(res.r_description);
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


        $('.btnStellplatz').click(function () {
            const type = $(this).data('type'),
                modalStellplatz = $('#modalSetStellplatz'),
                id = $('#compartment_select_list :selected').val(),
                form = $('#frmModalSetStellplatz');

            if (type === 'new') {
                $('#modalSetStellplatzLabel').text('{{__('Neuen Stellplatz anlegen')}}');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#storage_id_compartment').val(res);
                        form.find('#modalType_compartment').val('new');
                        // form.find('#room_id_compartment_modal').val(res.room_id);
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
                        console.log(res);
                        form.find('#sp_label').val(res.sp_label);
                        form.find('#storage_id_compartment').val(res.storage_id);
                        form.find('#sp_name').val(res.sp_name);
                        form.find('#sp_description').val(res.sp_description);
                        form.find('#room_id_compartment_modal').val(res.room_id);
                        form.find('#compartment_typ_id').val(res.stellplatz_typ_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetStellplatzLabel').text('{{__('Stellplatz bearbeiten')}}');
                            form.find('#modalType_compartment').val('edit');
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
                                    form.find('#storage_id_compartment').val(res);
                                    form.find('#modalType_compartment').val('copy');
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
