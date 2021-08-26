@extends('layout.layout-admin')

@section('pagetitle')
{{ __('Systemstatus') }} &triangleright; {{__('Systemeinstellungen')}}
@endsection

@section('mainSection')
    {{__('Systemstatus')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

{{--@section('breadcrumbs')--}}
{{--    <nav aria-label="breadcrumb">--}}
{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item">--}}
{{--                <a href="/">{{__('Portal')}}</a>--}}
{{--            </li>--}}
{{--            <li class="breadcrumb-item active"--}}
{{--                aria-current="page"--}}
{{--            >{{__('Verwaltung')}}--}}
{{--            </li>--}}
{{--        </ol>--}}
{{--    </nav>--}}
{{--@endsection--}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{__('Übersicht Systemstatus')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2 class="h5">{{ __('memStandorte') }}</h2>
                @if($system['storages']>0)
                    <x-system-status-msg counter="{{ $system['storages'] }}"
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
                @if($system['regulations']>0)
                    <x-system-status-msg counter="{{ $system['regulations'] }}"
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
                @if($system['requirements']>0)
                    <x-system-status-msg counter="{{ $system['requirements'] }}"
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

                @if($system['incomplete_requirement']>0 && $system['requirements']>0)
                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                    <x-system-status-msg link="{{ route('anforderung.index') }}"
                                         msg="{{ $system['incomplete_requirement'] }} {{ __('Anforderungen haben keine Kontrollvorgänge') }}"
                                         type="warning"
                    />
                @elseif($system['incomplete_requirement']===0 && $system['requirements']>0)
                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                    <x-system-status-msg counter="0"
                                         link="{{ route('anforderung.index') }}"
                                         type="pass"
                                         msg="{{ __('Sehr gut! Alle Anforderungen sind vollständig') }}"
                    />
                @endif

                <h2 class="h5">{{ __('Kontrollvorgänge') }}</h2>
                @if($system['requirements_items']>0)
                    <x-system-status-msg counter="{{ $system['requirements_items'] }}"
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
                @if($system['products']>0)
                    <x-system-status-msg counter="{{ $system['products'] }}"
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
                @if($system['control_products']>0)
                    <x-system-status-msg counter="{{ $system['control_products'] }}"
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

                <h2 class="h5">{{ __('Produkte') }} <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}</h2>
                @if($system['product_qualified_user']>0)
                    <x-system-status-msg counter="{{ $system['product_qualified_user'] }}"
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

                @if($system['equipment']>0)
                    <h2 class="h5">{{ __('Geräte') }}</h2>
                    <x-system-status-msg counter="{{ $system['equipment'] }}"
                                         type="pass"
                                         link="{{ route('equipMain') }}"
                                         msg="{{ __('Sehr gut! Es sind Geräte angelegt') }}"
                    />
                    <h2 class="h5">{{ __('Geräte ohne Funktionsprüfung') }}</h2>
                    @if($system['incomplete_equipment']>0 )
                        <x-system-status-msg link="{{ route('equipMain') }}"
                                             type="warning"
                                             msg="{{ __('Es existieren Geräte ohne Funktionsprüfung') }}"
                        />
                    @else
                        <x-system-status-msg counter="{{ $system['incomplete_equipment']  }}"
                                             type="pass"
                                             link="{{ route('equipMain') }}"
                                             msg="{{ __('Sehr gut! Alle Geräte haben eine Funktionsprüfung') }}"
                        />
                    @endif
                @endif
                @if($system['products']>0 && $system['equipment']===0)
                    <h2 class="h5">{{ __('Geräte') }}</h2>
                    <x-system-status-msg link="{{ route('equipment.maker') }}"
                                         type="info"
                                         msg="{{ __('Es sind noch keine Geräte angelegt worden') }}"
                                         labelBtn="{{ __('anlegen') }}"
                    />
                @endif
                <h2 class="h5">{{ __('Prüfgeräte') }}</h2>
                @if($system['control_equipment']>0)
                    <x-system-status-msg counter="{{ $system['control_equipment'] }}"
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
                @if($system['equipment_qualified_user']>0 && $system['equipment']>0)
                    <h2 class="h5">{{ __('Geräte') }} <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}</h2>
                    <x-system-status-msg counter="{{ $system['equipment_qualified_user'] }}"
                                         link="{{ route('equipment.index') }}"
                                         type="pass"
                                         msg="{{ __('Sehr gut! Benutzer sind befähigt!') }}"
                    />
                @elseif($system['equipment_qualified_user']===0 && $system['equipment']>0)
                    <h2 class="h5">{{ __('Geräte') }} <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}</h2>
                    <x-system-status-msg link="{{ route('equipMain') }}"
                                         type="warning"
                                         msg="{{ __('Keine befähigten Benutzer gefunden') }}"
                    />
                @endif
            </div>
        </div>
    </div>

@endsection
