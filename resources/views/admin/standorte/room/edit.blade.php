@extends('layout.layout-admin')

@section('pagetitle')
    Standortverwaltung | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Standort
@endsection

@section('menu')
     @include('menus._menuStandort')
@endsection


@section('content')
    {{-- `user_id``adress_id``l_beschreibung``l_name_lang``l_name_kurz``l_benutzt`--}}


@endsection


@section('locationActionMenuItems')


@endsection()

