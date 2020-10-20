@extends('layout.layout-admin')

@section('pagetitle')
    Systemeinstellungen | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Admin
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verwaltung</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Systemverwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <h2 class="h4">Lizenzdaten</h2>
                <ul class="list-unstyled">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Lizenznehmer</span>
                        <span class="text-info">thermo-control Körtvélyessy GmbH</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Lizenznummer</span>
                        <span class="text-info">{{ \Illuminate\Support\Str::uuid() }}</span>
                    </li>
                </ul>
                <h3 class="h5">Objektliste</h3>
                <ul class="list-unstyled">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Standorte</span>
                        <span>{{$countLocation =  \App\Location::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Gebäude</span>
                        <span>{{$countBuilding =  \App\Building::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Räume</span>
                        <span>{{ $countRoom = \App\Room::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Stellplätze</span>
                        <span>{{$countStelplatz =  \App\Stellplatz::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Geräte</span>
                        <span>{{$countEquipment =  \App\Equipment::all()->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="lead">Gesamt</span>
                        <span class="lead text-info">{{ $countLocation+$countBuilding+$countRoom+$countStelplatz+$countEquipment }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Kontingent</span>
                        <span>{{ config('app.maxobjekte') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                        <span class="lead">Verfügbar</span>
                        <span class="lead">{{ config('app.maxobjekte') -($countLocation+$countBuilding+$countRoom+$countStelplatz+$countEquipment) }}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-primary">100 Objekte kaufen <i class="fas fa-shopping-cart"></i></button>
                    <button class="btn btn-sm btn-outline-primary">1000 Objekte kaufen <i class="fas fa-shopping-cart"></i></button>
                </div>
            </div>
        </div>


    </div>

@endsection
