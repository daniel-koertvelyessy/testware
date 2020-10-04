@extends('layout.layout-admin')

@section('pagetitle','Systemeinstellungen')

@section('mainSection')
    Admin
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection


@section('modals')
    <div class="modal fade" id="warningDeleteProduktKategorieParam" tabindex="-1" aria-labelledby="warningDeleteProduktKategorieParamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('deleteProduktKategorieParam') }}#Produkte" method="POST" name="frmDeleteProduktKategorieParam" id="frmDeleteProduktKategorieParam">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="id">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white" id="warningDeleteProduktKategorieParamLabel">Warnung</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="warningDeleteProduktKategorieParamBody">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="closeModalDeleteProdKat" data-dismiss="modal">Abbruch</button>
                        <button class="btn btn-outline-warning" id="btnDeleteParam">Datenfeld dennoch löschen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalAddProduktKategorieParam" tabindex="-1" aria-labelledby="modalAddProduktKategorieParamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('addProduktKategorieParam') }}#Produkte" method="POST" name="frmAddProduktKategorieParam" id="frmAddProduktKategorieParam">
                @csrf
                <input type="hidden" name="produkt_kategorie_id" id="produkt_kategorie_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Neues Datenfeld anlegen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="pkp_label">Label</label>
                            <input type="text" name="pkp_label" id="pkp_label" class="form-control checkLabel">
                            <p class="small text-primary">erforderlich, max 20 Zeichen, ohne Sonder- und Leerzeichen</p>
                        </div>
                        <div class="mb-2">
                            <label for="pkp_name">Name</label>
                            <input type="text" name="pkp_name" id="pkp_name" class="form-control">
                            <p class="small text-primary">maximal 150 Zeichen</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Abbruch</button>
                        <button class="btn btn-primary">Datenfeld speichern</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalAddNewAnforderungControlItem" tabindex="-1" aria-labelledby="modalAddNewAnforderungControlItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Neuen Vorgang anlegen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('components.addNewAnforderungControlItem')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditAnforderungControlItem" tabindex="-1" aria-labelledby="modalEditAnforderungControlItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('updateAnforderungControlItem') }}#Produkte" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden"
                           name="id"
                           id="aci_id"
                    >
                    <div class="modal-header">
                        <h5 class="modal-title">Vorgang bearbeiten</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-selectfield id="updt_anforderung_id" name="anforderung_id" label="Anforderung">
                            @foreach (App\Anforderung::all() as $anforderung)
                                <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_lang }}</option>
                            @endforeach
                        </x-selectfield>
                        <div class="row">
                            <div class="col-md-4">
                                <x-rtextfield name="aci_name_kurz" id="updt_aci_name_kurz" label="Kürzel" />
                            </div>
                            <div class="col-md-8">
                                <x-rtextfield name="aci_name_lang" id="updt_aci_name_lang" label="Name" max="150" />
                            </div>
                        </div>

                        <x-textarea name="aci_task" id="updt_aci_task" label="Aufgabe" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-textfield name="aci_value_si" id="updt_aci_value_si" label="SI-Einheit [kg, °C, V usw]" max="10" />
                            </div>
                            <div class="col-md-4">
                                <x-textfield name="aci_vaule_soll" id="updt_aci_vaule_soll" label="Sollwert" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio custom-control-inline mb-3">
                                    <input type="radio" id="updt_aci_internal" name="aci_exinternal" class="custom-control-input" value="internal" checked>
                                    <label class="custom-control-label" for="updt_aci_internal">Interne Durchführung</label>
                                </div>
                                <x-selectfield name="aci_contact_id" id="updt_aci_contact_id" label="Mitarbeiter">
                                    @foreach (App\Profile::all() as $profile)
                                        <option value="{{ $profile->id }}">{{ substr($profile->ma_vorname,0,1)}}. {{ $profile->ma_name }}</option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio custom-control-inline mb-3">
                                    <input type="radio" id="updt_aci_external" name="aci_exinternal" class="custom-control-input" value="external">
                                    <label class="custom-control-label" for="updt_aci_external">Externe Durchführung</label>
                                </div>
                                <x-selectfield id="updt_firma_id" label="Firma">
                                    @foreach (App\Firma::all() as $firma)
                                        <option value="{{ $firma->id }}">{{ $firma->fa_name_lang }}</option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Abbruch</button>
                            <button class="btn btn-primary">Vorgang speichern</button>
                        </div>
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
                <h1 class="h3">System Einstellungen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <a class="nav-link active" id="Objekte-tab" data-toggle="tab" href="#Objekte" role="tab" aria-controls="Objekte" aria-selected="true">Objekte</a>
                    <a class="nav-link" id="Produkte-tab" data-toggle="tab" href="#Produkte" role="tab" aria-controls="Produkte" aria-selected="false">Produkte</a>
                    <a class="nav-link" id="Belege-tab" data-toggle="tab" href="#Belege" role="tab" aria-controls="Belege" aria-selected="false">Belege</a>
                    <a class="nav-link" id="Anzeige-tab" data-toggle="tab" href="#Anzeige" role="tab" aria-controls="Anzeige" aria-selected="false">Anzeige</a>
                </nav>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2 " id="Objekte" role="tabpanel" aria-labelledby="Objekte-tab">
                        <div class="row">
                            <div class="col-md-3  border-right">
                                <nav class="nav flex-column nav-pills" id="tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="sysTypeAdress-tab" data-toggle="pill" href="#sysTypeAdress" role="tab" aria-controls="sysTypeAdress" aria-selected="true">Adressen</a>
                                    <a class="nav-link" id="sysTypeGebaeude-tab" data-toggle="pill" href="#sysTypeGebaeude" role="tab" aria-controls="sysTypeGebaeude" aria-selected="false">Gebäude</a>
                                    <a class="nav-link" id="sysTypRooms-tab" data-toggle="pill" href="#sysTypRooms" role="tab" aria-controls="sysTypRooms" aria-selected="false">Räume</a>
                                    <a class="nav-link" id="sysTypeStellPlatz-tab" data-toggle="pill" href="#sysTypeStellPlatz" role="tab" aria-controls="sysTypeStellPlatz" aria-selected="false">Stellplatz</a>
                                </nav>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="tabContent">
                                    <div class="tab-pane fade show active" id="sysTypeAdress" role="tabpanel" aria-labelledby="sysTypeAdress-tab">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createAddressType') }}#Objekte"
                                                      method="POST" class="needs-validation"
                                                      id="addNewAdressType" name="addNewAdressType"
                                                >
                                                    @csrf

                                                    <x-rtextfield id="adt_name" label="Kürzel" />

                                                    <x-textarea id="adt_text_lang" label="Beschreibung des Adresstyps" />
                                                    <x-btnMain>Neuen Adresstyp anlegen <span class="fas fa-download"></span></x-btnMain>

                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\AddressType::all())>0 )
                                                    <form action="{{ route('updateAddressType') }}" method="POST" id="frmEditAddressTyp" name="frmEditAddressTyp">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadAdressTypId">Adress-Typ auswählen</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id" id="loadAdressTypId" class="custom-select">
                                                                @foreach (App\AddressType::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->adt_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadAdressTypeItem" block="1">Adresstyp laden</x-btnLoad>
                                                        </div>
                                                        <x-rtextfield id="upd_adt_name" name="adt_name" label="Name" />
                                                        <x-textarea id="upd_adt_text_lang" name="adt_text_lang"
                                                                    label="Beschreibung des Adresstyps"
                                                                    value="{{ old('adt_text_lang') ?? '' }}" />
                                                        <x-btnSave>Adresstyp aktualisieren</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border border-danger p-3">
                                                    <h2 class="h5">Adresstyp löschen</h2>
                                                    <form action="{{ Route('deleteTypeAdress') }}" id="frmDeleteAddressType" name="frmDeleteAddressType" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="input-group mb-3">
                                                            <label for="frmDeleteAddressTypeid" class="sr-only">Adress-typ auswählen</label>
                                                            <select name="id" id="frmDeleteAddressTypeid" class="custom-select">
                                                                @foreach (App\AddressType::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->adt_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnDelete block="1">Adresstyp löschen</x-btnDelete>
                                                        </div>
                                                        <p class="text-danger lead">Bitte beachten Sie, dass Adressen diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche Adressen von der Löschung betroffen sein werden!</p>
                                                    </form>
                                                    <div class="input-group mb-3 showUsedAdressResult">
                                                        <x-btnFetch class="showUsedAddresses">Betroffene Adressen anzeigen</x-btnFetch>
                                                    </div>
                                                    <ul class="list-group mt-3" id="usedAddressesListe">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sysTypeGebaeude" role="tabpanel" aria-labelledby="sysTypeGebaeude-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form action="{{ route('createBuildingType') }}" method="POST" class="needs-validation" id="frmCreateBuildingType" name="frmCreateBuildingType">
                                                    @csrf
                                                    <x-rtextfield id="btname" label="Name" />
                                                    <x-textarea id="btbeschreibung"
                                                                label="Beschreibung des Adresstyps"
                                                                value="{{ old('btbeschreibung') ?? '' }}" />

                                                    <x-btnMain>Gebäudetyp anlegen <span class="fas fa-download"></span></x-btnMain>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\BuildingTypes::all())>0 )
                                                    <form action="{{ route('updateBuildingType') }}" method="POST" id="frmEditBuildingTyp" name="frmCreateBuildingType">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="btid">Gebäudetyp auswählen</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id" id="btid" class="custom-select">
                                                                @foreach (App\BuildingTypes::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->btname }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadBuildingTypeItem" block="1">Gebäudetyp laden</x-btnLoad>
                                                        </div>
                                                        <x-rtextfield id="upd_btname" name="btname" label="Name" />
                                                        <x-textarea id="upd_btbeschreibung" name="btbeschreibung"
                                                                    label="Beschreibung des Adresstyps"
                                                                    value="{{ old('btbeschreibung') ?? '' }}" />
                                                        <x-btnSave id="btnUpdateBuildingType">Gebäudetyp aktualisieren</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border border-danger p-3">
                                                    <h2 class="h5">Gebäudetyp löschen</h2>
                                                    <form action="{{ Route('deleteBuildingType') }}" method="post"
                                                          name="frmDeleteBuildingType" id="frmDeleteBuildingType"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="input-group mb-3">
                                                            <label for="frmDeleteBuildingTypeid" class="sr-only">Gebäudetyp auswählen</label>
                                                            <select name="id" id="frmDeleteBuildingTypeid" class="custom-select">
                                                                @foreach (App\BuildingTypes::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->btname }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnDelete block="1">Gebäudetyp löschen</x-btnDelete>
                                                        </div>
                                                        <p class="text-danger lead">Bitte beachten Sie, dass mit diesem Typ verknüpfte Datensätze verloren gehen können! Bitte prüfen Sie vorab, welche Gebäude von der Löschung betroffen sein werden!</p>
                                                    </form>
                                                    <div class="input-group mb-3 showUsedBuildingsResult">
                                                        <x-btnFetch class="showUsedBuildings">Betroffene Gebäude anzeigen</x-btnFetch>
                                                    </div>
                                                    <ul class="list-group mt-3" id="usedBuildingTypeListe">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sysTypRooms" role="tabpanel" aria-labelledby="sysTypRooms-tab">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createRoomType') }}" method="POST" class="needs-validation" id="addNewRoomType" name="addNewRoomType">
                                                    @csrf
                                                    <x-rtextfield id="rt_name_kurz" label="Kürzel" />

                                                    <x-textfield id="rt_name_lang" label="Name " />

                                                    <x-textarea id="rt_name_text" label="Beschreibung des Raumtyps" />

                                                    <x-btnMain>Neuen Raumtyp anlegen <span class="fas fa-download"></span></x-btnMain>

                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\RoomType::all())>0 )
                                                    <form action="{{ route('updateRoomType') }}" method="POST" id="frmEditRoomTyp" name="frmEditRoomTyp">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadRoomTyeid">Raumtyp auswählen</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id" id="loadRoomTyeid" class="custom-select">
                                                                @foreach (App\RoomType::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->rt_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad block="1" id="loadRoomTypeItem">Raumtyp laden</x-btnLoad>
                                                        </div>

                                                        <x-rtextfield id="updt_rt_name_kurz" name="rt_name_kurz" label="Kürzel" />

                                                        <x-textfield id="updt_rt_name_lang" name="rt_name_lang" label="Name" />

                                                        <x-textarea id="upd_rt_name_text" name="rt_name_text" label="Beschreibung des Raumtyps" />

                                                        <x-btnSave>Raumtyp aktualisieren</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\RoomType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Raumtyp löschen</h2>
                                                        <form action="{{ Route('deleteRoomType') }}" id="frmDeleteRoomType" name="frmDeleteRoomType" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteRaumTypeid" class="sr-only">Raumtyp auswählen</label>
                                                                <select name="id" id="frmDeleteRaumTypeid" class="custom-select">
                                                                    @foreach (App\RoomType::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->rt_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1">Raumtyp löschen</x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass Räume diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche Adressen von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedRoomsResult">
                                                            <x-btnFetch class="showUsedRooms">Betroffene Räume anzeigen</x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedRoomsListe">
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sysTypeStellPlatz" role="tabpanel" aria-labelledby="sysTypeStellPlatz-tab">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createStellPlatzType') }}" method="POST"
                                                      class="needs-validation" id="addNewStellPlatzType" name="addNewStellPlatzType"
                                                >
                                                    @csrf

                                                    <x-rtextfield id="spt_name_kurz" label="Name" />

                                                    <x-textfield id="spt_name_lang" label="Name" />

                                                    <x-textarea id="spt_name_text" label="Beschreibung des Stellplatztyps" />

                                                    <x-btnMain>Neuen Stellplatztyp anlegen</x-btnMain>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\StellplatzTyp::all())>0 )
                                                    <form action="{{ route('updateStellPlatzType') }}" method="POST" id="frmEditStellPlatzTyp" name="frmEditStellPlatzTyp">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadStellPlatzTyeid" class="sr-only">Stellplatztyp auswählen</label>
                                                            <select name="id" id="loadStellPlatzTyeid" class="custom-select">
                                                                @foreach (App\StellplatzTyp::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->spt_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadStellPlatzTypeItem" block="1">Stellplatztyp laden</x-btnLoad>
                                                        </div>

                                                        <x-rtextfield id="updt_spt_name_kurz" name="spt_name_kurz" label="Kürzel" />

                                                        <x-textfield name="spt_name_lang" id="updt_spt_name_lang" label="Name" />

                                                        <x-textarea id="updt_spt_name_text" name="spt_name_text" label="Beschreibung des Stellplatztyps" />

                                                        <x-btnSave>Stellplatztyp aktualisieren</x-btnSave>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\StellplatzTyp::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Stellplatztyp löschen</h2>
                                                        <form action="{{ Route('deleteStellPlatzType') }}" id="frmDeleteStellPlatzType" name="frmDeleteStellPlatzType" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteStellPlatzTypeid" class="sr-only">StellPlatztyp auswählen</label>
                                                                <select name="id" id="frmDeleteStellPlatzTypeid" class="custom-select">
                                                                    @foreach (App\StellplatzTyp::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->spt_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1">Stellplatztyp löschen</x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass Stellplätze diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedStellPlaetze">
                                                            <x-btnFetch class="showUsedStellplatz">Betroffene Stellplätze anzeigen</x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedStellPlatzListe">
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2" id="Produkte" role="tabpanel" aria-labelledby="Produkte-tab">
                        <div class="row">
                            <div class="col-lg-3 col-md-2">
                                <nav class="nav flex-column nav-pills" id="tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="prodKategorie-tab"
                                       data-helpertext="Erstellen Sie allgemeine Produktypen unter der Sie die Produkte zusammenfassen können. Beispielsweise Computer, EDV, Werkzeug etc."
                                       data-toggle="pill" href="#prodKategorie" role="tab" aria-controls="prodKategorie" aria-selected="true">Kategorien</a>
                                    <a class="nav-link" id="prodVerordnung-tab"
                                       data-helpertext="Verordnungen regeln die Einteilung der Produkte->Geräte in Risikogruppen und bestimmen den Umfang der Prüfungen"
                                       data-toggle="pill" href="#prodVerordnung" role="tab" aria-controls="prodVerordnung" aria-selected="false">Verordnungen</a>

                                    <a class="nav-link" id="prodAnforderungTyp-tab"
                                       data-toggle="pill"
                                       data-helpertext="Anforderungen können verschiedene Aufgaben umfassen. Mit Hilfe von Anforderungstypen können Sie diese gruppieren."
                                       href="#prodAnforderungTyp" role="tab" aria-controls="prodAnforderungTyp" aria-selected="false">Anforderung-Typen</a>
                                    <a class="nav-link" id="prodAnforderung-tab"
                                       data-toggle="pill"
                                       data-helpertext="Anforderungen können Prüfungen oder Handhabungen sein. Diese können sich auf eine ausgewählte Verordnung beziehen. Anforderungen können als Beispiel die besondere Handhabung oder Lagerung des Produkte sein. In der Regel müssen die Anforderungen überprüft werden."
                                       href="#prodAnforderung" role="tab" aria-controls="prodAnforderung" aria-selected="false">Anforderungen</a>
                                    <a class="nav-link" id="prodControl-tab"
                                       data-toggle="pill"
                                       data-helpertext="Aus Anforderungen entstehen unter Umständen Prüfungen, die regelmäßig erfolgen müssen."
                                       href="#prodControl" role="tab" aria-controls="prodControl" aria-selected="false">Vorgänge</a>
                                    <a class="nav-link" id="doctypes-tab"
                                       data-helpertext="Erstellen Sie Dokument-Typen wie zum Beispiel Bedienungs-anleitungen, Zeichnugen oder Kataloge."
                                       data-toggle="pill" href="#doctypes" role="tab" aria-controls="doctypes" aria-selected="false">Dokument</a>
                                </nav>
                                <div class="navTextHelper mt-3 p-3 border border-primary rounded d-none d-md-block">
                                    Erstellen Sie allgemeine Produktypen unter der Sie die Produkte zusammenfassen können. Beispielsweise Computer, EDV, Werkzeug etc.
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-10">
                                <div class="tab-content" id="tabContent">
                                    <div class="tab-pane fade show active" id="prodKategorie" role="tabpanel" aria-labelledby="prodKategorie-tab">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <h3 class="h4">Kategorien</h3>
                                                <p>Ordnen Sie Ihre Produkte nach Kategorien ein.</p>
                                                <form action="{{ route('createProdKat') }}#Produkte"
                                                      method="POST" class="needs-validation"
                                                      id="frmAddNewProduktKategorie" name="frmAddNewProduktKategorie"
                                                >
                                                    @csrf
                                                    <x-rtextfield id="pk_name_kurz" label="Name - Kürzel" />

                                                    <x-textfield id="pk_name_lang" label="Name" />

                                                    <x-textarea id="pk_name_text" label="Beschreibung" />

                                                    <x-btnMain>Neue Kategorie anlegen <span class="fas fa-download"></span></x-btnMain>

                                                </form>
                                                <div class="dropdown-divider my-2"></div>
                                                @if (count(App\ProduktKategorie::all())>0 )

                                                    <form action="{{ route('updateProdKat') }}" method="POST" id="frmEditProdKategorie" name="frmEditProdKategorie">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="loadProdKategorieId">Kategorie zum Bearbeiten auswählen</label>
                                                        <div class="input-group mb-3">
                                                            <select name="id" id="loadProdKategorieId" class="custom-select">
                                                                @foreach (App\ProduktKategorie::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->pk_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad block="1" id="loadProdKategorieItem">Kategorie laden</x-btnLoad>
                                                        </div>
                                                        <div class="dropdown-divider my-3"></div>

                                                        <x-rtextfield id="upd_pk_name_kurz" name="pk_name_kurz" label="Name - Kürzel" />

                                                        <x-textfield id="updt_pk_name_lang" name="pk_name_lang" label="Name" />

                                                        <x-textarea id="updt_pk_name_text" name="pk_name_text" label="Beschreibung" />

                                                        <x-btnSave>Kategorie aktualisieren</x-btnSave>

                                                    </form>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                @if (count(App\ProduktKategorie::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Kategorie löschen</h2>
                                                        <form action="{{ Route('deleteProdKat') }}"
                                                              id="frmDeleteProduktKategorie" name="frmDeleteProduktKategorie"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteProduktKategorieid" class="sr-only">Kategorie auswählen</label>
                                                                <select name="id" id="frmDeleteProduktKategorieid" class="custom-select">
                                                                    @foreach (App\ProduktKategorie::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->pk_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block="1">Kategorie löschen</x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass Produkte & Geräte diesen Typs verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedProduktsResult">
                                                            <x-btnFetch class="showUsedProdukts">Betroffene Produkte & Geräte anzeigen</x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedProduktsListe">
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <h3 class="h4">Datenfelder</h3>
                                                <p>Datenfelder ergänzen die vorgegebene Struktur der Produkte, basierend auf der gewählten Produkt-Kategorie.</p>
                                                <div class="input-group mb-3">
                                                    <label for="getProduktKategorieParams" class="sr-only">Kategorie auswählen</label>
                                                    <select name="id" id="getProduktKategorieParams" class="custom-select">
                                                        @foreach (App\ProduktKategorie::all() as $ad)
                                                            <option value="{{ $ad->id }}">
                                                                {{ $ad->pk_name_kurz }} {{ ($ad->ProduktKategorieParam->count()>0) ? ' ('.$ad->ProduktKategorieParam->count() . ')' :'' }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <x-btnLoad id="getProduktKategorieParamListe" block="1">Datenfelder laden</x-btnLoad>

                                                    <x-btnAdd id="makePkParam" block="1">Neu</x-btnAdd>
                                                </div>
                                                <div id="showProduktKategorieParamListe">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="prodVerordnung" role="tabpanel" aria-labelledby="prodVerordnung-tab">
                                        <form action="{{ route('createVerordnung') }}#Produkte" method="POST"
                                              class="needs-validation" id="frmAddNewVerordnung" name="frmAddNewVerordnung"
                                        >
                                            @csrf
                                            <x-rtextfield id="vo_name_kurz" label="Name - Kürzel" />

                                            <x-textfield id="vo_name_lang" label="Name" />

                                            <x-textfield id="vo_nummer" label="Nummer/Zeichen" />

                                            <x-textfield id="vo_stand" label="Stand" />

                                            <x-textarea id="vo_name_text" label="Beschreibung" />

                                            <x-btnMain>Neue Verordnung anlegen <span class="fas fa-download"></span></x-btnMain>

                                        </form>
                                        <div class="row mt-3">
                                            <div class="col-lg-6 mb-3">

                                                @if (count(App\Verordnung::all())>0 )
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('updateVerordnung') }}#Produkte" method="POST" id="frmEditVerordnungen" name="frmEditVerordnungen">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadVerordnungId" class="sr-only">Verordnung auswählen</label>
                                                            <select name="id" id="loadVerordnungId" class="custom-select">
                                                                @foreach (App\Verordnung::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->vo_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-btnLoad id="loadVerordnungItem" block="1">Verordnung laden</x-btnLoad>
                                                        </div>

                                                        <x-rtextfield id="updt_vo_name_kurz" name="vo_name_kurz" label="Name - Kürzel" />

                                                        <x-textfield id="updt_vo_name_lang" name="vo_name_lang" label="Name" />

                                                        <x-textfield id="updt_vo_nummer" name="vo_nummer" label="Nummer/Zeichen" />

                                                        <x-textfield id="updt_vo_stand" name="vo_stand" label="Stand" />

                                                        <x-textarea id="updt_vo_name_text" name="vo_name_text" label="Beschreibung" />

                                                        <x-btnSave>Verordnung aktualisieren</x-btnSave>

                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\Verordnung::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Verordnung löschen</h2>
                                                        <form action="{{ route('deleteVerordnung') }}#Produkte" id="frmDeleteVerordnung" name="frmDeleteVerordnung" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteVerordnungid" class="sr-only">Kategorie auswählen</label>
                                                                <select name="id" id="frmDeleteVerordnungid" class="custom-select">
                                                                    @foreach (App\Verordnung::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->vo_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <x-btnDelete block>Kategorie löschen </x-btnDelete>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass Anordnungen und Vorgänge aus dieser Verordnung verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedAnordnungenResults">
                                                            <x-btnFetch class="showUsedAnordnungen">Betroffene Anordnungen anzeigen</x-btnFetch>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedAnordnungenListe">
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="prodAnforderungTyp" role="tabpanel" aria-labelledby="prodAnforderungTyp-tab">
                                        <form action="{{ route('addNewAnforderungType') }}#Produkte"
                                              method="post" id="frmAddNewAnforderungsType"
                                        >
                                            @csrf
                                            <x-rtextfield id="at_name_kurz"
                                                          label="Kürzel"
                                            />
                                            <x-textfield id="at_name_lang"
                                                         label="Name"
                                            />
                                            <x-textarea id="at_name_text"
                                                        label="Beschreibung"
                                            />

                                            <x-btnMain>Anforderungstyp anlegen <span class="fas fa-download"></span></x-btnMain>
                                        </form>
                                        <div class="dropdown-divider my-3"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form action="{{ route('updateAnforderungType') }}#Produkte"
                                                      method="post" id="frmAnforderungsTypEdit"
                                                >
                                                    @csrf
                                                    @method('put')
                                                    <x-selectgroup id="loadAnforderungTypeId" name="id"
                                                                   label="Anwendung-Typ wählen"
                                                                   btnL="Typ laden" btnT="getAnforderungTypData"
                                                    >
                                                        @foreach(App\AnforderungType::all() as $anforderungType)
                                                            <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name_kurz }}</option>
                                                        @endforeach
                                                    </x-selectgroup>
                                                    <x-rtextfield id="updt_at_name_kurz" name="at_name_kurz" label="Kürzel" />
                                                    <x-textfield id="updt_at_name_lang" name="at_name_lang" label="Name" />
                                                    <x-textarea id="updt_at_name_text" name="at_name_text" label="Beschreibung" />
                                                    <x-btnSave>Anforderungstyp speichern</x-btnSave>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                @if (count(App\AnforderungType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Anforderung-Typ löschen</h2>
                                                        <form action="{{ route('deleteAnforderungType') }}" id="frmDeleteAnforderungTyp" name="frmDeleteAnforderungTyp" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteAnforderungTypeId" class="sr-only">Typ auswählen</label>
                                                                <select name="id" id="frmDeleteAnforderungTypeId" class="custom-select">
                                                                    @foreach (App\AnforderungType::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->at_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-outline-danger">Anforderung-typ löschen <i class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass mit diesem Typ verknüpfte Objekte verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedAnforderungProdukteResult">
                                                            <button type="button" class="btn btn-outline-secondary showUsedAnforderungProdukte">Betroffene Produkte anzeigen</button>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedAnforderungProdukteListe">
                                                        </ul>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="prodAnforderung" role="tabpanel" aria-labelledby="prodAnforderung-tab">
                                        <form action="{{ route('createAnforderung') }}#Produkte" method="POST" class="needs-validation"
                                              id="frmAddNewAnforderung" name="frmAddNewAnforderung"
                                        >
                                            @csrf
                                            <x-selectfield name="verordnung_id" id="verordnung_id" label="Gehört zu Verordnung">
                                                <option value="">Keine Zuordnung</option>
                                                @foreach (App\Verordnung::all() as $ad)
                                                    <option value="{{ $ad->id }}">{{ $ad->vo_name_kurz }}</option>
                                                @endforeach
                                            </x-selectfield>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-rtextfield id="an_name_kurz" label="Kürzel" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-selectfield id="anforderung_type_id" label="Anforderung Typ" >
                                                        @foreach(App\AnforderungType::all() as $anforderungType)
                                                            <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name_lang }}</option>
                                                        @endforeach
                                                    </x-selectfield>
                                                </div>
                                            </div>

                                            <x-textfield id="an_name_lang" label="Name" />

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-rnumberfield id="an_control_interval" label="Interval Dauer" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-selectfield id="control_interval_id" label="Zeitraum">
                                                        @foreach (App\ControlInterval::all() as $controlInterval)
                                                            <option value="{{ $controlInterval->id }}">{{ $controlInterval->ci_name_lang }}</option>
                                                        @endforeach
                                                    </x-selectfield>
                                                </div>
                                            </div>

                                            <x-textarea id="an_name_text" label="Beschreibung" />

                                            <button class="btn btn-primary btn-block">Neue Produkt-Anforderung anlegen</button>
                                        </form>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                @if (count(App\Anforderung::all())>0 )

                                                    <form action="{{ route('updateAnforderung') }}" method="POST" id="frmEditAnforderung" name="frmEditAnforderung">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadAnforderungId" class="sr-only">Anforderung auswählen</label>
                                                            <select name="id" id="loadAnforderungId" class="custom-select">
                                                                @foreach (App\Anforderung::all() as $anforderung)
                                                                    <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button class="btn btn-outline-primary ml-2" type="button" id="loadProdAnforderungItem">Anforderung laden</button>
                                                        </div>

                                                        <x-rtextfield id="updt_an_name_kurz" name="an_name_kurz" label="Kürzel" />

                                                        <x-textfield  id="updt_an_name_lang" name="an_name_lang" label="Bezeichnung" />
                                                        <x-selectfield id="updt_anforderung_type_id" name="anforderung_type_id" label="Typ der Anforderung">
                                                            @foreach(App\AnforderungType::all() as $anforderungType)
                                                                <option value="{{ $anforderungType->id }}">{{ $anforderungType->at_name_lang }}</option>
                                                            @endforeach
                                                        </x-selectfield>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <x-rnumberfield id="updt_an_control_interval" name="an_control_interval" label="Interval Dauer" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <x-selectfield id="updt_control_interval_id" name="control_interval_id" label="Zeitraum">
                                                                    @foreach (App\ControlInterval::all() as $controlInterval)
                                                                        <option value="{{ $controlInterval->id }}">{{ $controlInterval->ci_name_lang }}</option>
                                                                    @endforeach
                                                                </x-selectfield>
                                                            </div>
                                                        </div>

                                                        <x-textarea id="updt_an_name_text" name="an_name_text" label="Beschreibung" />

                                                        <button class="btn btn-primary btn-block">Anforderung aktualisieren</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                @if (count(App\Verordnung::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Anforderung löschen</h2>
                                                        <form action="{{ Route('deleteAnforderung') }}" id="frmDeleteAnforderung" name="frmDeleteAnforderung" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteAnforderungId" class="sr-only">Anforderung auswählen</label>
                                                                <select name="id" id="frmDeleteAnforderungId" class="custom-select">
                                                                    @foreach (App\Verordnung::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->an_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-outline-danger">Anforderung löschen <i class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass mit diesem Typ verknüpfte Objekte verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedAnforderungProdukteResult">
                                                            <button type="button" class="btn btn-outline-secondary showUsedAnforderungProdukte">Betroffene Produkte anzeigen</button>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedAnforderungProdukteListe">
                                                        </ul>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="prodControl" role="tabpanel" aria-labelledby="prodControl-tab">
                                        <button class="btn btn-primary mb-3" id="openNewAnforderungControlItemModal">Neuen Vorgang anlegen</button>
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th>Anforderung</th>
                                                <th>Vorgang</th>
                                                <th>Intervall</th>
                                                <th>intern/extern</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse(App\Anforderung::all() as $anforderung)
                                                @foreach(App\AnforderungControlItem::where('anforderung_id',$anforderung->id)->get() as $aci)
                                                    <tr>
                                                        <td>{{ $anforderung->an_name_kurz }}</td>
                                                        <td>{{ $aci->aci_name_lang }}</td>
                                                        <td>{{ $anforderung->an_control_interval }} {{ $anforderung->ControlInterval->ci_name }} </td>
                                                        <td>
                                                            @if ($aci->firma_id === 1)
                                                                Intern - {{ App\Profile::find($aci->aci_contact_id)->ma_name }}
                                                            @else{{$aci->firma_id}}
                                                            {{--                                                               Extern - {{ App\Firma::find($aci->firma_id)->fa_name_lang }}--}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <x-deletebutton action="{{ route('deleteAnforderungControlItem',$aci->id) }}" id="{{ $aci->id }}" />
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-secondary btnEditACI" data-aciid="{{ $aci->id }}">
                                                                <span class="fas fa-edit"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr>
                                                    <td colspan="5"><x-notifyer>keine Anforderungen angelegt</x-notifyer></td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="doctypes" role="tabpanel" aria-labelledby="doctypes-tab">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form action="{{ route('createDokumentType') }}#Produkte"
                                                      method="POST" class="needs-validation"
                                                      id="frmAddNewDokumentenTyp" name="frmAddNewDokumentenTyp">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="doctyp_name_kurz">Name - kurz</label>
                                                        <input type="text" name="doctyp_name_kurz" id="doctyp_name_kurz" class="form-control {{ $errors->has('doctyp_name_kurz') ? ' is-invalid ': '' }}" value="{{ old('doctyp_name_kurz') ?? '' }}" required>

                                                        @if ($errors->has('doctyp_name_kurz'))
                                                            <span class="text-danger small">{{ $errors->first('doctyp_name_kurz') }}</span>
                                                        @else
                                                            <span class="small text-primary">max 20 Zeichen, erforderliches Feld</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="doctyp_name_lang">Name - lang</label>
                                                        <input type="text" name="doctyp_name_lang" id="doctyp_name_lang" class="form-control {{ $errors->has('doctyp_name_lang') ? ' is-invalid ': '' }}" value="{{ old('doctyp_name_lang') ?? '' }}" required>
                                                        @if ($errors->has('doctyp_name_lang'))
                                                            <span class="text-danger small">{{ $errors->first('doctyp_name_lang') }}</span>
                                                        @else
                                                            <span class="small text-primary">max 100 Zeichen</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="doctyp_name_text">Beschreibung</label>
                                                        <textarea id="doctyp_name_text" name="doctyp_name_text" class="form-control">{{ old('doctyp_name_text') ?? '' }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="lead">Dokument ist Pflichtteil einer Verordnung</p>
                                                        <div class="pl-3">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" name="doctyp_mandatory" id="doctyp_mandatory_ja" value="1">
                                                                <label class="custom-control-label" for="doctyp_mandatory_ja">
                                                                    ist Teil einer Verordnung
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" name="doctyp_mandatory" id="doctyp_mandatory_nein" value="0" checked>
                                                                <label class="custom-control-label" for="doctyp_mandatory_nein">
                                                                    kein Pflichtteil
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-block">Neuen Dokumententyp anlegen</button>
                                                </form>
                                                @if (count(App\DocumentType::all())>0 )
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('updateDokumentType') }}" method="POST" id="frmEditDokumentenTyp" name="frmEditDokumentenTyp">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group mb-3">
                                                            <label for="loadDokumentenTypId" class="sr-only">Dokumententyp auswählen</label>
                                                            <select name="id" id="loadDokumentenTypId" class="custom-select">
                                                                @foreach (App\DocumentType::all() as $ad)
                                                                    <option value="{{ $ad->id }}">{{ $ad->doctyp_name_kurz }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button class="btn btn-outline-primary" type="button" id="loadDokumentenTypeItem">Anforderung laden</button>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="updt_doctyp_name_kurz">Name - kurz</label>
                                                            <input type="text" name="doctyp_name_kurz" id="updt_doctyp_name_kurz" class="form-control {{ $errors->has('doctyp_name_kurz') ? ' is-invalid ': '' }}" value="{{ old('doctyp_name_kurz') ?? '' }}" required>
                                                            @if ($errors->has('doctyp_name_kurz'))
                                                                <span class="text-danger small">{{ $errors->first('doctyp_name_kurz') }}</span>
                                                            @else
                                                                <span class="small text-primary">max 20 Zeichen, erforderlichen Feld</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="updt_doctyp_name_lang">Name - lang</label>
                                                            <input type="text" name="doctyp_name_lang" id="updt_doctyp_name_lang" class="form-control {{ $errors->has('doctyp_name_lang') ? ' is-invalid ': '' }}" value="{{ old('doctyp_name_lang') ?? '' }}" required>
                                                            @if ($errors->has('doctyp_name_lang'))
                                                                <span class="text-danger small">{{ $errors->first('doctyp_name_lang') }}</span>
                                                            @else
                                                                <span class="small text-primary">max 100 Zeichen</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="updt_doctyp_name_text">Beschreibung </label>
                                                            <textarea id="updt_doctyp_name_text" name="doctyp_name_text" class="form-control">{{ old('doctyp_name_text') ?? '' }}</textarea>
                                                        </div>
                                                        <div class="form-group pl-2">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" name="doctyp_mandatory" id="updt_doctyp_mandatory_ja" value="1">
                                                                <label class="custom-control-label" for="updt_doctyp_mandatory_ja">
                                                                    ist Teil einer Verordnung
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" name="doctyp_mandatory" id="updt_doctyp_mandatory_nein" value="0" checked>
                                                                <label class="custom-control-label" for="updt_doctyp_mandatory_nein">
                                                                    kein Pflichtteil
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline-primary btn-block">Dokumententyp aktualisieren</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                @if (count(App\DocumentType::all())>0 )
                                                    <div class="border border-danger p-3">
                                                        <h2 class="h5">Dokumententyp löschen</h2>
                                                        <form action="{{ Route('deleteDokumentType') }}"
                                                              id="frmDeleteDokumentenTypg"
                                                              name="frmDeleteDokumentenTypg"
                                                              method="post"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="input-group mb-3">
                                                                <label for="frmDeleteDokumentenTypgId" class="sr-only">Dokumententyp auswählen</label>
                                                                <select name="id" id="frmDeleteDokumentenTypgId" class="custom-select">
                                                                    @foreach (App\DocumentType::all() as $ad)
                                                                        <option value="{{ $ad->id }}">{{ $ad->doctyp_name_kurz }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-outline-danger">Dokumententyp löschen <i class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                            <p class="text-danger lead">Bitte beachten Sie, dass mit diesem Typ verknüpfte Objekte verloren gehen können! Bitte prüfen Sie vorab, welche von der Löschung betroffen sein werden!</p>
                                                        </form>
                                                        <div class="input-group mb-3 showUsedDokumentenTypResult">
                                                            <button type="button"
                                                                    class="btn btn-outline-secondary showUsedDokumentenTyp"
                                                            >
                                                                Betroffene Produkte anzeigen
                                                            </button>
                                                        </div>
                                                        <ul class="list-group mt-3" id="usedDokumentenTypListe">
                                                        </ul>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2" id="Belege" role="tabpanel" aria-labelledby="Belege-tab"></div>
                    <div class="tab-pane fade p-2" id="Anzeige" role="tabpanel" aria-labelledby="Anzeige-tab">
                        <form action="{{ route('updateUserTheme') }}" id="frmChangeUserTheme" name="frmChangeUserTheme" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 class="h4">Darstellung Farben</h2>

                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="frmChangeUserTheme-id" value="{{ Auth::user()->id }}">
                                    <div class="form-group">
                                        <label for="systemTheme">Farbschema auswählen</label>
                                        <select name="systemTheme" id="systemTheme" class="custom-select">
                                            <option value="https://bootswatch.com/4/yeti/bootstrap.min.css">Yeti</option>
                                            <option value="https://bootswatch.com/4/minty/bootstrap.min.css">Mint</option>
                                            <option value="https://bootswatch.com/4/flatly/bootstrap.min.css">Dunkel blau</option>
                                            <option value="https://bootswatch.com/4/superhero/bootstrap.min.css">Hero blau</option>
                                            {{--                                            <option value="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">TBS v5</option>--}}
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-block" id="btnChangeDisplayTheme">Vorschau</button>

                                </div>
                                <div class="col-md-4">
                                    <h2 class="h4">Darstellung Eingabemasken</h2>
                                    <div class="custom-control custom-switch ml-3">
                                        <input class="custom-control-input" type="checkbox" id="setUserDisplaySimpleView" name="setUserDisplaySimpleView">
                                        <label class="custom-control-label" for="setUserDisplaySimpleView">Vereinfachte Anzeige von Formularen</label>
                                    </div>

                                    <div class="custom-control custom-switch ml-3">
                                        <input class="custom-control-input" type="checkbox" id="setUserDisplayHelperText" name="setUserDisplayHelperText">
                                        <label class="custom-control-label" for="setUserDisplayHelperText">Hilfetexte anzeigen</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-5">Einstellungen für Benutzer speichern</button>
                        </form>
                    </div>
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
        $('.nav-link').click(function () {
            $('.navTextHelper').html($(this).data('helpertext'));
        });

        $('#btnChangeDisplayTheme').click(function () {
            const theme = $('#systemTheme :selected').val();
            console.log(theme);
            $('#themeId').attr('href',theme);

        });

        $('#loadAdressTypeItem').click(function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('getAddressTypeData') }}",
                data: {
                    adt_id : $('#loadAdressTypId :selected').val(),
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
                frm.find('#updt_rt_name_kurz').val(jsn.rt_name_kurz);
                frm.find('#updt_rt_name_lang').val(jsn.rt_name_lang);
                frm.find('#upd_rt_name_text').val(jsn.rt_name_text);
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
                frm.find('#updt_spt_name_kurz').val(jsn.spt_name_kurz);
                frm.find('#updt_spt_name_lang').val(jsn.spt_name_lang);
                frm.find('#updt_spt_name_text').val(jsn.spt_name_text);
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
                frm.find('#upd_pk_name_kurz').val(jsn.pk_name_kurz);
                frm.find('#updt_pk_name_lang').val(jsn.pk_name_lang);
                frm.find('#updt_pk_name_text').val(jsn.pk_name_text);
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
                frm.find('#updt_at_name_kurz').val(jsn.at_name_kurz);
                frm.find('#updt_at_name_lang').val(jsn.at_name_lang);
                frm.find('#updt_at_name_text').val(jsn.at_name_text);
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
                frm.find('#updt_vo_name_kurz').val(jsn.vo_name_kurz);
                frm.find('#updt_vo_stand').val(jsn.vo_stand);
                frm.find('#updt_vo_nummer').val(jsn.vo_nummer);
                frm.find('#updt_vo_name_lang').val(jsn.vo_name_lang);
                frm.find('#updt_vo_name_text').val(jsn.vo_name_text);
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
                frm.find('#updt_an_name_kurz').val(jsn.an_name_kurz);
                frm.find('#updt_anforderung_type_id').val(jsn.anforderung_type_id);
                frm.find('#updt_an_name_lang').val(jsn.an_name_lang);
                frm.find('#updt_an_name_text').val(jsn.an_name_text);
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
                frm.find('#updt_doctyp_name_kurz').val(jsn.doctyp_name_kurz);
                frm.find('#updt_doctyp_name_lang').val(jsn.doctyp_name_lang);
                frm.find('#updt_doctyp_name_text').val(jsn.doctyp_name_text);

                if (jsn.doctyp_mandatory === 1){
                    frm.find('#updt_doctyp_mandatory_ja').prop('checked',true)
                } else {
                    frm.find('#updt_doctyp_mandatory_nein').prop('checked',false)
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {
                    $('.usedAddressesListItem, .usedAddressResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedAdressResult').append(`
                    <span class="btn usedAddressResult text-warning">${z} Gebäude gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedAddressesListe').append(`
                    <li class="list-group-item usedAddressesListItem bg-warning text-white">${item.ad_name_kurz} - <span class="text-truncate">${item.ad_name_lang}</span></li>
                    `);
                        });
                    } else {
                        $('#usedAddressesListe').append(`
                    <li class="list-group-item usedAddressesListItem bg-success text-white">Es sind keine Adressen mit diesem Typ verknüpft!</li>
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
                    id:  nd.val(),
                },


                success: function (res) {
                    $('.usedStellplatzListItem, .usedStellPlatzListe').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedStellPlaetze').append(`
                    <span class="btn usedStellPlatzListe text-warning">${z} Geräte gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedStellPlatzListe').append(`
                    <li class="list-group-item usedStellplatzListItem bg-warning text-white">${item.produkt.prod_name_kurz} - <span class="text-truncate">${item.produkt.prod_name_lang}</span></li>
                    `);
                        });
                    } else {
                        $('#usedStellPlatzListe').append(`
                    <li class="list-group-item usedStellplatzListItem bg-success text-white">Es sind keine Geräte mit diesem Stelplatztyp verknüpft!</li>
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {
                    $('.usedBuildingListItem, .usedBuildingResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedBuildingsResult').append(`
                    <span class="btn usedBuildingResult text-warning">${z} Gebäude gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedBuildingTypeListe').append(`
                    <li class="list-group-item usedBuildingListItem bg-warning text-white">${item.b_name_kurz} - ${item.b_name_ort}</li>
                    `);
                        });
                    } else {
                        $('#usedBuildingTypeListe').append(`
                    <li class="list-group-item usedBuildingListItem bg-success text-white">Es sind keine Gebäude mit diesem Typ verknüpft!</li>
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedRoomsListItem, .usedRoomsResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedRoomsResult text-warning">${z} Räume gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedRoomsListe').append(`
                    <li class="list-group-item usedRoomsListItem bg-warning text-white">${item.r_name_kurz} - ${item.r_name_lang}</li>
                    `);
                        });
                    } else {
                        $('#usedRoomsListe').append(`
                    <li class="list-group-item usedRoomsListItem bg-success text-white">Es sind keine Räume mit diesem Typ verknüpft!</li>
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedProdStammListItem, .usedProdStammResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedProdStammResult text-warning">${z} Produkte gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-warning text-white">${item.mat_name_nummer} - ${item.mat_name_kurz}</li>
                    `);
                        });
                    } else {
                        $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-success text-white">Es sind keine Produkte mit diesem Typ verknüpft!</li>
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedProdStammListItem, .usedProdStammResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedRoomsResult').append(`
                    <span class="btn usedProdStammResult text-warning">${z} Produkte gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-warning text-white">${item.mat_name_nummer} - ${item.mat_name_kurz}</li>
                    `);
                        });
                    } else {
                        $('#usedProdukteListe').append(`
                    <li class="list-group-item usedProdStammListItem bg-success text-white">Es sind keine Produkte mit diesem Typ verknüpft!</li>
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
                    id:  nd.val(),
                    // _token: $('input[name="_token"]').val(),
                    // _method: $('input[name="_method"]').val()
                },
                success: function (res) {

                    $('.usedAnordnungListItem, .usedProdStammResult').remove();
                    if (res.length>0) {
                        let z= res.length;
                        $('.showUsedAnordnungenResults').append(`
                    <span class="btn usedProdStammResult text-warning">${z} Anforderungen gefunden!</span>
                    `);
                        $.each(res, function (ui, item) {
                            $('#usedAnordnungenListe').append(`
                    <li class="list-group-item usedAnordnungListItem bg-warning text-white">${item.an_name_kurz} - ${item.an_name_lang}</li>
                    `);
                        });
                    } else {
                        $('#usedAnordnungenListe').append(`
                    <li class="list-group-item usedAnordnungListItem bg-success text-white">Es sind keine Anforderungen mit diesem Typ verknüpft!</li>
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

                    $.each(res,function(ui,item){
                        $('#showProduktKategorieParamListe').append(`
                     <div class="card p-2 mb-4 showProduktKategorieParamListItem" id="pkp_${item.id}">
                        <form action="/updateProduktKategorieParams" method="post" id="updateProduktKategorieParams_${item.id}">
                            @csrf
                        @method('PUT')
                        <input type="hidden" id="produkt_kategorie_id_${item.id}" name="produkt_kategorie_id" value="${item.produkt_kategorie_id}">
                            <input type="hidden" id="id_${item.id}" name="id" value="${item.id}">
                            <div class="mb-2">
                                <label for="pkp_label_${item.id}">Label</label>
                                <input type="text" name="pkp_label" id="pkp_label_${item.id}" class="form-control checkLabel" value="${item.pkp_label}">
                                <p class="small text-primary">erforderlich, max 20 Zeichen, ohne Sonder- und Leerzeichen</p>
                            </div>
                            <div class="mb-2">
                                <label for="pkp_name_${item.id}">Name</label>
                                <input type="text" name="pkp_name" id="pkp_name_${item.id}" class="form-control" value="${item.pkp_name}">
                                 <p class="small text-primary">maximal 150 Zeichen</p>
                            </div>
                            <div class="input-group mt-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-link mr-2 btnUpdatePKParam" data-id="${item.id}"><span class="fas fa-download"></span> speichern</button>
                                <button type="button" class="btn btn-sm btn-link btnDeletePKParam" data-id="${item.id}">Löschen <span class="far fa-trash-alt"></span></button>
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

        $(document).on('click','.btnUpdatePKParam',function () {
            const pkp_id = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/updateProduktKategorieParams",
                data: $('#updateProduktKategorieParams_'+pkp_id).serialize(),
                success: (res) => {
                    if (res) $('#toastMessageBody').html(`Das Datenfeld <strong>${$('#pkp_name_'+pkp_id).val()}</strong> wurde aktualisiert!`);
                    jQuery('.toast').toast('show');
                },
                error: (er) =>{
                    console.log(er.responseJSON.errors.pkp_label);
                    $('#toastMessageBody').text(er.responseJSON.errors.pkp_label);
                    jQuery('.toast').toast('show');
                }
            })
        });

        $(document).on('click','.btnDeletePKParam',function () {
            const pkp_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/getUsedProduktsByPK",
                data: { id:pkp_id },
                success: function (res) {
                    if (res>0) {
                        $('#frmDeleteProduktKategorieParam #id').val(pkp_id);
                        $('#warningDeleteProduktKategorieParamBody').html(`
                    <p class="lead">Es sind insgesamt <span class="badge badge-warning">${res}</span> Produkte in dieser Kategorie vorhanden.</p>
                     <p class="lead text-danger">Alle Einträge zu diesem Datenfeld gehen unwiderruflich verloren!</p>
                    `);
                        $('#warningDeleteProduktKategorieParam').modal('show');
                    } else {
                        $('#frmDeleteProduktKategorieParam_'+pkp_id).submit();
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
                data: {id:aciid},
                success: function(res)  {
                    $('#aci_id').val(res.id);
                    $('#updt_anforderung_id').val(res.anforderung_id);
                    $('#updt_aci_name_kurz').val(res.aci_name_kurz);
                    $('#updt_aci_name_lang').val(res.aci_name_lang);
                    $('#updt_aci_task').val(res.aci_task);
                    $('#updt_aci_value_si').val(res.aci_value_si);
                    $('#updt_aci_vaule_soll').val(res.aci_vaule_soll);
                    if (res.firma_id === '1'){
                        $('#updt_firma_id').val(res.firma_id);
                        $('#updt_aci_internal').prop('checked',true);
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
