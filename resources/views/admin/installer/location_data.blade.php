@extends('layout.layout-login')

@section('pagetitle')
{{__('Initialdaten')}} &triangleright; {{__('Installation')}} &triangleright; testWare
@endsection

@section('modals')
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
                                <x-textfield id="ad_labels"
                                             name="ad_label"
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
         id="modalAddNewProfile"
         tabindex="-1"
         aria-labelledby="modalAddNewProfileLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('profile.store') }}"
                      method="post"
                >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddNewProfileLabel"
                        >{{ __('Neuen Mitarbeiter anlegen') }}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-frm_newprofile/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary"
                        >{{ __('Anlegen') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand"
           href="#"
        >{{ __('Installation') }}</a>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
             id="navbarSupportedContent"
        >
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.server') }}"
                       tabindex="-1"
                       aria-disabled="false"
                    >{{ __('Server') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.user') }}"
                       aria-disabled="false"
                    >{{ __('Benutzer') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       aria-disabled="false"
                       href="{{ route('installer.company') }}"
                    >{{ __('Firmierung') }}</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link disabled"
                       href="{{ route('installer.location') }}"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('memStandort') }}<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div class="navbar-nav">
                <button class="btn btn-sm btn-primary"
                        onclick="event.preventDefault(); document.getElementById('frmStoreBaseLocation').submit();"
                >{{ __('Daten speichern und zurück zum Dashboard') }}</button>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(!$location)
            <div class="alert alert-info alert-dismissible fade show my-4 w-sm-100 w-lg-75 ml-auto mr-auto"
                 role="alert"
            >
                <p>Erstellen Sie Ihren Hauptstandort. Sie können im Explorer später die Struktur weiter ausbauen.</p>

                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{ route('location.store') }}"
              method="post"
              id="frmStoreBaseLocation"
              class="needs-validation"
        >
            @csrf
            @if(isset($location->id))
                <input type="hidden"
                       name="id"
                       id="id"
                       value="{{ $location->id }}"
                >
            @endif
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ $location->storage_id ?? Str::uuid() }}"
            >
            <div class="row">
                <div class="col">
                    <x-selectfield id="adresse_id"
                                   label="{{__('Die Adresse des Standortes festlegen')}}"
                                   class="btnAddNewAdresse"
                    >
                        @forelse (App\Adresse::all() as $addItem)
                            <option value="{{$addItem->id}}">{{ $addItem->ad_label  }} - {{ $addItem->ad_anschrift_strasse }}</option>
                        @empty
                            <option value="void"
                                    disabled
                            >{{__('keine Adressen vorhanden')}}</option>
                        @endforelse
                    </x-selectfield>
                </div>
                <div class="col">
                    <x-selectfield id="profile_id"
                                   label="{{__('Leitung des Standortes hat')}}"
                                   class="btnAddNewProfile"
                    >
                        @forelse (App\Profile::all() as $profileItem)
                            <option value="{{$profileItem->id}}">{{ $profileItem->ma_name }}, {{ $profileItem->ma_vorname }}</option>
                        @empty
                            <option value="void"
                                    disabled
                            >{{__('keine Mitarbeiter vorhanden')}}</option>
                        @endforelse
                    </x-selectfield>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <x-rtextfield id="l_label"
                                  label="Kürzel"
                                  value="{{ $location->l_label ?? '' }}"
                    />
                    <x-textfield id="l_name"
                                 label="Bezeichnung"
                                 value="{{ $location->l_name ?? '' }}"
                    />
                    <x-textarea id="l_beschreibung"
                                label="Beschreibung"
                                value="{{ $location->l_beschreibung ?? '' }}"
                    />
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="continueExplorer"
                               name="continueExplorer"
                        >
                        <label class="custom-control-label"
                               for="continueExplorer"
                        >{{ __('nach dem Speichern die Bearbeitung im Explorer fortsetzen') }}</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger fixed-bottom alert-dismissible fade show">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endsection

@section('scripts')

    <script>

    </script>

@endsection
