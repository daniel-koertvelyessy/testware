@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Neuen Prüfschritt anlegen')}}
@endsection

@section('mainSection')
    {{__('Neuen Prüfschritt anlegen')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row md-4 d-none d-md-block">
            <div class="col">
                <h1 class="h3">{{__('Neuen Prüfschritt anlegen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-addNewAnforderungControlItem :rid="$rid" />
            </div>
        </div>

    </div>

@endsection
