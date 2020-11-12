@extends('layout.layout-admin')

@section('pagetitle')
    {{ __('Suchergebnis') }}
@endsection

@section('mainSection')
    {{__('Suche')}}
@endsection

@section('menu')
    @include('menus._menuPortal')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{ __('Suche') }}</h1>
            </div>
        </div>

        @if ($term)

            <div class="row my-5 d-flex justify-content-center">
                <div class="col-md-5">
                    <form action="{{ route('search.index') }}"
                          method="get"
                    >
                        @csrf
                        <label for="srchTopMenuTerm_new">
                            @if ($numResults  > 0)
                                <span class="badge badge-success">
                            {{ $numResults }}
                        </span>
                            @else
                                {{__('keine')}}
                            @endif
                            {{__('Treffer zum Begriff')}} <span class="badge badge-info">{{ $term }}</span> {{__('gefunden')}} </label>
                        <div class="input-group mb-3">
                            <input type="search"
                                   id="srchTopMenuTerm_new"
                                   name="srchTopMenuTerm"
                                   class="form-control form-control-lg"
                                   value="{{ $term }}"
                            >
                            <button class="btn btn-primary btn-lg ml-2">
                                {{__('Neue Suche')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-5"
                 id="resultCols"
            >
                <div class="col">
                    @if($resultsEquipment->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Geräte') }}
                            <span class="badge badge-primary">{{ $resultsEquipment->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsEquipment as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Inventar-Nr')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->eq_inventar_nr }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Serien-Nr')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->eq_serien_nr }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('UID')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->eq_uid }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->eq_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('equipment.show',$objekt) }}">{{ __('Gerät') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsControlEvent->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Prüfung') }}
                            <span class="badge badge-primary">{{ $resultsControlEvent->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsControlEvent as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->control_event_text??'-') !!}</dd>
                                    </dl>

                                    <a href="{{ route('controlevent.show',$objekt) }}">{{ __('Prüfung') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsEquipmentEvent->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Ereignis') }}
                            <span class="badge badge-primary">{{ $resultsEquipmentEvent->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsEquipmentEvent as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->equipment_event_user??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('equipmentevent.show',$objekt) }}">{{ __('Ereignis') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsProdukt->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Produkte') }}
                            <span class="badge badge-primary">{{ $resultsProdukt->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsProdukt as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Nummer')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->prod_nummer }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->prod_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->prod_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->prod_name_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('produkt.show',$objekt) }}">{{ __('Produkt') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsVerordnung->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Verordnung') }}
                            <span class="badge badge-primary">{{ $resultsVerordnung->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsVerordnung as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->vo_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->vo_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Nummer')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->vo_nummer }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Stand')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->vo_stand }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->vo_name_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('verordnung.show',$objekt) }}">{{ __('Verordnung') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsAnforderung->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Anfoderung') }}
                            <span class="badge badge-primary">{{ $resultsAnforderung->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsAnforderung as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->an_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->an_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->an_name_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('anforderung.show',$objekt) }}">{{ __('Anforderung') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsAnforderungItem->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Anfoderung') }}
                            <span class="badge badge-primary">{{ $resultsAnforderungItem->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsAnforderungItem as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->aci_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->aci_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->aci_task??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('anforderungcontrolitem.show',$objekt) }}">{{ __('Vorgang') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsAdresse->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Adresse') }}
                            <span class="badge badge-primary">{{ $resultsAdresse->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsAdresse as $objekt)

                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma 2')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma_2 }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma c/o')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma_co }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma Abteilung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma_abteilung }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma Abladestelle')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma_abladestelle }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Firma Wareneingang')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_name_firma_wareneingang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Straße')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_strasse }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Nummer')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_hausnummer }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Etage')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_etage }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Einang')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_eingang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('PLZ')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_plz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Ort')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->ad_anschrift_ort }}</dd>
                                    </dl>

                                    <a href="{{ route('adresse.show',$objekt) }}">{{ __('Adresse') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsLocation->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Standort') }}
                            <span class="badge badge-primary">{{ $resultsLocation->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsLocation as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->l_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->l_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->l_beschreibung??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('location.show',$objekt) }}">{{ __('Standort') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsBuildung->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Gebäude') }}
                            <span class="badge badge-primary">{{ $resultsBuildung->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsBuildung as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->b_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Ort')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->b_name_ort }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->l_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->l_beschreibung??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('building.show',$objekt) }}">{{ __('Gebäude') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsRoom->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Räume') }}
                            <span class="badge badge-primary">{{ $resultsRoom->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsRoom as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->r_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->r_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->r_name_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('room.show',$objekt) }}">{{ __('Gebäude') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif

                    @if($resultsStellplatz->count()>0)
                        <p class="lead">
                            {{ __('Modul') }} {{ __('Stellplätze') }}
                            <span class="badge badge-primary">{{ $resultsStellplatz->count() }}</span>
                        </p>
                        <div class="list-group list-group-flush">
                            @foreach($resultsStellplatz as $objekt)
                                <div class="list-group-item">
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Kürzel')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->sp_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Bezeichnung')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{{ $objekt->sp_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{__('Text')}}:</dt>
                                        <dd class="col-md-8 col-lg-9">{!! nl2br($objekt->sp_name_text??'-') !!}</dd>
                                    </dl>
                                    <a href="{{ route('stellplatz.show',$objekt) }}">{{ __('Spellplatz') }} {{ __('öffnen') }}</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                    @endif
                </div>
            </div>

        @else
            <div class="row my-5 d-flex justify-content-center">
                <div class="col-md-5">
                    <form action="{{ route('search.index') }}"
                          method="get"
                    >
                        @csrf
                        <label for="srchTopMenuTerm_new">Suchbegriff eingeben</label>
                        <div class="input-group mb-3">
                            <input type="search"
                                   id="srchTopMenuTerm_new"
                                   name="srchTopMenuTerm"
                                   class="form-control form-control-lg"
                                   value=""
                            >
                            <button class="btn btn-primary btn-lg ml-2">
                                Suche starten
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/mark.js') }}"></script>
    <script>
        let keyword = '{{ $term??'' }}',
            options = {
                "element": "span",
                "className": "mark",
                "separateWordSearch": false
            },
            $ctx = $('#resultCols');
        $ctx.unmark({
            done: function () {
                $ctx.mark(keyword, options);
            }
        });
    </script>
@endsection

