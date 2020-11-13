@extends('layout.layout-admin')

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('pagetitle')
    {{__('Standortverwaltung')}} | Start @ bitpack GmbH
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
                                class="btn btn-secondary"
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
@endsection


@section('content')
    <style>
        .tree, .tree ul {
            margin: 0;
            padding: 0;
            list-style: none;
            margin-left: 10px;
        }

        .tree ul {
            margin-left: 1em;
            position: relative
        }

        .tree ul ul {
            margin-left: .5em
        }

        .tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            border-left: 1px solid
        }

        .tree li {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 700;
            position: relative
        }

        .tree ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            left: 0
        }

        .tree ul li:last-child:before {
            background: #fff;
            height: auto;
            top: 1em;
            bottom: 0
        }

        .indicator {
            margin-right: 5px;
        }

        .tree li a {
            text-decoration: none;
            color: #369;
        }

        .tree li button, .tree li button:active, .tree li button:focus {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            outline: 0;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <h1 class="h3"><span class="d-none d-md-inline">{{__('Übersicht Standort')}} </span>{{ $location->l_name_kurz }}</h1>
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
                        >Stammdaten
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
                        >Anforderungen
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="locExplorer-tab"
                           data-toggle="tab"
                           href="#locExplorer"
                           role="tab"
                           aria-controls="locExplorer"
                           aria-selected="false"
                        >Explorer
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
                        >Gebäude <span class="badge badge-info">{{ $location->Building->count() }}</span></a>
                    </li>
                </ul>
                <div class="tab-content"
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

                                    <div class="form-group">
                                        <label for="l_name_kurz">Kurzbezeichnung (max 10 Zeichen)</label>
                                        <input type="text"
                                               name="l_name_kurz"
                                               id="l_name_kurz"
                                               class="form-control {{ $errors->has('l_name_kurz') ? ' is-invalid ': '' }}"
                                               maxlength="10"
                                               value="{{ $location->l_name_kurz }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="l_name_lang">Bezeichnung (max 100 Zeichen)</label>
                                        <input type="text"
                                               name="l_name_lang"
                                               id="l_name_lang"
                                               class="form-control"
                                               maxlength="100"
                                               value="{{ $location->l_name_lang ?? '' }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="l_beschreibung">Beschreibung</label>
                                        <textarea name="l_beschreibung"
                                                  id="l_beschreibung"
                                                  class="form-control"
                                                  rows="3"
                                        >{{ $location->l_beschreibung ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">Anschrift</h2>
                                    <div class="form-group">
                                        @if ($location->adresse_id===NULL)
                                            <label for="adresse_id"
                                                   class="sr-only"
                                            >Adresse auswähen und zuordnen</label>
                                            <select name="adresse_id"
                                                    id="adresse_id"
                                                    class="custom-select"
                                            >
                                                <option value="void">Bitte Adresse zuordnen</option>
                                                @foreach (App\Adresse::all() as $adresse)
                                                    <option value="{{ $adresse->id }}">{{ $adresse->ad_name_lang }}</option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('adresse.create') }}"
                                               class="btn btn-outline-primary btn-block"
                                            >neue Adresse anlegen
                                            </a>
                                        @else
                                            <label for="adresse_id"
                                                   class="sr-only"
                                            >Die Adresse des Standortes festlegen</label>
                                            <select class="custom-select"
                                                    aria-label="Default select example"
                                                    name="adresse_id"
                                                    id="adresse_id"
                                            >
                                                @foreach (App\Adresse::all() as $addItem)
                                                    <option value="{{$addItem->id}}"
                                                            @if ($addItem->id == $location->adresse_id)
                                                            selected
                                                        @endif>{{ $addItem->ad_anschrift_ort }}, {{ $addItem->ad_anschrift_strasse }} - {{ $addItem->ad_anschrift_hausnummer }}</option>
                                                @endforeach
                                            </select>

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-md-between">
                                                        <h5 class="card-title">Kürzel: {{ $location->Adresse->ad_name_kurz }}</h5>
                                                        <a href="{{ route('adresse.show',$location->Adresse) }}">Details</a>
                                                    </div>

                                                    <dl class="row">
                                                        <dt class="col-sm-3">Postal:</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_name_lang }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Straße, Nr</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_strasse }}, {{ $location->Adresse->ad_anschrift_hausnummer }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Plz</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_plz }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Ort</dt>
                                                        <dd class="col-sm-9">{{ $location->Adresse->ad_anschrift_ort }}</dd>
                                                    </dl>

                                                </div>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="h5">Leitung</h2>
                                    <div class="form-group">
                                        @if ($location->profile_id === NULL)
                                            <label for="profile_id">Keine Mitarbeiter gefunden!</label>
                                            <input type="hidden"
                                                   name="profile_id"
                                                   id="profile_id"
                                            >
                                            <a href="{{ route('profile.create') }}"
                                               class="btn btn-outline-primary btn-block"
                                            >neuen Mitarbeiter anlegen
                                            </a>
                                        @else
                                            <label for="profile_id"
                                                   class="sr-only"
                                            >Leitung des Standortes hat</label>
                                            <select class="custom-select"
                                                    aria-label="Default select example"
                                                    name="profile_id"
                                                    id="profile_id"
                                            >
                                                @foreach (App\Profile::all() as $profileItem)
                                                    <option value="{{$profileItem->id}}"
                                                            @if ($profileItem->id == $location->profile_id)
                                                            selected
                                                        @endif>{{ $profileItem->ma_vorname }} {{ $profileItem->ma_name }}</option>
                                                @endforeach
                                            </select>
                                            <?php // $profile = App\Profile::find( $location->profile_id ); $user= App\User::find($profile->user_id);  ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-md-between">
                                                        <h5 class="card-title">Kontaktdaten</h5>
                                                        <a href="{{ route('profile.show',$location->Profile) }}">Details</a>
                                                    </div>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Name</dt>
                                                        <dd class="col-sm-9">{{ $location->Profile->ma_vorname }} {{ $location->Profile->ma_name }} </dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3"><span class="text-truncate">Telefon</span></dt>
                                                        <dd class="col-sm-9">{{ $location->Profile->ma_telefon }}</dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Mobil</dt>
                                                        <dd class="col-sm-9">
                                                            <a href="tel:{{ $location->Profile->ma_mobil }}">{{ $location->Profile->ma_mobil }}</a>
                                                        </dd>
                                                    </dl>
                                                    <dl class="row">
                                                        <dt class="col-sm-3">E-Mail</dt>
                                                        <dd class="col-sm-9">@if ($location->Profile->User)
                                                                <a href="mailto:{{ $location->Profile->User->email }}">{{ $location->Profile->User->email }}</a> @else - @endif</dd>
                                                    </dl>

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Stammdaten speichern</button>
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
                         id="locExplorer"
                         role="tabpanel"
                         aria-labelledby="locExplorer-tab"
                    >
                        <div class="row">
                            <div class="col-md-4">
                                <ul id="tree1">
                                    <li>

                                            <a href="#">Standort {{ $location->l_name_kurz }}</a>
                                            <span class="badge badge-info">
                                                {{ App\Building::where('location_id',$location->id)->count() }}
                                            </span>

                                        @if (App\Building::where('location_id',$location->id)->count()>0)
                                        <ul>
                                            @foreach(App\Building::where('location_id',$location->id)->get() as $building)
                                                <li>{{ $building->b_name_kurz }}
                                                    @if (App\Room::where('building_id',$building->id)->count() > 0)
                                                        <ul>
                                                            @foreach(App\Room::where('building_id',$building->id)->get() as $room)
                                                                <li>{{ $room->r_name_kurz }}
                                                                    @if (App\Stellplatz::where('room_id',$room->id)->count() > 0)
                                                                        <ul>
                                                                            @foreach(App\Stellplatz::where('room_id',$room->id)->get() as $stellplatz)
                                                                                <li>{{ $stellplatz->sp_name_kurz }}

                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>

                                </ul>
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
                                        >Gebäudeort</label>
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
                                            >Gebäudetyp angeben</label> <select name="building_type_id"
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
*/

        $.fn.extend({
            treed: function (o) {

                let openedClass = 'fa-minus-circle';
                let closedClass = 'fa-plus-circle';

                if (typeof o != 'undefined') {
                    if (typeof o.openedClass != 'undefined') {
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined') {
                        closedClass = o.closedClass;
                    }
                }

                //initialize each of the top levels
                let tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    let branch = $(this); //li with children ul
                    branch.prepend("");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this === e.target) {
                            let icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle();
                        }
                    })
                    branch.children().children().toggle();
                });
                //fire event from the dynamically added icon
                tree.find('.branch .indicator').each(function () {
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                //fire event to open branch if the li contains an anchor instead of text
                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                //fire event to open branch if the li contains a button instead of text
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });

        //Initialization of treeviews

        $('#tree1').treed();

    </script>
@endsection
