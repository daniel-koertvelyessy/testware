@extends('layout.layout-admin')

@section('pagetitle')
    {{ __('Systemstatus') }} &triangleright; {{__('Systemeinstellungen')}}@endsection

@section('mainSection')
    {{__('Systemstatus')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

{{--@section('breadcrumbs')--}}{{--    <nav aria-label="breadcrumb">--}}{{--        <ol class="breadcrumb">--}}{{--            <li class="breadcrumb-item">--}}{{--                <a href="/">{{__('Portal')}}</a>--}}{{--            </li>--}}{{--            <li class="breadcrumb-item active"--}}{{--                aria-current="page"--}}{{--            >{{__('Verwaltung')}}--}}{{--            </li>--}}{{--        </ol>--}}{{--    </nav>--}}{{--@endsection--}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Systemstatus')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs"
                         id="nav-tab"
                         role="tablist"
                    >
                        <button class="nav-link active"
                                id="nav-objects-tab"
                                data-toggle="tab"
                                data-target="#nav-objects"
                                type="button"
                                role="tab"
                                aria-controls="nav-objects"
                                aria-selected="true"
                        >@if($objects['incomplete_equipment']>0 && $objects['equipment']>0 ||
$objects['incomplete_requirement']>0 && $objects['requirements']>0 ||
$objects['equipment_qualified_user'] === 0 ||
$objects['product_qualified_user'] === 0 ||
$objects['regulations'] === 0 ||
$objects['requirements'] === 0 ||
$objects['requirements_items'] === 0 ||
$objects['products'] === 0 ||
$objects['control_products']===0 &&
$objects['storages'] === 0                                            )
                                <span class="text-warning">{{__('Objekte')}}</span></button>
                        @else
                            Objekte
                        @endif
                        <button class="nav-link"
                                id="nav-dblinks-tab"
                                data-toggle="tab"
                                data-target="#nav-dblinks"
                                type="button"
                                role="tab"
                                aria-controls="nav-dblinks"
                                aria-selected="false"
                        >
                            <span class="{{ $dbstatus['totalBrokenLinks']>0 || $dbstatus['brokenProducts']>0 ? 'text-danger' :
                            'text-success'}}"
                            >{{__('Datenbank')}}</span>
                        </button>
                    </div>
                </nav>
                <div class="tab-content pt-3"
                     id="nav-tabContent"
                >
                    <div class="tab-pane fade show active"
                         id="nav-objects"
                         role="tabpanel"
                         aria-labelledby="nav-objects-tab"
                    >
                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="h5">{{ __('memStandorte') }}</h2>
                                @if($objects['storages']>0)
                                    <x-system-status-msg counter="{{ $objects['storages'] }}"
                                                         link="{{ route('lexplorer') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Standorte/Abstellplätze sind erstellt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('location.create') }}"
                                                         type="danger"
                                                         msg="{{ __('Keine Standorte gefunden') }}"
                                    />
                                @endif
                                <h2 class="h5">{{ __('Verordnungen') }}</h2>
                                @if($objects['regulations']>0)
                                    <x-system-status-msg counter="{{ $objects['regulations'] }}"
                                                         link="{{ route('verordnung.main') }}"
                                                         msg="{{ __('Sehr gut! Verordnungen sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('verordnung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Verordnungen gefunden') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Anforderungen') }}</h2>
                                @if($objects['requirements']>0)
                                    <x-system-status-msg counter="{{ $objects['requirements'] }}"
                                                         link="{{ route('anforderung.index') }}"
                                                         msg="{{ __('Sehr gut! Anforderungen sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('anforderung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Anforderungen gefunden') }}"
                                    />
                                @endif

                                @if($objects['incomplete_requirement']>0 && $objects['requirements']>0)
                                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                                    <x-system-status-msg link="{{ route('anforderung.index') }}"
                                                         msg="{{ $objects['incomplete_requirement'] }} {{ __('Anforderungen
                                                         haben keine Kontrollvorgänge') }}"
                                                         type="warning"
                                    />
                                @elseif($objects['incomplete_requirement']===0 && $objects['requirements']>0)
                                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                                    <x-system-status-msg counter="0"
                                                         link="{{ route('anforderung.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Alle Anforderungen sind vollständig') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Kontrollvorgänge') }}</h2>
                                @if($objects['requirements_items']>0)
                                    <x-system-status-msg counter="{{ $objects['requirements_items'] }}"
                                                         link="{{ route('anforderungcontrolitem.index') }}"
                                                         msg="{{ __('Sehr gut! Kontrollvorgänge sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('anforderung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Anforderungen gefunden') }}"
                                    />
                                @endif


                            </div>
                            <div class="col-md-4">
                                <h2 class="h5">{{ __('Produkte') }}</h2>
                                @if($objects['products']>0)
                                    <x-system-status-msg counter="{{ $objects['products'] }}"
                                                         link="{{ route('produktMain') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Produkte sind erstellt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.create') }}"
                                                         type="danger"
                                                         msg="{{ __('Keine Produkte gefunden') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Prüfprodukte') }}</h2>
                                @if($objects['control_products']>0)
                                    <x-system-status-msg counter="{{ $objects['control_products'] }}"
                                                         link="{{ route('produktMain') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Prüfprodukte sind definiert') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Produkte als Prüfmittel definiert') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Produkte') }}
                                    <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                </h2>
                                @if($objects['product_qualified_user']>0)
                                    <x-system-status-msg counter="{{ $objects['product_qualified_user'] }}"
                                                         link="{{ route('produkt.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Benutzer sind befähigt!') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine befähigten Benutzer gefunden') }}"
                                    />
                                @endif
                            </div>
                            <div class="col-md-4">

                                @if($objects['equipment']>0)
                                    <h2 class="h5">{{ __('Geräte') }}</h2>
                                    <x-system-status-msg counter="{{ $objects['equipment'] }}"
                                                         type="pass"
                                                         link="{{ route('equipMain') }}"
                                                         msg="{{ __('Sehr gut! Es sind Geräte angelegt') }}"
                                    />
                                    <h2 class="h5">{{ __('Geräte ohne Prüfungen') }}</h2>
                                    @if($objects['incomplete_equipment']>0 )
                                        <x-system-status-msg link="{{ route('equipMain') }}"
                                                             type="warning"
                                                             msg="{{ __('Es existieren Geräte ohne Prüfungen') }}"
                                        />
                                    @else
                                        <x-system-status-msg counter="{{ $objects['incomplete_equipment']  }}"
                                                             type="pass"
                                                             link="{{ route('equipMain') }}"
                                                             msg="{{ __('Sehr gut! Alle Geräte haben mindestens eine Prüfungen') }}"
                                        />
                                    @endif
                                @endif
                                @if($objects['products']>0 && $objects['equipment']===0)
                                    <h2 class="h5">{{ __('Geräte') }}</h2>
                                    <x-system-status-msg link="{{ route('equipment.maker') }}"
                                                         type="info"
                                                         msg="{{ __('Es sind noch keine Geräte angelegt worden') }}"
                                                         labelBtn="{{ __('anlegen') }}"
                                    />
                                @endif
                                <h2 class="h5">{{ __('Prüfgeräte') }}</h2>
                                @if($objects['control_equipment']>0)
                                    <x-system-status-msg counter="{{ $objects['control_equipment'] }}"
                                                         type="pass"
                                                         link="{{ route('equipMain') }}"
                                                         msg="{{ __('Sehr gut! Prüfgeräte sind angelegt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('equipment.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Prüfgeräte definiert') }}"
                                    />
                                @endif
                                @if($objects['equipment_qualified_user']>0 && $objects['equipment']>0)
                                    <h2 class="h5">{{ __('Geräte') }}
                                        <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                    </h2>
                                    <x-system-status-msg counter="{{ $objects['equipment_qualified_user'] }}"
                                                         link="{{ route('equipment.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Benutzer sind befähigt!') }}"
                                    />
                                @elseif($objects['equipment_qualified_user']===0 && $objects['equipment']>0)
                                    <h2 class="h5">{{ __('Geräte') }}
                                        <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                    </h2>
                                    <x-system-status-msg link="{{ route('equipMain') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine befähigten Benutzer gefunden') }}"
                                    />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="nav-dblinks"
                         role="tabpanel"
                         aria-labelledby="nav-dblinks-tab"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                @if($dbstatus['totalBrokenLinks']>0)

                                    Es sind {{$dbstatus['totalBrokenLinks']}} verwaiste Einträge gefunden worden.

                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{__('Keine verwaisen Prüfungen')}}</h4>
                                        <p>{{__('Es konten keine verwaisten Prüfungen gefunden werden.')}}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($dbstatus['brokenProducts']>0)
                                    @if($dbstatus['brokenProducts']>1)
                                        <p class="lead text-danger">Es sind {{ $dbstatus['brokenProducts'] }} Produkte ohne UUID gefunden worden!</p>
                                    @else
                                        <p class="lead text-danger">Es ist ein Produkt ohne UUID gefunden worden!</p>
                                    @endif
                                        <a href="{{ route('products.setuuids') }}" class="btn btn-outline-primary">beheben</a>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{__('Keine Produkte ohne UUID')}}</h4>
                                        <p>{{__('Es wurde keine Produkte ohne UUID gefunden.')}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
