@extends('layout.layout-admin')

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('pagetitle')
    {{__('Standortverwaltung')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
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
            >{{  $location->l_label  }}</li>
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
                                <x-textfield id="ad_label"
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
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="setAdressAsNewMain"
                                   name="setAdressAsNewMain"
                                   checked
                                   value="{{ $location->id }}"
                            >
                            <label class="custom-control-label"
                                   for="setAdressAsNewMain"
                            >{{ __('Diese Adresse als neue Standortadresse anlegen') }}</label>
                        </div>
                        <p class="text-info small mt-4">
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
                                <x-textfield id="ma_vorname"
                                             label="{{ __('Vorname') }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="ma_name"
                                             label="{{ __('Nachname') }}"
                                             required
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="ma_telefon"
                                             label="{{ __('Telefon') }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="ma_mobil"
                                             label="{{ __('Mobil') }}"
                                             required
                                />
                            </div>
                        </div>
                        <x-selectfield id="user_id"
                                       label="{{ __('testWare Benutzerkonto zuordnen') }}"
                                       required
                        >
                            @foreach(App\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-selectfield>
                        <div class="custom-control custom-checkbox my-4">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="setProfileAsNewMain"
                                   name="setProfileAsNewMain"
                                   checked
                                   value="{{ $location->id }}"
                            >
                            <label class="custom-control-label"
                                   for="setProfileAsNewMain"
                            >{{ __('Mitarbeiter als Leitung des Standortes festlegen') }}</label>
                        </div>
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
                    {{ $location->l_label }}
                </h1>
                {{--                <div class="visible-print text-center">
                                    {!! QrCode::size(65)->generate($location->storage_id); !!}
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
                           id="locGebauede-tab"
                           data-toggle="tab"
                           href="#locGebauede"
                           role="tab"
                           aria-controls="locGebauede"
                           aria-selected="false"
                        >{{__('Gebäude')}} <span class="badge badge-info">{{ $location->Building->count() }}</span></a>
                    </li>
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
                                        <label for="l_label">{{__('Kurzbezeichnung (max 10 Zeichen)')}}</label>
                                        <input type="text"
                                               name="l_label"
                                               id="l_label"
                                               class="form-control {{ $errors->has('l_label') ? ' is-invalid ': '' }}"
                                               maxlength="10"
                                               value="{{ $location->l_label }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="l_name">{{__('Bezeichnung (max 100 Zeichen)')}}</label>
                                        <input type="text"
                                               name="l_name"
                                               id="l_name"
                                               class="form-control"
                                               maxlength="100"
                                               value="{{ $location->l_name ?? '' }}"
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
                                            <h5 class="card-title">{{__('Kürzel')}}: {{ $location->Adresse->ad_label }}</h5>
                                            <a href="{{ route('adresse.show',$location->Adresse) }}">{{__('Details')}}</a>
                                        </div>

                                        <dl class="row">
                                            <dt class="col-sm-3">{{__('Postal')}}:</dt>
                                            <dd class="col-sm-9">{{ $location->Adresse->ad_name }}</dd>
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
                                           name="an_label"
                                           id="name_anforderung"
                                    >
                                    <x-selectfield id="anforderung_id"
                                                   label="Anforderung wählen"
                                    >
                                        <option value="">bitte wählen</option>
                                        @foreach (App\Anforderung::all() as $anforderung)
                                            <option value="{{ $anforderung->id }}">{{ $anforderung->an_label }}</option>
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
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_label }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Anforderung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_label }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Bezeichnung</dt>
                                                <dd class="col-sm-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-sm-4">Intervall</dt>
                                                <dd class="col-sm-8">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_label }}
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
                                                            <li class="list-group-item">{{ $aci->aci_name }}</li>
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
                                                           name="an_label"
                                                           id="an_label_delAnf_{{ $produktAnforderung->anforderung_id }}"
                                                           value="{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_label }}"
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
                                           name="storage_id"
                                           id="storage_id"
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
                                               for="b_label"
                                        ></label>
                                        <input type="text"
                                               class="form-control"
                                               id="b_label"
                                               name="b_label"
                                               required
                                               placeholder="Gebäudename kurz"
                                               value="{{ old('b_label')??'' }}"
                                        >
                                        @if ($errors->has('b_label'))
                                            <span class="text-danger small">{{ $errors->first('b_label') }}</span>
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
                                                    {{$building->b_label}}
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
                                                        objectVal="{{$building->b_label}}"
                                                        objectName="b_label"
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
                    $('#name_anforderung').val(res.an_label);
                    $('#produktAnforderungText').html(`
                         <dl class="row">
                            <dt class="col-sm-4">Verordnung</dt>
                            <dd class="col-sm-8">${res.verordnung.vo_label}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Anfoderung</dt>
                            <dd class="col-sm-8">${res.an_label}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Bezeichnung</dt>
                            <dd class="col-sm-8">${res.an_name}</dd>
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

    </script>
@endsection

