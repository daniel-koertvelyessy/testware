@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#doc-about">About</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Module')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Oktober</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">


            </div>
        </div>
    </div>
@endsection
