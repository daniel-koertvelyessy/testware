@extends('layout.layout-admin')

@section('pagetitle',__('Systemeinstellungen'))

@section('mainSection')
    {{__('Systemeinstellungen')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection


@section('modals')
    <div class="modal fade"
         id="warningDeleteProduktKategorieParam"
         tabindex="-1"
         aria-labelledby="warningDeleteProduktKategorieParamLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <form action="{{ route('deleteProduktKategorieParam') }}#Produkte"
                  method="POST"
                  name="frmDeleteProduktKategorieParam"
                  id="frmDeleteProduktKategorieParam"
            >
                @csrf
                @method('DELETE')
                <input type="hidden"
                       name="id"
                       id="id"
                >
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white"
                            id="warningDeleteProduktKategorieParamLabel"
                        >{{__('Warnung')}}</h5>
                        <button type="button"
                                class="close text-white"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"
                         id="warningDeleteProduktKategorieParamBody"
                    >
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                id="closeModalDeleteProdKat"
                                data-dismiss="modal"
                        >
                            {{__('Abbruch')}}</button>
                        <button class="btn btn-outline-warning"
                                id="btnDeleteParam"
                        >{{__('Datenfeld dennoch löschen')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade"
         id="modalAddProduktKategorieParam"
         tabindex="-1"
         aria-labelledby="modalAddProduktKategorieParamLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <form action="{{ route('addProduktKategorieParam') }}#Produkte"
                  method="POST"
                  name="frmAddProduktKategorieParam"
                  id="frmAddProduktKategorieParam"
            >
                @csrf
                <input type="hidden"
                       name="produkt_kategorie_id"
                       id="produkt_kategorie_id"
                >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Neues Datenfeld anlegen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="pkp_label">{{__('Label')}}</label>
                            <input type="text"
                                   name="pkp_label"
                                   id="pkp_label"
                                   class="form-control checkLabel"
                            >
                            <p class="small text-primary">{{__('erforderlich, max 20 Zeichen, ohne Sonder- und Leerzeichen')}}</p>
                        </div>
                        <div class="mb-2">
                            <label for="pkp_name">{{__('Name')}}</label>
                            <input type="text"
                                   name="pkp_name"
                                   id="pkp_name"
                                   class="form-control"
                            >
                            <p class="small text-primary">{{__('maximal 150 Zeichen')}}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Datenfeld speichern')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('content')
    <div class="container-fluid">
        <div class="row mb-4 d-md-block d-none">
            <div class="col">
                <h1 class="h3">{{__('Systemeinstellungen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav class="nav nav-tabs mainNavTab"
                     id="myTab"
                     role="tablist"
                >
                    <a class="nav-link active"
                       id="Objekte-tab"
                       data-toggle="tab"
                       href="#Objekte"
                       role="tab"
                       aria-controls="Objekte"
                       aria-selected="true"
                    >{{__('Objekt Typen')}}</a>
                    <a class="nav-link"
                       id="Produkte-tab"
                       data-toggle="tab"
                       href="#Produkte"
                       role="tab"
                       aria-controls="Produkte"
                       aria-selected="false"
                    >{{__('Produkte')}}</a>
                    <a class="nav-link"
                       id="Numbering-tab"
                       data-toggle="tab"
                       href="#Numbering"
                       role="tab"
                       aria-controls="Numbering"
                       aria-selected="false"
                    >{{__('Nummerierung')}}</a>
                    <a class="nav-link"
                       id="notes-tab"
                       data-toggle="tab"
                       href="#notes"
                       role="tab"
                       aria-controls="notes"
                       aria-selected="false"
                    >{{__('Notizen')}}</a>
                    @if(Auth::user()->role_id===1)
                        <a class="nav-link"
                           id="userRoles-tab"
                           data-toggle="tab"
                           href="#userRoles"
                           role="tab"
                           aria-controls="userRoles"
                           aria-selected="false"
                        >{{__('Benutzerrollen')}}</a>
                    @endif
                </nav>
                <div class="tab-content"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active p-2 "
                         id="Objekte"
                         role="tabpanel"
                         aria-labelledby="Objekte-tab"
                    >
                        <div class="row">
                            <div class="col-lg-2 col-md-3  border-right">
                                <nav class="nav flex-column nav-pills"
                                     id="tab"
                                     role="tablist"
                                     aria-orientation="vertical"
                                >
                                    <a class="nav-link active"
                                       id="sysTypeAdress-tab"
                                       data-toggle="pill"
                                       href="#sysTypeAdress"
                                       role="tab"
                                       aria-controls="sysTypeAdress"
                                       aria-selected="true"
                                    >{{__('Adressen')}}</a>
                                    <a class="nav-link"
                                       id="sysTypeGebaeude-tab"
                                       data-toggle="pill"
                                       href="#sysTypeGebaeude"
                                       role="tab"
                                       aria-controls="sysTypeGebaeude"
                                       aria-selected="false"
                                    >{{__('Gebäude')}}</a>
                                    <a class="nav-link"
                                       id="sysTypRooms-tab"
                                       data-toggle="pill"
                                       href="#sysTypRooms"
                                       role="tab"
                                       aria-controls="sysTypRooms"
                                       aria-selected="false"
                                    >{{__('Räume')}}</a>
                                    <a class="nav-link"
                                       id="sysTypeStellPlatz-tab"
                                       data-toggle="pill"
                                       href="#sysTypeStellPlatz"
                                       role="tab"
                                       aria-controls="sysTypeStellPlatz"
                                       aria-selected="false"
                                    >{{__('Stellplatz')}}</a>
                                </nav>
                            </div>
                            <div class="col-lg-10 col-md-9">
                                <div class="tab-content"
                                     id="tabContent"
                                >
                                    <div class="tab-pane fade show active"
                                         id="sysTypeAdress"
                                         role="tabpanel"
                                         aria-labelledby="sysTypeAdress-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createAddressType') }}#Objekte"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="addNewAdressType"
                                                      name="addNewAdressType"
                                                >
                                                    @csrf
                                                    <x-rtextfield id="adt_name"
                                                                  label="{{__('Kürzel')}}"
                                                    />
                                                    <x-textarea id="adt_text_lang"
                                                                label="{{__('Beschreibung des Adresstyps')}}"
                                                    />
                                                    <x-btnMain>
                                                        {{__('Neuen Adresstyp anlegen')}}
                                                        <span class="fas fa-download ml-md-2"></span>
                                                    </x-btnMain>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\AddressType::all())>0 )
                                                    <form action="{{ route('updateAddressType') }}"
                                                          method="POST"
                                                          id="frmEditAddressTyp"
                                                          name="frmEditAddressTyp"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadAdressTypId"
                                                        >{{__('Adress-Typ auswählen')}}</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id"
                                                                    id="loadAdressTypId"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\AddressType::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->adt_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadAdressTypeItem"
                                                                       block="1"
                                                            >
                                                                {{__('Adresstyp laden')}}
                                                            </x-btnLoad>
                                                        </div>
                                                        <x-rtextfield id="upd_adt_name"
                                                                      name="adt_name"
                                                                      label="{{__('Name')}}"
                                                        />
                                                        <x-textarea id="upd_adt_text_lang"
                                                                    name="adt_text_lang"
                                                                    label="{{__('Beschreibung des Adresstyps')}}"
                                                                    value="{{ old('adt_text_lang') ?? '' }}"
                                                        />
                                                        <x-btnSave>{{__('Adresstyp aktualisieren')}}</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border border-danger p-3">
                                                    <h2 class="h5">{{__('Adresstyp löschen')}}</h2>
                                                    <form action="{{ Route('deleteTypeAdress') }}"
                                                          id="frmDeleteAddressType"
                                                          name="frmDeleteAddressType"
                                                          method="post"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="input-group mb-3">
                                                            <label for="frmDeleteAddressTypeid"
                                                                   class="sr-only"
                                                            >{{__('Adress-typ auswählen')}}</label>
                                                            <select name="id"
                                                                    id="frmDeleteAddressTypeid"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\AddressType::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->adt_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnDelete block="1"
                                                                         type="submit"
                                                            >{{__('Adresstyp löschen')}}</x-btnDelete>
                                                        </div>
                                                        <p class="text-danger lead">{{__('Bitte beachten Sie, dass Adressen diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche Adressen von der Löschung betroffen sein werden!')}}</p>
                                                    </form>
                                                    <div class="input-group mb-3 showUsedAdressResult">
                                                        <x-btnFetch class="showUsedAddresses"
                                                        >{{__('Betroffene Adressen anzeigen')}}
                                                        </x-btnFetch>
                                                    </div>
                                                    <ul class="list-group mt-3"
                                                        id="usedAddressesListe"
                                                    ></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade"
                                         id="sysTypeGebaeude"
                                         role="tabpanel"
                                         aria-labelledby="sysTypeGebaeude-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form action="{{ route('createBuildingType') }}"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="frmCreateBuildingType"
                                                      name="frmCreateBuildingType"
                                                >
                                                    @csrf
                                                    <x-rtextfield id="btname"
                                                                  label="{{__('Name')}}"
                                                    />
                                                    <x-textarea id="btbeschreibung"
                                                                label="{{__('Beschreibung des Gebäudetyps')}}"
                                                                value="{{ old('btbeschreibung') ?? '' }}"
                                                    />

                                                    <x-btnMain>{{__('Gebäudetyp anlegen')}}
                                                        <span class="fas fa-download ml-md-2"></span>
                                                    </x-btnMain>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\BuildingTypes::all())>0 )
                                                    <form action="{{ route('updateBuildingType') }}"
                                                          method="POST"
                                                          id="frmEditBuildingTyp"
                                                          name="frmCreateBuildingType"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="btid">{{__('Gebäudetyp auswählen')}}</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id"
                                                                    id="btid"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\BuildingTypes::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->btname }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadBuildingTypeItem"
                                                                       block="1"
                                                            >{{__('Gebäudetyp laden')}}
                                                            </x-btnLoad>
                                                        </div>
                                                        <x-rtextfield id="upd_btname"
                                                                      name="btname"
                                                                      label="{{__('Name')}}"
                                                        />
                                                        <x-textarea id="upd_btbeschreibung"
                                                                    name="btbeschreibung"
                                                                    label="{{__('Beschreibung des Gebäudetyps')}}"
                                                                    value="{{ old('btbeschreibung') ?? '' }}"
                                                        />
                                                        <x-btnSave id="btnUpdateBuildingType"
                                                        >{{__('Gebäudetyp aktualisieren')}}
                                                        </x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border border-danger p-3">
                                                    <h2 class="h5">{{__('Gebäudetyp löschen')}}</h2>
                                                    <form action="{{ Route('deleteBuildingType') }}"
                                                          method="post"
                                                          name="frmDeleteBuildingType"
                                                          id="frmDeleteBuildingType"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="input-group mb-3">
                                                            <label for="frmDeleteBuildingTypeid"
                                                                   class="sr-only"
                                                            >{{__('Gebäudetyp auswählen')}}</label>
                                                            <select name="id"
                                                                    id="frmDeleteBuildingTypeid"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\BuildingTypes::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->btname }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnDelete block="1"
                                                                         type="submit"
                                                            >{{__('Gebäudetyp löschen')}}</x-btnDelete>
                                                        </div>
                                                        <p class="text-danger lead">
                                                            {{__('Bitte beachten Sie, dass mit diesem Typ verknüpfte Datensätze verloren gehen können! Bitte prüfen Sie vorab, welche Gebäude von der Löschung betroffen sein werden!')}}</p>
                                                    </form>
                                                    <div class="input-group mb-3 showUsedBuildingsResult">
                                                        <x-btnFetch class="showUsedBuildings"
                                                        >{{__('Betroffene Gebäude anzeigen')}}
                                                        </x-btnFetch>
                                                    </div>
                                                    <ul class="list-group mt-3"
                                                        id="usedBuildingTypeListe"
                                                    ></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade"
                                         id="sysTypRooms"
                                         role="tabpanel"
                                         aria-labelledby="sysTypRooms-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createRoomType') }}"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="addNewRoomType"
                                                      name="addNewRoomType"
                                                >
                                                    @csrf
                                                    <x-rtextfield id="rt_label"
                                                                  label="{{__('Kürzel')}}"
                                                    />

                                                    <x-textfield id="rt_name"
                                                                 label="{{__('Name')}} "
                                                    />

                                                    <x-textarea id="rt_description"
                                                                label="{{__('Beschreibung des Raumtyps')}}"
                                                    />

                                                    <x-btnMain>{{__('Neuen Raumtyp anlegen')}}
                                                        <span class="fas fa-download ml-md-2"></span>
                                                    </x-btnMain>

                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\RoomType::all())>0 )
                                                    <form action="{{ route('updateRoomType') }}"
                                                          method="POST"
                                                          id="frmEditRoomTyp"
                                                          name="frmEditRoomTyp"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadRoomTyeid">{{__('Raumtyp auswählen')}}</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id"
                                                                    id="loadRoomTyeid"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\RoomType::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->rt_label }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad block="1"
                                                                       id="loadRoomTypeItem"
                                                            >{{ __('Raumtyp laden')}}
                                                            </x-btnLoad>
                                                        </div>

                                                        <x-rtextfield id="updt_rt_label"
                                                                      name="rt_label"
                                                                      label="{{__('Kürzel')}}"
                                                        />

                                                        <x-textfield id="updt_rt_name"
                                                                     name="rt_name"
                                                                     label="{{__('Name')}}"
                                                        />

                                                        <x-textarea id="upd_rt_description"
                                                                    name="rt_description"
                                                                    label="{{__('Beschreibung des Raumtyps')}}"
                                                        />

                                                        <x-btnSave>{{ __('Raumtyp aktualisieren')}}</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\RoomType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">{{ __('Raumtyp löschen')}}</h2>
                                                        <form action="{{ Route('deleteRoomType') }}"
                                                              id="frmDeleteRoomType"
                                                              name="frmDeleteRoomType"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteRaumTypeid"
                                                                       class="sr-only"
                                                                >{{__('Raumtyp auswählen')}}</label>
                                                                <select name="id"
                                                                        id="frmDeleteRaumTypeid"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (App\RoomType::all() as $ad)
                                                                        <option value="{{ $ad->id }}"
                                                                        >{{ $ad->rt_label }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1"
                                                                             type="submit"
                                                                >{{__('Raumtyp löschen')}}</x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">{{__('Bitte beachten Sie, dass Räume diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche Adressen von der Löschung betroffen sein werden!')}}</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedRoomsResult">
                                                            <x-btnFetch class="showUsedRooms">
                                                                {{__('Betroffene Räume anzeigen')}}
                                                            </x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3"
                                                            id="usedRoomsListe"
                                                        ></ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade"
                                         id="sysTypeStellPlatz"
                                         role="tabpanel"
                                         aria-labelledby="sysTypeStellPlatz-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createStellPlatzType') }}"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="addNewStellPlatzType"
                                                      name="addNewStellPlatzType"
                                                >
                                                    @csrf

                                                    <x-rtextfield id="spt_label"
                                                                  label="{{__('Kürzel')}}"
                                                    />

                                                    <x-textfield id="spt_name"
                                                                 label="{{__('Name')}}"
                                                    />

                                                    <x-textarea id="spt_description"
                                                                label="{{__('Beschreibung des Stellplatztyps')}}"
                                                    />

                                                    <x-btnMain>{{__('Neuen Stellplatztyp anlegen')}}</x-btnMain>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\StellplatzTyp::all())>0 )
                                                    <form action="{{ route('updateStellPlatzType') }}"
                                                          method="POST"
                                                          id="frmEditStellPlatzTyp"
                                                          name="frmEditStellPlatzTyp"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadStellPlatzTyeid"
                                                                   class="sr-only"
                                                            >{{__('Stellplatztyp auswählen')}}</label>
                                                            <select name="id"
                                                                    id="loadStellPlatzTyeid"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\StellplatzTyp::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->spt_label }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadStellPlatzTypeItem"
                                                                       block="1"
                                                            >
                                                                {{__('Stellplatztyp laden')}}
                                                            </x-btnLoad>
                                                        </div>

                                                        <x-rtextfield id="updt_spt_label"
                                                                      name="spt_label"
                                                                      label="{{__('Kürzel')}}"
                                                        />

                                                        <x-textfield name="spt_name"
                                                                     id="updt_spt_name"
                                                                     label="{{__('Name')}}"
                                                        />

                                                        <x-textarea id="updt_spt_description"
                                                                    name="spt_description"
                                                                    label="{{__('Beschreibung des Stellplatztyps')}}"
                                                        />

                                                        <x-btnSave>{{__('Stellplatztyp aktualisieren')}}</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\StellplatzTyp::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">{{__('Stellplatztyp löschen')}}</h2>
                                                        <form action="{{ Route('deleteStellPlatzType') }}"
                                                              id="frmDeleteStellPlatzType"
                                                              name="frmDeleteStellPlatzType"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteStellPlatzTypeid"
                                                                       class="sr-only"
                                                                >{{__('StellPlatztyp auswählen')}}</label>
                                                                <select name="id"
                                                                        id="frmDeleteStellPlatzTypeid"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (App\StellplatzTyp::all() as $ad)
                                                                        <option value="{{ $ad->id }}"
                                                                        >{{ $ad->spt_label }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1"
                                                                             type="submit"
                                                                >
                                                                    {{__('Stellplatztyp löschen')}}
                                                                </x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">
                                                                {{__('Bitte beachten Sie, dass Stellplätze diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!')}}
                                                            </p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedStellPlaetze">
                                                            <x-btnFetch class="showUsedStellplatz">
                                                                {{__('Betroffene Stellplätze anzeigen')}}
                                                            </x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3"
                                                            id="usedStellPlatzListe"
                                                        ></ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="Produkte"
                         role="tabpanel"
                         aria-labelledby="Produkte-tab"
                    >
                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                <nav class="nav flex-column nav-pills"
                                     id="tab"
                                     role="tablist"
                                     aria-orientation="vertical"
                                >
                                    <a class="nav-link active"
                                       id="prodKategorie-tab"
                                       data-helpertext="{{__('Erstellen Sie allgemeine Produkttypen unter der Sie die Produkte zusammenfassen können. Beispielsweise Computer, EDV, Werkzeug etc.')}}"
                                       data-toggle="pill"
                                       href="#prodKategorie"
                                       role="tab"
                                       aria-controls="prodKategorie"
                                       aria-selected="true"
                                    >{{__('Kategorien')}}</a>

                                    <a class="nav-link"
                                       id="prodAnforderungTyp-tab"
                                       data-toggle="pill"
                                       data-helpertext="{{__('Anforderungen können verschiedene Aufgaben umfassen. Mit Hilfe von Anforderungs-typen können Sie diese gruppieren.')}}"
                                       href="#prodAnforderungTyp"
                                       role="tab"
                                       aria-controls="prodAnforderungTyp"
                                       aria-selected="false"
                                    >
                                        <span class="">{{ __('Anforderung Typ') }}</span>
                                    </a>

                                    <a class="nav-link"
                                       id="doctypes-tab"
                                       data-helpertext="{{__('Erstellen Sie Dokumenttypen wie zum Beispiel Bedienungs-anleitungen, Zeichnugen oder Kataloge.')}}"
                                       data-toggle="pill"
                                       href="#doctypes"
                                       role="tab"
                                       aria-controls="doctypes"
                                       aria-selected="false"
                                    >{{__('Dokument')}}</a>
                                </nav>
                                <div class="navTextHelper mt-3 p-3 border border-primary rounded d-none d-md-block">
                                    {{__('Erstellen Sie allgemeine Produktypen unter der Sie die Produkte zusammenfassen können. Beispielsweise Computer, EDV, Werkzeug etc.')}}
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9">
                                <div class="tab-content"
                                     id="tabContent"
                                >
                                    <div class="tab-pane fade show active"
                                         id="prodKategorie"
                                         role="tabpanel"
                                         aria-labelledby="prodKategorie-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <h3 class="h4">{{__('Kategorien')}}</h3>
                                                <p>{{__('Ordnen Sie Ihre Produkte nach Kategorien ein.')}}</p>
                                                <form action="{{ route('createProdKat') }}#Produkte"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="frmAddNewProduktKategorie"
                                                      name="frmAddNewProduktKategorie"
                                                >
                                                    @csrf
                                                    <x-rtextfield id="pk_label"
                                                                  label="{{__('Kürzel')}}"
                                                    />

                                                    <x-textfield id="pk_name"
                                                                 label="{{__('Name')}}"
                                                    />

                                                    <x-textarea id="pk_description"
                                                                label="{{__('Beschreibung')}}"
                                                    />

                                                    <x-btnMain>{{__('Neue Kategorie anlegen')}}
                                                        <span class="fas fa-download ml-md-2"></span>
                                                    </x-btnMain>

                                                </form>
                                                <div class="dropdown-divider my-2"></div>
                                                @if (count(App\ProduktKategorie::all())>0 )

                                                    <form action="{{ route('updateProdKat') }}"
                                                          method="POST"
                                                          id="frmEditProdKategorie"
                                                          name="frmEditProdKategorie"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadProdKategorieId">
                                                            {{__('Kategorie zum Bearbeiten auswählen')}}
                                                        </label>
                                                        <div class="input-group mb-3">
                                                            <select name="id"
                                                                    id="loadProdKategorieId"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\ProduktKategorie::all() as $ad)
                                                                    <option value="{{ $ad->id }}"
                                                                    >{{ $ad->pk_label }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad block="1"
                                                                       id="loadProdKategorieItem"
                                                            >{{__('Kategorie laden')}}
                                                            </x-btnLoad>
                                                        </div>

                                                        <div class="dropdown-divider my-3"></div>

                                                        <x-rtextfield id="upd_pk_label"
                                                                      name="pk_label"
                                                                      label="{{__('Kürzel')}}"
                                                        />

                                                        <x-textfield id="updt_pk_name"
                                                                     name="pk_name"
                                                                     label="{{__('Name')}}"
                                                        />

                                                        <x-textarea id="updt_pk_description"
                                                                    name="pk_description"
                                                                    label="{{__('Beschreibung')}}"
                                                        />

                                                        <x-btnSave>{{__('Kategorie aktualisieren')}}</x-btnSave>

                                                    </form>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\ProduktKategorie::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">{{__('Kategorie löschen')}}</h2>
                                                        <form action="{{ Route('deleteProdKat') }}"
                                                              id="frmDeleteProduktKategorie"
                                                              name="frmDeleteProduktKategorie"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteProduktKategorieid"
                                                                       class="sr-only"
                                                                >{{__('Kategorie auswählen')}}</label>
                                                                <select name="id"
                                                                        id="frmDeleteProduktKategorieid"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (App\ProduktKategorie::all() as $ad)
                                                                        <option value="{{ $ad->id }}"
                                                                        >{{ $ad->pk_label }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1"
                                                                             type="submit"
                                                                >{{__('Kategorie löschen')}}</x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">
                                                                {{__('Bitte beachten Sie, dass Produkte & Geräte diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!')}}
                                                            </p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedProduktsResult">
                                                            <x-btnFetch class="showUsedProdukts">
                                                                {{__('Betroffene Produkte & Geräte anzeigen')}}
                                                            </x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3"
                                                            id="usedProduktsListe"
                                                        ></ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <h3 class="h4">{{__('Datenfelder')}}</h3>
                                                <p>{{__('Datenfelder ergänzen die vorgegebene Struktur der Produkte, basierend auf der gewählten Produkt-Kategorie.')}}</p>
                                                <div class="input-group mb-3">
                                                    <label for="getProduktKategorieParams"
                                                           class="sr-only"
                                                    >{{__('Kategorie auswählen')}}</label>
                                                    <select name="id"
                                                            id="getProduktKategorieParams"
                                                            class="custom-select"
                                                    >
                                                        @foreach (App\ProduktKategorie::all() as $ad)
                                                            <option value="{{ $ad->id }}">
                                                                {{ $ad->pk_label }} {{ ($ad->ProduktKategorieParam->count()>0) ? ' ('.$ad->ProduktKategorieParam->count() . ')' :'' }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <x-btnLoad id="getProduktKategorieParamListe"
                                                               block="1"
                                                    >{{__('Datenfelder laden')}}
                                                    </x-btnLoad>

                                                    <x-btnAdd id="makePkParam"
                                                              block="1"
                                                    >{{__('Neu')}}</x-btnAdd>
                                                </div>
                                                <div id="showProduktKategorieParamListe">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade"
                                         id="prodAnforderungTyp"
                                         role="tabpanel"
                                         aria-labelledby="prodAnforderungTyp-tab"
                                    >
                                        <form action="{{ route('addNewAnforderungType') }}#Produkte"
                                              method="post"
                                              id="frmAddNewAnforderungsType"
                                        >
                                            @csrf
                                            <x-rtextfield id="at_label"
                                                          label="{{__('Kürzel')}}"
                                            />
                                            <x-textfield id="at_name"
                                                         label="{{__('Name')}}"
                                            />
                                            <x-textarea id="at_description"
                                                        label="{{__('Beschreibung')}}"
                                            />

                                            <x-btnMain>{{__('Anforderungstyp anlegen')}}
                                                <span class="fas fa-download ml-md-2"></span>
                                            </x-btnMain>
                                        </form>
                                        <div class="dropdown-divider my-3"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form action="{{ route('updateAnforderungType') }}#Produkte"
                                                      method="post"
                                                      id="frmAnforderungsTypEdit"
                                                >
                                                    @csrf
                                                    @method('put')
                                                    <x-selectgroup id="loadAnforderungTypeId"
                                                                   name="id"
                                                                   label="{{__('Anforderungstyp wählen')}}"
                                                                   btnL="{{__('Typ laden')}}"
                                                                   btnT="getAnforderungTypData"
                                                    >
                                                        @foreach(App\AnforderungType::all() as $anforderungType)
                                                            <option value="{{ $anforderungType->id }}"
                                                            >{{ $anforderungType->at_label }}</option>
                                                        @endforeach
                                                    </x-selectgroup>
                                                    <x-rtextfield id="updt_at_label"
                                                                  name="at_label"
                                                                  label="{{__('Kürzel')}}"
                                                    />
                                                    <x-textfield id="updt_at_name"
                                                                 name="at_name"
                                                                 label="{{__('Name')}}"
                                                    />
                                                    <x-textarea id="updt_at_description"
                                                                name="at_description"
                                                                label="{{__('Beschreibung')}}"
                                                    />
                                                    <x-btnSave>{{__('Anforderungstyp speichern')}}</x-btnSave>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                @if (count(App\AnforderungType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">{{__('Anforderungstyp löschen')}}</h2>
                                                        <form action="{{ route('deleteAnforderungType') }}"
                                                              id="frmDeleteAnforderungTyp"
                                                              name="frmDeleteAnforderungTyp"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteAnforderungTypeId"
                                                                       class="sr-only"
                                                                >{{__('Typ
                                                                    auswählen')}}</label>
                                                                <select name="id"
                                                                        id="frmDeleteAnforderungTypeId"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (App\AnforderungType::all() as $ad)
                                                                        <option value="{{ $ad->id }}"
                                                                        >{{ $ad->at_label }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-outline-danger">
                                                                    {{__('Anforderungstyp löschen')}} <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                            <p class="text-danger lead">{{__('Bitte beachten Sie, dass mit diesem Typ verknüpfte Objekte verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!')}}</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedAnforderungProdukteResult">
                                                            <button type="button"
                                                                    class="btn btn-outline-secondary showUsedAnforderungProdukte"
                                                            >
                                                                {{__('Betroffene Produkte anzeigen')}}
                                                            </button>
                                                        </div>
                                                        <ul class="list-group mt-3"
                                                            id="usedAnforderungProdukteListe"
                                                        ></ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade"
                                         id="doctypes"
                                         role="tabpanel"
                                         aria-labelledby="doctypes-tab"
                                    >
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createDokumentType') }}#Produkte"
                                                      method="POST"
                                                      class="needs-validation"
                                                      id="frmAddNewDokumentenTyp"
                                                      name="frmAddNewDokumentenTyp"
                                                >
                                                    @csrf

                                                    <x-textfield id="doctyp_label"
                                                                 label="{{ __('Kürzel') }}"
                                                                 required
                                                                 max="20"
                                                    />

                                                    <x-textfield id="doctyp_name"
                                                                 label="{{ __('Name') }}"
                                                                 required
                                                                 max="100"
                                                    />

                                                    <x-textarea id="doctyp_description"
                                                                label="{{ __('Beschreibung') }}"
                                                    />

                                                    <div class="form-group">
                                                        <p class="lead">{{__('Dokument ist Pflichtteil einer Verordnung')}}</p>
                                                        <div class="pl-3">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input"
                                                                       type="radio"
                                                                       name="doctyp_mandatory"
                                                                       id="doctyp_mandatory_ja"
                                                                       value="1"
                                                                >
                                                                <label class="custom-control-label"
                                                                       for="doctyp_mandatory_ja"
                                                                > {{__('ist Teil einer Verordnung')}}
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input"
                                                                       type="radio"
                                                                       name="doctyp_mandatory"
                                                                       id="doctyp_mandatory_nein"
                                                                       value="0"
                                                                       checked
                                                                >
                                                                <label class="custom-control-label"
                                                                       for="doctyp_mandatory_nein"
                                                                > {{__('kein Pflichtteil')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-block">
                                                        {{__('Neuen Dokumententyp anlegen')}}
                                                    </button>
                                                </form>
                                                @if (count(App\DocumentType::all())>0 )
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('updateDokumentType') }}"
                                                          method="POST"
                                                          id="frmEditDokumentenTyp"
                                                          name="frmEditDokumentenTyp"
                                                    >
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadDokumentenTypId"
                                                                   class="sr-only"
                                                            >{{__('Dokumententyp auswählen')}}
                                                            </label>
                                                            <select name="id"
                                                                    id="loadDokumentenTypId"
                                                                    class="custom-select"
                                                            >
                                                                @foreach (App\DocumentType::all() as $ad)
                                                                    <option value="{{ $ad->id }}">
                                                                        {{ $ad->doctyp_label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button class="btn btn-outline-primary"
                                                                    type="button"
                                                                    id="loadDokumentenTypeItem"
                                                            >{{__('Anforderung laden')}}
                                                            </button>
                                                        </div>

                                                        <x-textfield required
                                                                     id="updt_doctyp_label"
                                                                     label="{{__('Kürzel')}}"
                                                                     max="2"
                                                        />

                                                        <x-textfield required
                                                                     id="updt_doctyp_name"
                                                                     label="{{__('Name')}}"
                                                                     max="100"
                                                        />

                                                        <x-textfield id="updt_doctyp_description"
                                                                     label="{{ __('Beschreibung') }}"
                                                        />

                                                        <div class="form-group pl-2">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input"
                                                                       type="radio"
                                                                       name="doctyp_mandatory"
                                                                       id="updt_doctyp_mandatory_ja"
                                                                       value="1"
                                                                >
                                                                <label class="custom-control-label"
                                                                       for="updt_doctyp_mandatory_ja"
                                                                > {{__('ist Teil einer Verordnung')}}
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input"
                                                                       type="radio"
                                                                       name="doctyp_mandatory"
                                                                       id="updt_doctyp_mandatory_nein"
                                                                       value="0"
                                                                       checked
                                                                >
                                                                <label class="custom-control-label"
                                                                       for="updt_doctyp_mandatory_nein"
                                                                > {{__('kein Pflichtteil')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline-primary btn-block">{{__('Dokumententyp aktualisieren')}}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\DocumentType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">{{__('Dokumententyp löschen')}}</h2>
                                                        <form action="{{ Route('deleteDokumentType') }}"
                                                              id="frmDeleteDokumentenTypg"
                                                              name="frmDeleteDokumentenTypg"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteDokumentenTypgId"
                                                                       class="sr-only"
                                                                >
                                                                    {{__('Dokumententyp auswählen')}}
                                                                </label>
                                                                <select name="id"
                                                                        id="frmDeleteDokumentenTypgId"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (App\DocumentType::all() as $ad)
                                                                        <option value="{{ $ad->id }}"
                                                                        >{{ $ad->doctyp_label }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-outline-danger">{{__('Dokumententyp löschen')}} <i
                                                                        class="fas fa-trash-alt"
                                                                    ></i></button>
                                                            </div>
                                                            <p class="text-danger lead">{{__('Bitte beachten Sie, dass mit diesem Typ verknüpfte Objekte verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!')}}</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedDokumentenTypResult">
                                                            <button type="button"
                                                                    class="btn btn-outline-secondary showUsedDokumentenTyp"
                                                            >
                                                                {{__('Betroffene Produkte anzeigen')}}
                                                            </button>
                                                        </div>
                                                        <ul class="list-group mt-3"
                                                            id="usedDokumentenTypListe"
                                                        ></ul>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="Numbering"
                         role="tabpanel"
                         aria-labelledby="Numbering-tab"
                    >
                        <div class="row">
                            <div class="col-md-8">
                                <form action="@if($test_report_formats['id']){{ route('testreportformat.update',$test_report_formats['id']) }}@else{{ route('testreportformat.store') }}@endif#Numbering"
                                      id="setTestReportFormat"
                                      method="post"
                                >
                                    @csrf
                                    @if($test_report_formats['id'])
                                        @method('put')
                                    @endif
                                    <h2 class="h4">{{__('Prüfbericht')}}</h2>
                                    <div class="input-group mb-2 mb-md-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{__('Präfix')}} + {{__('Digits')}} + {{__('Postfix')}}</span>
                                        </div>
                                        <input type="text"
                                               id="prefix"
                                               name="prefix"
                                               class="form-control"
                                               aria-label="{{__('Präfix')}}"
                                               placeholder="{{__('Präfix')}}"
                                               value="{{ $test_report_formats['prefix']??'' }}"
                                        >
                                        <input type="number"
                                               id="digits"
                                               name="digits"
                                               class="form-control"
                                               min="1"
                                               max="20"
                                               aria-label="{{__('Digits')}}"
                                               placeholder="{{__('Digits')}}"
                                               value="{{ $test_report_formats['digits']??6 }}"
                                        >
                                        <input type="text"
                                               id="postfix"
                                               name="postfix"
                                               class="form-control"
                                               aria-label="{{__('Postfix')}}"
                                               placeholder="{{__('Postfix')}}"
                                               value="{{ $test_report_formats['postfix']??'' }}"
                                        >
                                    </div>

                                    <x-btnMain block="1">{{ __('Format speichern') }} <span class="fas fa-download ml-2"></span></x-btnMain>

                                </form>
                            </div>
                            <div class="col-md-4 d-none d-md-inline">
                                <h2 class="h4">{{__('Beispiel')}}</h2>
                                @if($test_report_formats['id'])
                                <span class="h3 text-info">{{ $test_report_formats['prefix']??'' }}{{ str_pad('32',$test_report_formats['digits'],'0',STR_PAD_LEFT) }}{{ $test_report_formats['postfix']??'' }}</span>
                                @else
                                    <p class="h3 text-info">IR{{ str_pad('332',6,'0',STR_PAD_LEFT) }}/1</p>
                                    <dl class="row">
                                        <dt class="col-sm-3">{{__('Präfix')}}</dt>
                                        <dd class="col-sm-9">IR</dd>
                                        <dt class="col-sm-3">{{__('Digits')}}</dt>
                                        <dd class="col-sm-9">6</dd>
                                        <dt class="col-sm-3">{{__('Postfix')}}</dt>
                                        <dd class="col-sm-9">/1</dd>
                                    </dl>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="notes"
                         role="tabpanel"
                         aria-labelledby="notes-tab"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h5">{{ __('Typen') }}</h3>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Kürzel') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Beschreibung') }}</th>
                                        <th></th>
                                    </tr>
                                    <form action="{{ route('note-type.store') }}#notes"
                                          method="post"
                                          id="formStoreNoteTyeData"
                                    >@csrf
                                        <tr>
                                            <td>
                                                <x-textfield class="form-control-sm"
                                                             hideLabel
                                                             label="{{__('Kürzel')}}"
                                                             id="note_type_label"
                                                             name="label"
                                                />
                                            </td>
                                            <td>
                                                <x-textfield class="form-control-sm"
                                                             hideLabel
                                                             label="{{__('Name')}}"
                                                             id="note_type_name"
                                                             name="name"
                                                />
                                            </td>
                                            <td>
                                                <x-textfield class="form-control-sm"
                                                             hideLabel
                                                             label="{{__('Kürzel')}}"
                                                             id="note_type_description"
                                                             name="description"
                                                />
                                            </td>
                                            <td>
                                                <input type="hidden"
                                                       name="id"
                                                       id="note_type_id"
                                                >
                                                <input type="hidden"
                                                       name="_method"
                                                       id="note_type_methode"
                                                >
                                                <button type="button"
                                                        id="btnFormStoreNoteTyeData"
                                                        class="btn btn-sm btn-outline-primary"
                                                >{{__('speichern')}}
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                    </thead>
                                    <tbody>
                                    @forelse(App\NoteType::all() as $notetype)
                                        <form action="{{ route('note-type.update',$notetype) }}"
                                              method="post"
                                        >
                                            @csrf
                                            @method('put')
                                            <tr>
                                                <td>
                                                    {{ $notetype->label }}
                                                </td>
                                                <td>
                                                    {{ $notetype->name }}
                                                </td>
                                                <td>
                                                    {{ $notetype->description }}
                                                </td>
                                                <td>
                                                    <x-menu_context :object="$notetype"
                                                                    routeOpen="/note-type/{{ $notetype->id }}"
                                                                    routeCopy="{{ route('note-type.edit',$notetype) }}"
                                                                    routeDestory="{{ route('note-type.destroy',$notetype) }} "
                                                                    tabName="notes"
                                                                    objectName="label"
                                                                    objectVal="{{ $notetype->label }}"

                                                    />
                                                </td>
                                            </tr>
                                        </form>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <x-notifyer>{{ __('Bislang sind keine Typen definiert') }}</x-notifyer>
                                            </td>
                                        </tr>

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5">{{ __('Tags') }}</h3>
                            </div>
                        </div>
                    </div>
                    @can('isSysAdmin')
                        <div class="tab-pane fade p-2"
                             id="userRoles"
                             role="tabpanel"
                             aria-labelledby="userRoles-tab"
                        >
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="h5">{{ __('Benutzerrolle') }}</h3>
                                    <form method="post"
                                          action="{{ route('role.store') }}#userRoles"
                                          id="frmSetUserRole"
                                    >
                                        @csrf

                                        <input type="hidden"
                                               name="_method"
                                               id="_method"
                                        >

                                        <input type="hidden"
                                               name="id"
                                               id="role_id"
                                        >
                                        <x-textfield id="role_label"
                                                     name="label"
                                                     label="{{ __('Label') }}"
                                                     required
                                        />
                                        <x-textfield id="role_name"
                                                     name="name"
                                                     label="{{ __('Name') }}"
                                        />
                                        <div class="custom-control custom-switch mb-4">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="is_super_user"
                                                   name="is_super_user"
                                                   value="1"
                                            >
                                            <label class="custom-control-label"
                                                   for="is_super_user"
                                            >{{ __('SysAdmin') }}</label>
                                        </div>
                                        <x-btnSave>{{ __('Benutzerrolle speichern') }}</x-btnSave>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="h5">{{ __('Übersicht') }}</h3>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('Label') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('SuperUser') }}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse(\App\Role::all() as $role)
                                            <tr>
                                                <td>
                                                    {{ $role->label }}
                                                </td>
                                                <td>
                                                    {{ $role->name }}
                                                </td>
                                                <td class="text-center">
                                                    {!!  $role->is_super_user === true ? '<i class="fas fa-check"></i>' : '' !!}
                                                </td>
                                                <td>
                                                    <form method="post"
                                                          action="{{ route('role.destroy',$role) }}#userRoles"
                                                    >
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-primary btnLoadRoleData"
                                                                data-id="{{ $role->id }}"
                                                        >
                                                            <span class="fas fa-edit"></span>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            <span class="far fa-trash-alt"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <x-notifyer>{{ __('Keine Benutzerrollen gefunden!') }}</x-notifyer>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    @error('aci_name')
    <script>
        $('#modalAddNewAnforderungControlItem').modal('show');
    </script>
    @enderror

    <script>

        $('.btnLoadRoleData').click(function () {
            const id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: `/role/${id}`,
                success: function (res) {
                    $('#role_id').val(id);
                    $('#role_label').val(res.label);
                    $('#role_name').val(res.name);
                    $('#_method').val('put');
                    $('#frmSetUserRole').attr('action', `/role/${id}#userRoles`);
                    const setSuperUser = $('#is_super_user');
                    res.is_super_user === true ? setSuperUser.attr('checked', true) : setSuperUser.attr('checked', false);

                }
            });
        });

        $('#btnFormStoreNoteTyeData').click(function () {
            let idNode = $('#note_type_id');
            if (idNode.val() === '') {
                $('#note_type_methode').val('post');
                $('#formStoreNoteTyeData').attr('action', '{{ route('note-type.store') }}#notes').submit();
            } else {
                $('#note_type_methode').val('put');
                $('#formStoreNoteTyeData').attr('action', '/note-type/' + idNode.val() + '#notes').submit();
            }
        });

        $('.context_item_open').click(function (e) {
            e.preventDefault();
            let id = $(this).data('target-id');
            $.ajax({
                dataType: "json",
                url: $(this).attr('href'),
                success: function (data) {
                    $('#note_type_id').val(data.id);
                    $('#note_type_label').val(data.label);
                    $('#note_type_name').val(data.name);
                    $('#note_type_description').val(data.description);
                }
            });


        })

        $('.nav-link').click(function () {
            $('.navTextHelper').html($(this).data('helpertext'));
        });

        $('#loadAdressTypeItem').click(function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getAddressTypeData') }}",
                data: {
                    adt_id: $('#loadAdressTypId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                $('#upd_adt_name').val(jsn[0].adt_name);
                $('#upd_adt_text_lang').val(jsn[0].adt_text_lang);
            });

        });

        $('#loadBuildingTypeItem').click(function () {
            const frm = $('#frmEditBuildingTyp');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getBuildingTypeData') }}",
                data: {
                    adt_id: $('#btid :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#upd_btname').val(jsn[0].btname);
                frm.find('#upd_btbeschreibung').val(jsn[0].btbeschreibung);
            });

        });

        $('#loadRoomTypeItem').click(function () {
            const frm = $('#frmEditRoomTyp');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getRoomTypeData') }}",
                data: {
                    id: $('#loadRoomTyeid :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_rt_label').val(jsn.rt_label);
                frm.find('#updt_rt_name').val(jsn.rt_name);
                frm.find('#upd_rt_description').val(jsn.rt_description);
            });

        });

        $('#loadStellPlatzTypeItem').click(function () {
            const frm = $('#frmEditStellPlatzTyp');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getStellPlatzTypeData') }}",
                data: {
                    id: $('#loadStellPlatzTyeid :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_spt_label').val(jsn.spt_label);
                frm.find('#updt_spt_name').val(jsn.spt_name);
                frm.find('#updt_spt_description').val(jsn.spt_description);
            });

        });

        $('#loadProdKategorieItem').click(function () {
            const frm = $('#frmEditProdKategorie');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getProdKatData') }}",
                data: {
                    id: $('#loadProdKategorieId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#upd_pk_label').val(jsn.pk_label);
                frm.find('#updt_pk_name').val(jsn.pk_name);
                frm.find('#updt_pk_description').val(jsn.pk_description);
            });

        });

        $('#getAnforderungTypData').click(function () {
            const frm = $('#frmAnforderungsTypEdit');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{ route('getAnforderungTypData') }}",
                data: {
                    id: $('#loadAnforderungTypeId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_at_label').val(jsn.at_label);
                frm.find('#updt_at_name').val(jsn.at_name);
                frm.find('#updt_at_description').val(jsn.at_description);
            });

        });

        $('#loadVerordnungItem').click(function () {
            const frm = $('#frmEditVerordnungen');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getVerordnungData') }}",
                data: {
                    id: $('#loadVerordnungId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_vo_label').val(jsn.vo_label);
                frm.find('#updt_vo_stand').val(jsn.vo_stand);
                frm.find('#updt_vo_nummer').val(jsn.vo_nummer);
                frm.find('#updt_vo_name').val(jsn.vo_name);
                frm.find('#updt_vo_description').val(jsn.vo_description);
            });

        });

        $('#loadProdAnforderungItem').click(function () {
            const frm = $('#frmEditAnforderung');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{ route('getAnforderungData') }}",
                data: {
                    id: $('#loadAnforderungId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_an_label').val(jsn.an_label);
                frm.find('#updt_anforderung_type_id').val(jsn.anforderung_type_id);
                frm.find('#updt_an_name').val(jsn.an_name);
                frm.find('#updt_an_description').val(jsn.an_description);
                frm.find('#updt_an_control_interval').val(jsn.an_control_interval);
                frm.find('#updt_control_interval_id').val(jsn.control_interval_id);
            });

        });

        $('#loadDokumentenTypeItem').click(function () {
            const frm = $('#frmEditDokumentenTyp');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getDokumentTypeData') }}",
                data: {
                    id: $('#loadDokumentenTypId :selected').val(),
                    _token: $('input[name="_token"]').val()
                }
            }).done(function (jsn) {
                frm.find('#updt_doctyp_label').val(jsn.doctyp_label);
                frm.find('#updt_doctyp_name').val(jsn.doctyp_name);
                frm.find('#updt_doctyp_description').val(jsn.doctyp_description);

                if (jsn.doctyp_mandatory === 1) {
                    frm.find('#updt_doctyp_mandatory_ja').prop('checked', true)
                } else {
                    frm.find('#updt_doctyp_mandatory_nein').prop('checked', false)
                }

            });

        });

        $('.showUsedAddresses').click(function () {
            const nd = $('#frmDeleteAddressTypeid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedAdressesByAdressType",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {
                    $('.usedAddressesListItem, .usedAddressResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedAdressResult').append(`
                    <span class="btn usedAddressResult text-warning">${z} {{__('Gebäude gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedAddressesListe').append(`
                    <li class="list-group-item usedAddressesListItem bg-warning text-white">${item.ad_label} - <span class="text-truncate">${item.ad_name}</span></li>
                    `);
                        });
                    } else {
                        $('#usedAddressesListe').append(`
                    <li class="list-group-item usedAddressesListItem bg-success text-white">{{__('Es sind keine Adressen mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedStellplatz').click(function () {
            const nd = $('#frmDeleteStellPlatzTypeid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{ route('getUsedStellplatzByType') }}",
                data: {
                    id: nd.val(),
                },


                success: function (res) {
                    $('.usedStellplatzListItem, .usedStellPlatzListe').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedStellPlaetze').append(`
                    <span class="btn usedStellPlatzListe text-warning">${z} {{__('Geräte gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedStellPlatzListe').append(`
                    <li class="list-group-item usedStellplatzListItem bg-warning text-white">${item.produkt.prod_label} - <span class="text-truncate">${item.produkt.prod_name}</span></li>
                    `);
                        });
                    } else {
                        $('#usedStellPlatzListe').append(`
                    <li class="list-group-item usedStellplatzListItem bg-success text-white">{{__('Es sind keine Geräte mit diesem Stelplatztyp verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedBuildings').click(function () {
            const nd = $('#frmDeleteBuildingTypeid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedBuildingsByBuildingType",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {
                    $('.usedBuildingListItem, .usedBuildingResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedBuildingsResult').append(`
                    <span class="btn usedBuildingResult text-warning">${z} {{__('Gebäude gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedBuildingTypeListe').append(`
                    <li class="list-group-item usedBuildingListItem bg-warning text-white">${item.b_label} - ${item.b_name_ort}</li>
                    `);
                        });
                    } else {
                        $('#usedBuildingTypeListe').append(`
                    <li class="list-group-item usedBuildingListItem bg-success text-white">{{__('Es sind keine Gebäude mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedRooms').click(function () {
            const nd = $('#frmDeleteRaumTypeid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedRoomsByRoomType",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedRoomsListItem, .usedRoomsResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedRoomsResult text-warning">${z} {{__('Räume gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedRoomsListe').append(`
                    <li class="list-group-item usedRoomsListItem bg-warning text-white">${item.r_label} - ${item.r_name}</li>
                    `);
                        });
                    } else {
                        $('#usedRoomsListe').append(`
                    <li class="list-group-item usedRoomsListItem bg-success text-white">{{__('Es sind keine Räume mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedProdukte').click(function () {
            const nd = $('#frmDeleteProderialKategorieid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedProdukteByKategorie",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedProdStammListItem, .usedProdStammResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedProdStammResult text-warning">${z} {{__('Produkte gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-warning text-white">${item.mat_name_nummer} - ${item.mat_label}</li>
                    `);
                        });
                    } else {
                        $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-success text-white">{{__('Es sind keine Produkte mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedAnforderungProdukte').click(function () {
            const nd = $('#frmDeleteAnforderungId :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedEquipmentByProdAnforderung",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedProdStammListItem, .usedProdStammResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedProdStammResult text-warning">${z} {{__('Produkte gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-warning text-white">${item.mat_name_nummer} - ${item.mat_label}</li>
                    `);
                        });
                    } else {
                        $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-success text-white">{{__('Es sind keine Produkte mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('.showUsedAnordnungen').click(function () {
            const nd = $('#frmDeleteVerordnungid :selected');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{ route('getUsedAnforderungByVerordnung') }}",
                data: {
                    id: nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedAnordnungListItem, .usedProdStammResult').remove();
                    if (res.length > 0) {
                        let z = res.length;
                        $('.showUsedAnordnungenResults').append(`
                    <span class="btn usedProdStammResult text-warning">${z} {{__('Anforderungen gefunden!')}}</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedAnordnungenListe').append(`
                    <li class="list-group-item usedAnordnungListItem bg-warning text-white">${item.an_label} - ${item.an_name}</li>
                    `);
                        });
                    } else {
                        $('#usedAnordnungenListe').append(`
                    <li class="list-group-item usedAnordnungListItem bg-success text-white">{{__('Es sind keine Anforderungen mit diesem Typ verknüpft!')}}</li>
                    `);
                    }
                }
            });
        });

        $('#getProduktKategorieParamListe').click(function () {
            const nd = $('#getProduktKategorieParams :selected');
            $('.showProduktKategorieParamListItem').remove();
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getProduktKategorieParams",
                data: {
                    id: nd.val(),
                },
                success: function (res) {

                    $.each(res, function (ui, item) {
                        $('#showProduktKategorieParamListe').append(`
                     <div class="card p-2 mb-4 showProduktKategorieParamListItem" id="pkp_${item.id}">
                        <form action="/updateProduktKategorieParams" method="post" id="updateProduktKategorieParams_${item.id}">
                            @csrf
                        @method('PUT')
                        <input type="hidden" id="produkt_kategorie_id_${item.id}" name="produkt_kategorie_id" value="${item.produkt_kategorie_id}">
                            <input type="hidden" id="id_${item.id}" name="id" value="${item.id}">
                            <div class="mb-2">
                                <label for="pkp_label_${item.id}">{{__('Label')}}</label>
                                <input type="text" name="pkp_label" id="pkp_label_${item.id}" class="form-control checkLabel" value="${item.pkp_label}">
                                <p class="small text-primary">{{__('erforderlich, max 20 Zeichen, ohne Sonder- und Leerzeichen')}}</p>
                            </div>
                            <div class="mb-2">
                                <label for="pkp_name_${item.id}">Name</label>
                                <input type="text" name="pkp_name" id="pkp_name_${item.id}" class="form-control" value="${item.pkp_name}">
                                 <p class="small text-primary">{{__('maximal 150 Zeichen')}}</p>
                            </div>
                            <div class="input-group mt-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-link mr-2 btnUpdatePKParam" data-id="${item.id}"><span class="fas fa-download ml-md-2"></span> {{__('speichern')}}</button>
                                <button type="button" class="btn btn-sm btn-link btnDeletePKParam" data-id="${item.id}">{{__('Löschen')}} <span class="far fa-trash-alt"></span></button>
                            </div>
                        </form>
                        <form method="post" action="{{ route('deleteProduktKategorieParam') }}#Produkte" id="frmDeleteProduktKategorieParam_${item.id}">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" id="pkp_id_${item.id}" name="id" value="${item.id}">
                        <input type="hidden" id="pkp_label_${item.id}" name="pkp_label" value="${item.pkp_label}">
                        </form>
                    </div>
                `);
                    });
                }
            });
        });

        $(document).on('click', '.btnUpdatePKParam', function () {
            const pkp_id = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/updateProduktKategorieParams",
                data: $('#updateProduktKategorieParams_' + pkp_id).serialize(),
                success: (res) => {
                    if (res) $('#toastMessageBody').html(`Das Datenfeld <strong>${$('#pkp_name_' + pkp_id).val()}</strong> wurde aktualisiert!`);
                    jQuery('.toast').toast('show');
                },
                error: (er) => {
                    console.log(er.responseJSON.errors.pkp_label);
                    $('#toastMessageBody').text(er.responseJSON.errors.pkp_label);
                    jQuery('.toast').toast('show');
                }
            })
        });

        $(document).on('click', '.btnDeletePKParam', function () {
            const pkp_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedProduktsByPK",
                data: {id: pkp_id},
                success: function (res) {
                    if (res > 0) {
                        $('#frmDeleteProduktKategorieParam #id').val(pkp_id);
                        $('#warningDeleteProduktKategorieParamBody').html(`
                    <p class="lead">Es sind insgesamt <span class="badge badge-warning">${res}</span> Produkte in dieser Kategorie vorhanden.</p>
                     <p class="lead text-danger">{{__('Alle Einträge zu diesem Datenfeld gehen unwiderruflich verloren!')}}</p>
                    `);
                        $('#warningDeleteProduktKategorieParam').modal('show');
                    } else {
                        $('#frmDeleteProduktKategorieParam_' + pkp_id).submit();
                    }
                }
            })

        });

        $('.btnEditACI').click(function () {
            const aciid = $(this).data('aciid');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungControlItemData') }}",
                data: {id: aciid},
                success: function (res) {
                    $('#aci_id').val(res.id);
                    $('#updt_anforderung_id').val(res.anforderung_id);
                    $('#updt_aci_label').val(res.aci_label);
                    $('#updt_aci_name').val(res.aci_name);
                    $('#updt_aci_task').val(res.aci_task);
                    $('#updt_aci_value_si').val(res.aci_value_si);
                    $('#updt_aci_vaule_soll').val(res.aci_vaule_soll);
                    if (res.firma_id === '1') {
                        $('#updt_firma_id').val(res.firma_id);
                        $('#updt_aci_internal').prop('checked', true);
                    } else {
                        $('#updt_aci_contact_id').val(res.aci_contact_id);
                    }

                    $('#updt_firma_id').val(res.aci);
                    $('#modalEditAnforderungControlItem').modal('show');
                }
            });


        })

        $('#makePkParam').click(function () {
            const nd = $('#getProduktKategorieParams :selected');
            $('#frmAddProduktKategorieParam #produkt_kategorie_id').val(
                nd.val()
            );
            $('#modalAddProduktKategorieParam').modal('show');
        });

        $('#openNewAnforderungControlItemModal').click(function () {
            const nd = $('#loadAnforderungControlItems :selected');
            $('#anforderung_id').val(
                nd.val()
            );
            $('#modalAddNewAnforderungControlItem').modal('show');
        });

    </script>


@endsection
