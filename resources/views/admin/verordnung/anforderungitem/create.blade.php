@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Neue Prüfung anlegen')}}
@endsection

@section('mainSection')
    {{__('Neue Prüfung anlegen')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row md-4 d-none d-md-block">
            <div class="col">
                <h1 class="h3">{{__('Neue Prüfung anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @include('components.addNewAnforderungControlItem')
            </div>
        </div>

    </div>

@endsection
