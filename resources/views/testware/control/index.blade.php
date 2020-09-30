@extends('layout.layout-main')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">Prüfungen Übersicht</h1>
            </div>
        </div>
    </div>

@endsection
