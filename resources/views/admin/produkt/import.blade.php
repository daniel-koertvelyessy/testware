@extends('layout.layout-admin')

@section('pagetitle')
    Produkt importieren &triangleright; Produkte @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produkt.index') }}">Produkte</a></li>
            <li class="breadcrumb-item active" aria-current="page">Import</li>
        </ol>

    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">Produkte importieren</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
@endsection
