@extends('layout.layout-admin')

@section('pagetitle')
    Produkt exportieren &triangleright; Produkte @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produkt.index') }}">Produkte</a></li>
            <li class="breadcrumb-item active" aria-current="page">Export</li>
        </ol>

    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Produkte exportieren</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 class="h5">Als JSON Datei exportieren</h2>

                <p class="lead">Komplett mit Produkt-Kategorie, Anforderungen und Parameterlisten</p>
                <a href="{{ route('exportProduktToJson') }}" class="btn btn-outline-primary my-4">Komplett starten <i class="far fa-file-code"></i></a>

            </div>
        </div>
    </div>
@endsection
