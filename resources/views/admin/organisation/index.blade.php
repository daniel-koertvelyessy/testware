@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Standortplanung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Sie können in diesem Bereich folgende Aufgaben ausführen</p>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('adresse.index') }}" class="tile-medium rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-address-card"></i></span>
                            <span class="branding-bar text-center">Adressen</span>
                        </a>
                        <a href="{{ route('firma.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">Firmen</span>
                        </a>
                        <a href="{{ route('profile.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                            <span class="branding-bar text-center">Mitarbeiter</span>
                        </a>
                    </nav>
                </section>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('adresse.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="far fa-folder"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                        <a href="{{ route('firma.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                        <a href="{{ route('profile.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-plus"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                    </nav>
                </section>
            </div>
        </div>
    </div>

@endsection
