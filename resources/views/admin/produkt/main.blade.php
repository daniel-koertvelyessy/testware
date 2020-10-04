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

                        <a href="{{ route('produkt.create') }}" class="tile-medium rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>
                </section>

                <section class="card-body text-dark">
                    <h3 class="h5">Neues Produkt aus Kategorie erstellen</h3>

                    <nav class="tiles-grid justify-content-md-around justify-content-sm-center">
                        @foreach (App\ProduktKategorie::all() as $produktKategorie)
                            <a href="{{ route('produkt.create',['pk'=> $produktKategorie->id]) }}" class="tile-medium rounded" data-role="tile">
                                <span class="icon"><i class="fas fa-box"></i></span>
                                <span class="branding-bar text-center">{{$produktKategorie->pk_name_kurz}}</span>
                            </a>
                        @endforeach
                    </nav>

                </section>

            </div>
        </div>
    </div>

@endsection
