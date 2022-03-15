@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
{{{__('Sync')}}} &triangleright; {{__('Standorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('content')
    <div class="container">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h3">{{__('Standorte syncronisieren')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>{{ __('Die Syncronisierung ist abgeschlossen!') }}</p>
                <div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Standorte aktualisiert') }}
                            <span class="badge {{ (count($missingLocations) + count($storageEmptyLocations))>0 ? '
                            badge-primary ' : ' badge-light ' }}
                                    badge-pill"
                            >
                                {{ count($missingLocations) + count($storageEmptyLocations)}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Gebäude aktualisiert') }}
                            <span class="badge {{ (count($missingBuildings) + count($storageEmptyBuildings))>0 ? '
                            badge-primary ' : ' badge-light ' }} badge-pill"
                            >
                                {{ count($missingBuildings) + count($storageEmptyBuildings) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Räume aktualisiert') }}
                            <span class="badge {{ (count($missingRooms) + count($storageEmptyRooms))>0 ? '
                            badge-primary ' : ' badge-light ' }} badge-pill"
                            >
                                {{ count($missingRooms) + count($storageEmptyRooms) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Stellplätze aktualisiert') }}
                            <span class="badge {{ (count($missingCompartments) + count($storageEmptyCompartments))>0 ? '
                            badge-primary ' : ' badge-light ' }} badge-pill"
                            >
                                {{ count($missingCompartments) + count($storageEmptyCompartments) }}
                            </span>
                        </li>

                    </ul>
                </div>
            </div>

        </div>

@endsection