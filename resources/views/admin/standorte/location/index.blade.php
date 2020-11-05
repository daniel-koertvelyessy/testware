@extends('layout.layout-admin')

@section('pagetitle')
    Standortverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@stop

@section('breadcrumbs')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Portal</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >Standorte
            </li>
        </ol>
    </nav>

@endsection

@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col">
                <h1 class="h4">Übersicht Standorte</h1>
            </div>
        </div>
        @if (isset($locationList))

            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">Standort</th>
                            <th>Bezeichnung</th>
                            <th class="d-none d-md-table-cell">Gebäude</th>
                            <th class="d-none d-md-table-cell">Räume</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($locationList as $location)
                            <tr>
                                <td class="d-none d-md-table-cell">
                                    <a href="/location/{{$location->location->id}}">{{ $location->location->l_name_kurz  }}</a>
                                </td>
                                <td>{{ $location->l_name_lang }}</td>
                                <td>{{ $location->b_name_kurz }}</td>
                                <td class="d-none d-md-table-cell">{{ $location->BuildingType->btname }}</td>
                                <td>
                                    <a href="{{$location->path()}}">
                                        <i class="fas fa-chalkboard"></i> <span class="d-none d-md-table-cell">{{__('Übersicht')}}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $locationList->onEachSide(2)->links() !!}
                    </div>
                </div>

                @else

                    @if  (App\Location::all()->count() >0)
                        <nav class="d-flex justify-content-end align-items-center mb-2">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                                    data-targetid="#locationListField"
                                    data-src="{{ route('getLocationListeAsTable') }}"
                            >
                                <i class="fas fa-list"></i>
                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary btnShowDataStyle"
                                    data-targetid="#locationListField"
                                    data-src="{{ route('getLocationListeAsKachel') }}"
                            >
                                <i class="fas fa-th"></i>
                            </button>
                        </nav>
                        <div class="row"
                             id="locationListField"
                        >
                            @foreach (App\Location::all() as $location)
                                <div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 "
                                     id="loc_id_{{$location->id}}"
                                >
                                    <div class="card"
                                         style="height:20em;"
                                    >
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $location->l_name_kurz }}</h5>
                                            <h6 class="card-subtitletext-muted">{{ $location->l_name_lang }}</h6>
                                            <p class="card-text mt-1 mb-0"><small><strong>Gebäude:</strong> {{ $location->Building->count() }}</small></p>
                                            <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                            <p class="mt-0"
                                               style="height:6em;overflow-y: scroll"
                                            >{{ $location->l_beschreibung }}</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center">
                                            <a href="{{$location->path()}}"
                                               class="btn btn-link btn-sm mr-auto"
                                            ><i class="fas fa-chalkboard"></i> Übersicht
                                            </a>
                                            @if ($location->Building->count()===0)
                                                <button type="button"
                                                        class="btn btn-link btn-sm btnDeleteLocation"
                                                        data-id="{{ $location->id }}"
                                                        title="Standort {{ $location->l_name_kurz }} löschen"
                                                ><i class="far fa-trash-alt"></i></button>
                                                <form action="{{ route('location.destroy',$location->id) }}"
                                                      id="frmDeleteLocation_{{ $location->id }}"
                                                      target="_blank"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_{{ $location->id }}"
                                                           value="{{ $location->id }}"
                                                    >
                                                    <input type="hidden"
                                                           name="frmOrigin"
                                                           id="frmOrigin_{{ $location->id }}"
                                                           value="building"
                                                    >
                                                    <input type="hidden"
                                                           name="l_name_kurz"
                                                           id="l_name_kurz_{{ $location->id }}"
                                                           value="{{ $location->l_name_kurz }}"
                                                    >
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else<h5 class="card-title">Schnellstart</h5>
                    <form action="{{ route('location.store') }}"
                          method="post"
                          class=" needs-validation"
                    >
                        <div class="row">

                            @csrf
                            <div class="col-md-4">

                                <h6 class="card-subtitle mb-2 text-muted">Erstellen Sie den ersten Standort</h6>
                                <x-rtextfield id="l_name_kurz"
                                              label="Kurzbezeichnung"
                                />
                                <x-textfield id="l_name_lang"
                                             label="Bezeichnung"
                                />
                                <p class="card-text">Sie können später weitere Informationen anlegen</p>

                                <input type="hidden"
                                       name="standort_id"
                                       id="standort_id"
                                       value="{{ Str::uuid() }}"
                                >
                            </div>
                            <div class="col-md-4">
                                <h6 class="card-subtitle mb-2 text-muted">Adresse</h6>
                                @php($adressen = App\Adresse::all())
                                @if ($adressen->count()>0)
                                    <x-selectfield id="adresse_id"
                                                   label="Bitte die Adresse auswählen"
                                    >
                                        @foreach($adressen as $adresse)
                                            <option value="{{ $adresse->id }}">{{ $adresse->ad_name_kurz }}</option>
                                        @endforeach
                                    </x-selectfield>

                                @else
                                    <x-rtextfield id="ad_name_kurz"
                                                  label="Kürzel"
                                    />
                                    <x-rtextfield id="ad_anschrift_strasse"
                                                  label="Straße"
                                    />
                                    <div class="row">
                                        <div class="col-md-3">
                                            <x-rtextfield id="ad_anschrift_plz"
                                                          label="PLZ"
                                                          max="30"
                                            />
                                        </div>
                                        <div class="col-md-9">
                                            <x-rtextfield id="ad_anschrift_ort"
                                                          label="Ort"
                                                          max="100"
                                            />
                                        </div>
                                    </div>
                                    <input type="hidden"
                                           name="address_type_id"
                                           id="address_type_id"
                                           value="1"
                                    >
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6 class="card-subtitle mb-2 text-muted">Leitung</h6>
                                @php($profiles = App\Profile::all())
                                @if ($profiles->count()>0)
                                    <x-selectfield id="profile_id"
                                                   label="Bitte Leitung des Standortes festlegen"
                                    >
                                        @foreach($profiles as $ma)
                                            <option value="{{ $ma->id }}">{{ $ma->ma_name }}, {{ $ma->ma_vorname }} </option>
                                        @endforeach
                                    </x-selectfield>

                                @else
                                    <x-rtextfield id="ma_vorname"
                                                  label="Vorname"
                                    />
                                    <x-rtextfield id="ma_name"
                                                  label="Nachname"
                                    />
                                    <x-selectfield id="user_id"
                                                   label="System Benutzer zuordnen"
                                    >
                                        @foreach (App\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                                        @endforeach
                                    </x-selectfield>
                                @endif
                            </div>

                            {{--                dd(Profile::all()->count(),Adresse::all()->count());--}}
                        </div>
                        <x-btnMain> Standort anlegen <i class="far fa-save"></i></x-btnMain>
                    </form>
                    @endif

                @endif
            </div>

            @endsection

        @section('scripts')
            <script>
                $('.btnDeleteLocation').click(function () {
                    const rommId = $(this).data('id');
                    console.log(rommId);
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "{{ route('location.destroyLocationAjax') }}",
                        data: $('#frmDeleteLocation_' + rommId).serialize(),
                        success: function (res) {
                            if (res) location.reload();

                        }
                    });
                });
            </script>
@endsection
