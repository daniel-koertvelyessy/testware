@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Produkte @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Produkt-Verwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <p>Sie können in diesem Modul folgende Aufgaben ausführen</p>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('produkt.index') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-boxes"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>

                        <a href="{{ route('getKategorieProducts',1) }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-list-ol"></i></span>
                            <span class="branding-bar text-center">Kategorien</span>
                        </a>

                        <a href="{{ route('produkt.create') }}" class="tile-medium rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>
                </section>

            </div>
        </div>
    </div>

@endsection
