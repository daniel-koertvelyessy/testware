@extends('layout.layout-admin')

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('pagetitle')
    {{__('Standortverwaltung')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('location.index') }}">{{__('Standorte')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{  $location->l_name_kurz  }}</li>
        </ol>
    </nav>
@endsection

@section('modals')
    <div class="modal"
         id="modalAddBuildingType"
         tabindex="-1"
         aria-labelledby="modalAddBuildingTypeLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createBuildingType') }}#locGebauede"
                      method="POST"
                      class="needs-validation"
                      id="frmCreateBuildingType"
                      name="frmCreateBuildingType"
                >
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddBuildingTypeLabel"
                        >{{__('Neuen Gebäudetyp erstellen')}}</h5>
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
                               name="frmOrigin"
                               id="frmOrigin"
                               value="location"
                        >
                        @csrf
                        <div class="form-group">
                            <label for="btname">Name</label>
                            <input type="text"
                                   name="btname"
                                   id="btname"
                                   class="form-control {{ $errors->has('btname') ? ' is-invalid ': '' }}"
                                   value="{{ old('btname') ?? '' }}"
                                   required
                            >
                            @if ($errors->has('btname'))
                                <span class="text-danger small">{{ $errors->first('btname') }}</span>
                            @else
                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="btbeschreibung">Beschreibung des Gebäudetyps</label>
                            <textarea id="btbeschreibung"
                                      name="btbeschreibung"
                                      class="form-control"
                            >{{ old('btbeschreibung') ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >Abbruch
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >Gebäudetyp speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                               name="standort_id"
                               id="standort_id_building"
                               value="{{ Str::uuid() }}"
                        >

                        <x-textfield id="b_name_kurz"
                                     label="{{ __('Kurzbezeichnung') }}"
                                     required
                                     max="20"
                        />

                        <x-textfield id="b_name_ort"
                                     label="{{ __('Ort') }}"
                        />

                        <x-textfield id="b_name_lang"
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
                                        <option value="new">neu anlegen</option>
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
                        >Abbruch
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >speichern
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
                        >
                        <input type="hidden"
                               name="building_id"
                               id="building_id_room_modal"
                        >
                        @csrf
                        <input type="hidden"
                               name="standort_id"
                               id="standort_id_room"
                               value="{{ Str::uuid() }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="r_name_kurz"
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
                                            <option value="{{ $bty->id }}">{{ $bty->rt_name_kurz }}</option>
                                        @endforeach
                                        <option value="new">neu anlegen</option>
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

                        <x-textfield id="r_name_lang"
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
                        >Abbruch
                        </button>
                        <button type="submit"
                                class="btn btn-primary"
                        >speichern
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
                               name="standort_id"
                               id="standort_id_stellplatz"
                               value="{{ Str::uuid() }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="sp_name_kurz"
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
                                            <option value="{{ $bty->id }}">{{ $bty->spt_name_kurz }}</option>
                                        @endforeach
                                        <option value="new">neu anlegen</option>
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

                        <x-textfield id="sp_name_lang"
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

    <div class="modal fade"
         id="modalAddAdresse"
         tabindex="-1"
         aria-labelledby="modalAddAdresseLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('adresse.store') }}"
                      method="post"
                >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddAdresseLabel"
                        >{{__('Neue Adresse anlegen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="ad_name_kurz"
                                             label="{{__('Kürzel')}}"
                                             required
                                             max="20"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="address_type_id">{{__('Adress Typ')}}</label>
                                <div class="input-group">
                                    <select id="address_type_id"
                                            name="address_type_id"
                                            class="custom-select"
                                    >
                                        @foreach(App\AddressType::all() as $adt)
                                            <option value="{{ $adt->id }}">{{ $adt->adt_name }}</option>
                                        @endforeach
                                        <option value="new">{{__('neuen Typ anlegen')}}</option>
                                    </select>
                                    <label for="newAdressType"
                                           class="sr-only"
                                    >{{__('Typ angeben')}}</label>
                                    <input type="text"
                                           name="newAdressType"
                                           id="newAdressType"
                                           class="form-control d-none"
                                    >
                                </div>
                            </div>
                        </div>
                        <x-textfield id="ad_name_firma"
                                     label="{{__('Firma')}}"
                                     value="{{ old('ad_name_firma')??''}}"
                        />
                        <div class="row">
                            <div class="col-md-8">
                                <x-rtextfield max="100"
                                              id="ad_anschrift_strasse"
                                              label="{{__('Straße')}}"
                                              value="{{ old('ad_anschrift_strasse')??''}}"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-textfield id="ad_anschrift_hausnummer"
                                             label="{{__('Nr')}}"
                                             value="{{ old('ad_anschrift_hausnummer')??''}}"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <x-rtextfield max="100"
                                              id="ad_anschrift_ort"
                                              label="{{__('Ort')}}"
                                              value="{{ old('ad_anschrift_ort')??''}}"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-rtextfield max="100"
                                              id="ad_anschrift_plz"
                                              label="{{__('PLZ')}}"
                                              value="{{ old('ad_anschrift_plz')??''}}"
                                />
                            </div>
                        </div>
                        <x-selectfield id="land_id"
                                       label="{{__('Land')}}"
                        >
                            @foreach (App\Land::all() as $land)
                                <option value="{{ $land->id }}"
                                    {{ (old('land_id'))?' selected ' : ''}} >
                                    {{ $land->land_lang }}
                                </option>
                            @endforeach
                        </x-selectfield>
                        <p class="text-info small">
                            {{ __('Sie können in der Adress-Verwaltung weitere Inhalte ergänzen!') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Adresse anlegen')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="modalAddProfile"
         tabindex="-1"
         aria-labelledby="modalAddProfileLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('profile.store') }}"
                      method="post"
                >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddProfileLabel"
                        >{{__('Neuen Mitarbeiter anlegen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="ma_vorname" label="{{ __('Vorname') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="ma_name" label="{{ __('Nachname') }}" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="ma_telefon" label="{{ __('Telefon') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="ma_mobil" label="{{ __('Mobil') }}" required />
                            </div>
                        </div>
                        <x-selectfield id="user_id" label="{{ __('testWare Benutzerkonto zuordnen') }}" required >
                            @foreach(App\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                        </x-selectfield>
                        <p class="text-info small">
                            {{ __('Sie können in der Mitarbeiter-Verwaltung weitere Inhalte ergänzen!') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Mitarbeiter anlegen')}}</button>
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
                <h1 class="h3">
                    <span class="d-none d-md-inline">{{__('Übersicht Standort')}} </span>
                    {{ $location->l_name_kurz }}
                </h1>
                {{--                <div class="visible-print text-center">
                                    {!! QrCode::size(65)->generate($location->standort_id); !!}
                                    <p class="text-muted small">Standort-ID</p>
                                </div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab"
                    id="myTab"
                    role="tablist"
                >
                    <li class="nav-item "
                        role="presentation"
                    >
                        <a class="nav-link active"
                           id="Stammdaten-tab"
                           data-toggle="tab"
                           href="#Stammdaten"
                           role="tab"
                           aria-controls="Stammdaten"
                           aria-selected="true"
                        >{{__('Stammdaten')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="Anforderungen-tab"
                           data-toggle="tab"
                           href="#Anforderungen"
                           role="tab"
                           aria-controls="Anforderungen"
                           aria-selected="false"
                        >{{__('Anforderungen')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="locExplorer-tab"
                           data-toggle="tab"
                           href="#Explorer"
                           role="tab"
                           aria-controls="locExplorer"
                           aria-selected="false"
                        >{{__('Explorer')}}
                        </a>
                    </li>
                    {{--   <li class="nav-item"
                           role="presentation"
                       >
                           <a class="nav-link"
                              id="locGebauede-tab"
                              data-toggle="tab"
                              href="#locGebauede"
                              role="tab"
                              aria-controls="locGebauede"
                              aria-selected="false"
                           >{{__('Gebäude')}} <span class="badge badge-info">{{ $location->Building->count() }}</span></a>
                       </li>--}}
                </ul>
                <div class="tab-content pt-3"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active p-2 "
                         id="Stammdaten"
                         role="tabpanel"
                         aria-labelledby="Stammdaten-tab"
                    >
                        <form action="{{ route('location.update',['location'=>$location->id]) }}"
                              method="post"
                        >
                            <div class="row">
                                <div class="col-lg-4">
                                    {{--                                    <h2 class="h5">Bezeichner</h2>--}}

                                    @method('PUT')
                                    @csrf

                                    <input type="hidden"
                                           name="id"
                                           id="id"
                                           value="{{ $location->id }}"
                                    >
                                    <div class="form-group">
                                        <label for="l_name_kurz">{{__('Kurzbezeichnung (max 10 Zeichen)')}}</label>
                                        <input type="text"
                                               name="l_name_kurz"
                                               id="l_name_kurz"
                                               class="form-control {{ $errors->has('l_name_kurz') ? ' is-invalid ': '' }}"
                                               maxlength="10"
                                               value="{{ $location->l_name_kurz }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="l_name_lang">{{__('Bezeichnung (max 100 Zeichen)')}}</label>
                                        <input type="text"
                                               name="l_name_lang"
                                               id="l_name_lang"
                                               class="form-control"
                                               maxlength="100"
                                               value="{{ $location->l_name_lang ?? '' }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="l_beschreibung">{{__('Beschreibung')}}</label>
                                        <textarea name="l_beschreibung"
                                                  id="l_beschreibung"
                                                  class="form-control"
                                                  rows="3"
                                        >{{ $location->l_beschreibung ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">{{__('Anschrift')}}</h2>
                                    <div class="input-group mb-2">
                                        <label for="adresse_id"
                                               class="sr-only"
                                        >{{__('Die Adresse des Standortes festlegen')}}
                                        </label>
                                        <select class="custom-select"
                                                aria-label="{{__('Adresse des Standortes festlegen')}}"
                                                name="adresse_id"
                                                id="adresse_id"
                                        >
                                            @foreach (App\Adresse::all() as $addItem)
                                                <option value="{{$addItem->id}}"
                                                        @if ($addItem->id == $location->adresse_id)
                                                        selected
                                                    @endif>
                                                    {{ $addItem->ad_anschrift_ort }}, {{ $addItem->ad_anschrift_strasse }} - {{ $addItem->ad_anschrift_hausnummer }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button"
                                                class="btn btn-outline-primary ml-2"
                                                data-toggle="modal"
                                                data-target="#modalAddAdresse"
                                        >neu
                                        </button>
                                    </div>
                                    <div class="border-top pt-2">
                                        <div class="d-flex justify-content-md-between">
                                            <h5 class="card-title">{{__('Kürzel')}}: {{ $location->Adresse->ad_name_kurz }}</h5>
                                            <a href="{{ route('adresse.show',$location->Adresse) }}">{{__('Details')}}</a>
                                        </div>

                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Postal')}}:</dt>
                                            <dd class="col-sm-9">{{ $location->Adresse->ad_name_lang }}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Straße')}}, {{__('Nr')}}</dt>
                                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_strasse }}, {{ $location->Adresse->ad_anschrift_hausnummer }}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Plz')}}</dt>
                                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_plz }}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Ort')}}</dt>
                                            <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_ort }}</dd>
                                        </dl>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">{{__('Leitung')}}</h2>

                                    <label for="profile_id"
                                           class="sr-only"
                                    >{{__('Leitung des Standortes hat')}}
                                    </label>
                                    <div class="input-group mb-2">
                                        <select class="custom-select"
                                                aria-label="Default select example"
                                                name="profile_id"
                                                id="profile_id"
                                        >
                                            @forelse (App\Profile::all() as $profileItem)
                                                <option value="{{$profileItem->id}}"
                                                        @if ($profileItem->id == $location->profile_id)
                                                        selected
                                                    @endif>{{ $profileItem->ma_vorname }} {{ $profileItem->ma_name }}
                                                </option>
                                            @empty
                                                <option value="void">Kein Mitabreiter angelegt</option>
                                            @endforelse
                                        </select>
                                        <button type="button"
                                                class="btn btn-outline-primary ml-2"
                                                data-toggle="modal"
                                                data-target="#modalAddProfile"
                                        >
                                            {{__('neu')}}
                                        </button>
                                    </div>
                                    <div class="border-top pt-2">
                                        <div class="d-flex justify-content-md-between">
                                            <h5 class="card-title">{{__('Kontaktdaten')}}</h5>
                                            <a href="{{ route('profile.show',$location->Profile) }}">{{__('Details')}}</a>
                                        </div>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Name')}}</dt>
                                            <dd class="col-sm-9">{{ $location->Profile->ma_vorname }} {{ $location->Profile->ma_name }} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3"><span class="text-truncate">{{__('Telefon')}}</span></dt>
                                            <dd class="col-sm-9">{{ $location->Profile->ma_telefon }}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Mobil')}}</dt>
                                            <dd class="col-sm-9">
                                                <a href="tel:{{ $location->Profile->ma_mobil }}">{{ $location->Profile->ma_mobil }}</a>
                                            </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('E-Mail')}}</dt>
                                            <dd class="col-sm-9">@if ($location->Profile->User)
                                                    <a href="mailto:{{ $location->Profile->User->email }}">{{ $location->Profile->User->email }}</a> @else - @endif</dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary"> {{__('Stammdaten speichern')}} <i class="fas fa-download ml-3"></i></button>
                        </form>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="Anforderungen"
                         role="tabpanel"
                         aria-labelledby="Anforderungen-tab"
                    >
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <h2 class="h5">Anforderung auswählen</h2>
                                <form action="{{ route('addLocationAnforderung') }}#Anforderungen"
                                      method="post"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="location_id"
                                           id="id_location_anforderung"
                                           value="{{ $location->id }}"
                                    >
                                    <input type="hidden"
                                           name="an_name_kurz"
                                           id="name_anforderung"
                                    >
                                    <x-selectfield id="anforderung_id"
                                                   label="Anforderung wählen"
                                    >
                                        <option value="">bitte wählen</option>
                                        @foreach (App\Anforderung::all() as $anforderung)
                                            <option value="{{ $anforderung->id }}">{{ $anforderung->an_name_kurz }}</option>
                                        @endforeach
                                    </x-selectfield>
                                    <button class="btn btn-primary btn-block mt-1">Anforderung zuordnen</button>
                                    <div class="card p-2 my-2"
                                         id="produktAnforderungText"
                                    >
                                        <x-notifyer>Details zu Anforderung</x-notifyer>
                                    </div>
                                </form>
                                @error('anforderung_id')
                                <div class="alert alert-dismissible fade show alert-info mt-5"
                                     role="alert"
                                >
                                    Bitte eine Anforderung auswählen!
                                    <button type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <h2 class="h5">Anforderungen</h2>
                                @php
                                    $Anforderung = App\Anforderung::all();
                                @endphp

                                @forelse (App\LocationAnforderung::where('location_id',$location->id)->get() as $produktAnforderung)
                                    @if ($produktAnforderung->anforderung_id!=0)
                                        <div class="card p-2 mb-2">
                                            <dl class="row lead">
                                                <dt class="col-sm-4">Verordnung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Anforderung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Bezeichnung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_lang }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Intervall</dt>
                                                <dd class="col-sm-8">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_name }}
                                                </dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Beschreibung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">
                                                    {{ ($produktAnforderung->Anforderung->AnforderungControlItem->count()>1) ? 'Vorgänge' : 'Vorgang' }}
                                                </dt>
                                                <dd class="col-sm-8">
                                                    <ul class="list-group">

                                                        @foreach ($produktAnforderung->Anforderung->AnforderungControlItem as $aci)
                                                            <li class="list-group-item">{{ $aci->aci_name_lang }}</li>
                                                        @endforeach
                                                    </ul>
                                                </dd>
                                            </dl>
                                            <nav class="border-top mt-2 pt-2 d-flex justify-content-end">
                                                <form action="{{ route('deleteProduktAnfordrung') }}#prodAnfordrungen"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden"
                                                           name="an_name_kurz"
                                                           id="an_name_kurz_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}"
                                                    >
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $produktAnforderung->id }}"
                                                    >
                                                    <input type="hidden"
                                                           name="location_id"
                                                           id="location_id_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $location->id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">löschen</button>
                                                </form>
                                            </nav>
                                        </div>
                                    @endif
                                @empty
                                    <x-notifyer>Bislang sind keine Anforderungen verknüpft!</x-notifyer>
                                @endforelse


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="Explorer"
                         role="tabpanel"
                         aria-labelledby="Explorer-tab"
                    >
                        <div class="row">
                            <div class="col-md-4 mt-3 mt-md-0">
                                <input type="hidden"
                                       name="building_id"
                                       id="building_id"
                                       value="{{ App\Building::where('location_id',$location->id)->first()->id }}"
                                >
                                <h2 class="h4">Gebäude</h2>
                                <div class="btn-toolbar"
                                     role="toolbar"
                                     aria-label="Toolbar für Gebäude"
                                >
                                    <div class="btn-group mb-2 btn-block"
                                         role="group"
                                    >
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnBuilding"
                                                data-type="new"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                                        </button>
                                        <button type="button"
                                                data-type="edit"
                                                class="btn btn-sm btn-outline-primary btnBuilding"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span class="fas fa-edit"></span>
                                        </button>
                                        <button type="button"
                                                data-type="copy"
                                                class="btn btn-sm btn-outline-primary btnBuilding"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Kopieren')}}</span> <span class="fas fa-copy"></span></button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnBuildingDelete"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span class="far fa-trash-alt"></span></button>

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
                                    >
                                        <option value="void">{{__('Gebäude auswählen')}}</option>
                                        @foreach(App\Building::with('BuildingType')->where('location_id',$location->id)->get() as $building)
                                            <option value="{{ $building->id }}">
                                                {{ $building->BuildingType->btname }} =>
                                                {{ $building->b_name_kurz }} /
                                                {{ $building->b_name_lang }}
                                            </option>
                                        @endforeach
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
                                     aria-label="{{__('Übersicht der Räume des ausgewählten Raums')}}"
                                >
                                    <div class="btn-group mb-2 btn-block"
                                         role="group"
                                         aria-label="{{__('Raumliste')}}"
                                    >
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnRoom disabled"
                                                disabled
                                                data-type="new"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnRoom disabled"
                                                disabled
                                                data-type="edit"
                                        >
                                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span class="fas fa-edit"></span>
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
                                                class="btn btn-sm btn-outline-primary btnStellplatz disabled"
                                                data-type="new"
                                                disabled
                                        >
                                            <span class="d-none d-lg-inline">{{__('Neu')}}</span> <span class="fas fa-plus"></span>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnStellplatz disabled"
                                                data-type="edit"
                                                disabled
                                        >
                                            <span class="d-none d-lg-inline">{{__('Bearbeiten')}}</span> <span class="fas fa-edit"></span>
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
                                            <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span class="far fa-trash-alt"></span>
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
                                    >
                                        <option value="void">Bitte erst Gebäude wählen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                    <div class="tab-pane fade"
                                             id="locGebauede"
                                             role="tabpanel"
                                             aria-labelledby="locGebauede-tab"
                                        >
                                            <div class="row">
                                                <div class="col">
                                                    <form class="row gy-2 gx-3  my-3"
                                                          action="{{ route('building.store') }}#locGebauede"
                                                          method="post"
                                                          name="frmAddNewBuilding"
                                                          id="frmAddNewBuilding"
                                                    >
                                                        @csrf
                                                        <input type="hidden"
                                                               name="standort_id"
                                                               id="standort_id"
                                                               value="{{ Str::uuid() }}"
                                                        >
                                                        <input type="hidden"
                                                               name="location_id"
                                                               id="location_id"
                                                               value="{{ $location->id }}"
                                                        >
                                                        <input type="hidden"
                                                               name="frmOrigin"
                                                               id="frmOriginAddNewBuilding"
                                                               value="location"
                                                        >
                                                        <div class="col-auto">
                                                            <label class="sr-only"
                                                                   for="b_name_kurz"
                                                            ></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="b_name_kurz"
                                                                   name="b_name_kurz"
                                                                   required
                                                                   placeholder="Gebäudename kurz"
                                                                   value="{{ old('b_name_kurz')??'' }}"
                                                            >
                                                            @if ($errors->has('b_name_kurz'))
                                                                <span class="text-danger small">{{ $errors->first('b_name_kurz') }}</span>
                                                            @else
                                                                <span class="small text-primary">erforderlich, maximal 20 Zeichen</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-auto">
                                                            <label class="sr-only"
                                                                   for="b_name_ort"
                                                            >Gebäudeort
                                                            </label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="b_name_ort"
                                                                   name="b_name_ort"
                                                                   placeholder="Gebäudeort"
                                                                   value="{{ old('b_name_ort')??'' }}"
                                                            >
                                                            @if ($errors->has('b_name_ort'))
                                                                <span class="text-danger small">{{ $errors->first('b_name_ort') }}</span>
                                                            @else
                                                                <span class="small text-primary">maximal 100 Zeichen</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="input-group">
                                                                <label for="building_type_id"
                                                                       class="sr-only"
                                                                >Gebäudetyp angeben
                                                                </label>
                                                                <select name="building_type_id"
                                                                        id="building_type_id"
                                                                        class="custom-select"
                                                                >
                                                                    @foreach (\App\BuildingTypes::all() as $roomType)
                                                                        <option value="{{ $roomType->id }}"
                                                                                title="{{ $roomType->btbeschreibung  }}"
                                                                        >{{ $roomType->btname  }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        data-toggle="modal"
                                                                        data-target="#modalAddBuildingType"
                                                                ><i class="fas fa-plus"></i></button>
                                                            </div>
                                                            <span class="small text-primary">Gebäudetyp</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="submit"
                                                                    class="btn btn-primary"
                                                            >Neues Gebäude anlegen
                                                            </button>
                                                        </div>
                                                    </form>
                                                    @if ($location->Building->count()>0)
                                                        <table class="table table-striped"
                                                               id="tabBuildingListe"
                                                        >
                                                            <thead>
                                                            <tr>
                                                                <th>Nummer / ID</th>
                                                                <th>Ort</th>
                                                                <th class="d-none d-md-table-cell">Typ</th>
                                                                <th class="d-none d-md-table-cell text-center">Räume</th>
                                                                <th class="d-none d-md-table-cell">WE</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ( $location->Building as $building)
                                                                <tr>
                                                                    <td>
                                                                        {{$building->b_name_kurz}}
                                                                    </td>
                                                                    <td>
                                                                    {{$building->b_name_ort}}
                                                                    </td>
                                                                    <td class="d-none d-md-table-cell">
                                                                        {{ $building->BuildingType->btname }}
                                                                    </td>
                                                                    <td class="d-none d-md-table-cell text-center">
                                                                        {{ $building->rooms()->count() }}
                                                                    </td>
                                                                    <td class="d-none d-md-table-cell text-center">
                                                                        @if ($building->b_we_has === 1)
                                                                            {{$building->b_we_name}}
                                                                        @else
                                                                            <span class="fas fa-times"></span>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <x-menu_context
                                                                            :object="$building"
                                                                            routeOpen="{{ route('building.show',$building) }}"
                                                                            routeCopy="{{ route('copyBuilding',$building) }}"
                                                                            routeDestory="{{ route('building.destroy',$building) }}"
                                                                            tabName="locGebauede"
                                                                            objectVal="{{$building->b_name_kurz}}"
                                                                            objectName="b_name_kurz"
                                                                        />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="tab-pane fade" id="locEqipment" role="tabpanel" aria-labelledby="locEqipment-tab">
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


@section('actionMenuItems')

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navTargetAppAktionItems"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-bars"></i> Aktionen
        </a>
        <ul class="dropdown-menu"
            aria-labelledby="navTargetAppAktionItems"
        >
            <a class="dropdown-item"
               href="#"
            ><i class="fas fa-print"></i> Drucke Übersicht
            </a>
            <a class="dropdown-item"
               href="#"
            ><i class="far fa-file-pdf"></i> Standortbericht
            </a>

        </ul>
    </li>

@endsection()

@section('scripts')
    @if ($errors->has('btname'))
        <script>
            $('#modalAddBuildingType').modal('show');
        </script>
    @endif
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"
    >

    <script type="text/javascript"
            charset="utf8"
            src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"
    ></script>

    <script src="{{ asset('js/bootstrap-treeview.js') }}"></script>
    <script>


        $('#tabBuildingListe').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
            },
            "columnDefs": [
                {"orderable": false, "targets": 5}
            ],
            "dom": 't'
        });

        $('#anforderung_id').change(() => {

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getAnforderungData') }}",
                data: {id: $('#anforderung_id :selected').val()},
                success: (res) => {
                    const text = (res.an_name_text === null) ? '-' : res.an_name_text;
                    $('#name_anforderung').val(res.an_name_kurz);
                    $('#produktAnforderungText').html(`
                         <dl class="row">
                            <dt class="col-sm-4">Verordnung</dt>
                            <dd class="col-sm-8">${res.verordnung.vo_name_kurz}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Anfoderung</dt>
                            <dd class="col-sm-8">${res.an_name_kurz}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Bezeichnung</dt>
                            <dd class="col-sm-8">${res.an_name_lang}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Intervall</dt>
                            <dd class="col-sm-8">${res.an_control_interval}  ${res.control_interval.ci_name}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Beschreibung</dt>
                            <dd class="col-sm-8">${text}</dd>
                        </dl>
            `);
                }
            });
        });
        /*
              $('.btnDeleteBuildig').click(function () {
                       const buildingId = $(this).data('id');
                       $.ajax({
                           type: "POST",
                           dataType: 'json',
                           url: "{{ route('destroyBuildingAjax') }}",
                data: $('#frmDeleteBuildig_' + buildingId).serialize(),
                success: function (res) {
                    if (res) location.reload();

                }
            });
        });

        $('.copyBuilding').click(function () {
            const id = $(this).data('objid');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('copyBuilding') }}",
                data: {id},
                success: (res) => {
                    if (res > 0) location.reload();

                }
            });
        });

            modalType_room
            id_modal_room
            building_id_room_modal
*/

        $('#buildingList').change(function () {
            const id = $('#buildingList :selected').val();
            $('#building_id').val(id);
            $('#id_delete_Building').val(id);
            $('#building_id_room_modal').val(id);
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getRoomList') }}",
                data: {id},
                success: (res) => {
                    $('#roomList').html(res.html);
                }
            });
        });

        $('#roomList').change(function () {
            const id = $('#roomList :selected').val();
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
                url: "{{ route('getStellplatzList') }}",
                data: {id},
                success: (res) => {
                    $('#stellplatzList').html(res.html);
                }
            });
        });

        $('#stellplatzList').change(function () {
            const id = $('#stellplatzList :selected').val();
            $('#stellplatz_id').val(id);
            $('#id_modal_stellplatz').val(id);
            $('#id_delete_Stellplatz').val(id);
            if (id === 'void') {
                $('.btnStellplatz').attr('disabled', true).addClass('disabled');
                $('.btnStellplatzDelete').attr('disabled', true).addClass('disabled');
            } else {
                $('.btnStellplatz').attr('disabled', false).removeClass('disabled');
                $('.btnStellplatzDelete').attr('disabled', false).removeClass('disabled');
            }
        });

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

            if (type === 'new' && id !== 'void') {
                $('#modalSetBuildingLabel').text('Neues Gebäude anlegen');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#standort_id_building').val(res);
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
                        form.find('#standort_id_building').val(res.standort_id);
                        form.find('#b_name_lang').val(res.b_name_lang);
                        form.find('#b_name_text').val(res.b_name_text);
                        if (res.b_we_has === 1)
                            form.find('#b_we_has').prop('checked', true);
                        form.find('#b_we_name').val(res.b_we_name);
                        form.find('#location_id').val(res.location_id);
                        form.find('#building_type_id').val(res.building_type_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetBuildingLabel').text('Gebäude bearbeiten');
                            form.find('#modalType').val('edit');
                            form.find('#b_name_kurz').val(res.b_name_kurz);
                            modalBuilding.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetBuildingLabel').text('Gebäude kopieren');
                                    form.find('#b_name_kurz').attr('placeholder', 'neue Kurzbezeichnung angeben')
                                    form.find('#standort_id_building').val(res);
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

            if (type === 'new' && id !== 'void') {
                $('#modalSetRoomLabel').text('Neues Raum anlegen');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#standort_id_room').val(res);
                        form.find('#modalType_room').val('new');
                        form.find('#building_id_room_modal').val(res.building_id);
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
                        form.find('#r_name_kurz').val(res.r_name_kurz);
                        form.find('#standort_id_room').val(res.standort_id);
                        form.find('#r_name_lang').val(res.r_name_lang);
                        form.find('#r_name_text').val(res.r_name_text);
                        form.find('#building_id_room_modal').val(res.building_id);
                        form.find('#room_type_id').val(res.room_type_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetRoomLabel').text('Raum bearbeiten');
                            form.find('#modalType_room').val('edit');
                            form.find('#r_name_kurz').val(res.r_name_kurz);
                            modalRoom.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetRoomLabel').text('Raum kopieren');
                                    form.find('#r_name_kurz').attr('placeholder', 'neue Kurzbezeichnung angeben').val('');
                                    form.find('#standort_id_room').val(res);
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

            if (type === 'new' && id !== 'void') {
                $('#modalSetStellplatzLabel').text('Neuen Stellplatz anlegen');
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('fetchUid') }}",
                    success: function (res) {
                        form.find('#standort_id_stellplatz').val(res);
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
                        form.find('#sp_name_kurz').val(res.sp_name_kurz);
                        form.find('#standort_id_stellplatz').val(res.standort_id);
                        form.find('#sp_name_lang').val(res.sp_name_lang);
                        form.find('#sp_name_text').val(res.sp_name_text);
                        form.find('#room_id_stellplatz_modal').val(res.room_id);
                        form.find('#stellplatz_typ_id').val(res.stellplatz_typ_id);
                        if (type === 'edit') {
                            form.find('#id_modal').val(id);
                            $('#modalSetStellplatzLabel').text('Stellplatz bearbeiten');
                            form.find('#modalType_stellplatz').val('edit');
                            form.find('#sp_name_kurz').val(res.sp_name_kurz);
                            modalStellplatz.modal('show');
                        } else {
                            $.ajax({
                                type: "get",
                                dataType: 'json',
                                url: "{{ route('fetchUid') }}",
                                success: function (res) {
                                    $('#modalSetStellplatzLabel').text('Stellplatz kopieren');
                                    form.find('#sp_name_kurz').attr('placeholder', 'neue Kurzbezeichnung angeben').val('');
                                    form.find('#standort_id_stellplatz').val(res);
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

