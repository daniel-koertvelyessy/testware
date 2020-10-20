@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Neue Prüfung anlegen')}}
@endsection

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row">
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
