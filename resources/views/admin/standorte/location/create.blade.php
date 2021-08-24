@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neu anlegen')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
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
    <div class="container mt-2">
        <h1 class="h3">{{__('Neuen Standort anlegen')}}</h1>
        <form action="{{ route('location.store') }}"
              method="post"
              class="needs-validation"
        >
            @csrf
            <input type="hidden"
                   name="storage_id"
                   id="storage_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col">

                    <x-selectModalgroup id="adresse_id"
                                        label="{{__('Die Adresse des Standortes festlegen')}}"
                                        class="btnAddNewAdresse"
                                        modalid="modalAddAdresse"
                    >
                        @forelse (App\Adresse::all() as $addItem)
                            <option value="{{$addItem->id}}">{{ $addItem->ad_label  }} - {{ $addItem->ad_anschrift_strasse }}</option>
                        @empty
                            <option value="void"
                                    disabled
                            >{{__('keine Adressen vorhanden')}}</option>
                        @endforelse
                    </x-selectModalgroup>

                </div>
                <div class="col">
                    <x-selectModalgroup id="profile_id"
                                        label="{{__('Leitung des Standortes hat')}}"
                                        class="btnAddNewProfile"
                                        modalid="modalAddNewProfile"
                    >
                        @forelse (App\Profile::all() as $profileItem)
                            <option value="{{$profileItem->id}}">{{ $profileItem->ma_name }}, {{ $profileItem->ma_vorname }}</option>
                        @empty
                            <option value="void"
                                    disabled
                            >{{__('keine Mitarbeiter vorhanden')}}</option>
                        @endforelse
                    </x-selectModalgroup>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <x-rtextfield id="l_label"
                                  label="{{__('Kürzel')}}"
                    />
                    <x-textfield id="l_name"
                                 label="{{__('Bezeichnung')}}"
                    />
                    <x-textarea id="l_beschreibung"
                                label="{{__('Beschreibung')}}"
                    />

                </div>
            </div>
            <x-btnMain>{{__('Standort anlegen')}} <span class="ml-3 fas fa-download"></span></x-btnMain>
        </form>
    </div>

@endsection


@section('actionMenuItems')
    {{--    <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
            <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
                <a class="dropdown-item" href="#">Drucke Übersicht</a>
                <a class="dropdown-item" href="#">Standortbericht</a>
                <a class="dropdown-item" href="#">Formularhilfe</a>
            </ul>--}}
@endsection()

@section('scripts')

    <script>


    </script>

@endsection
