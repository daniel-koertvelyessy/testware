@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Standort-Verwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <p>Sie können in diesem Modul folgende Aufgaben ausführen</p>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('location.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">Standorte</span>
                        </a>

                        <a href="{{ route('building.index') }}" class="tile-medium rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-building"></i></span>
                            <span class="branding-bar text-center">Gebäude</span>
                        </a>

                        <a href="{{ route('room.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-door-open"></i></span>
                            <span class="branding-bar text-center">Räume</span>
                        </a>
                    </nav>
                </section>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('location.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                        <a href="{{ route('building.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                        <a href="{{ route('room.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                    </nav>
                </section>
            </div>
        </div>
    </div>

@endsection
