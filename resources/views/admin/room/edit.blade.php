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
    <div class="container mt-2">
        <h1 class="h3">Standort Stammdaten bearbeiten</h1>
        <div class="row">
            <div class="col">
                <form action="{{ route('location.update',['location'=>$location->id]) }}" method="post">
                    @method('PUT')
                     @csrf
                    <div class="form-group">
                        <label for="l_name_kurz">Kurzbezeichnung (max 10 Zeichen)</label>
                        <input type="text" name="l_name_kurz" id="l_name_kurz" class="form-control {{ $errors->has('l_name_kurz') ? ' is-invalid ': '' }}" maxlength="10" value="{{ $location->l_name_kurz }}">
                    </div>
                    <div class="form-group">
                        <label for="l_name_lang">Bezeichnung (max 100 Zeichen)</label>
                        <input type="text" name="l_name_lang" id="l_name_lang" class="form-control" maxlength="100" value="{{ $location->l_name_lang ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="l_beschreibung">Beschreibung</label>
                        <textarea name="l_beschreibung" id="l_beschreibung" class="form-control" rows="3">{{ $location->l_beschreibung ?? '' }}</textarea>
                    </div>
                    <button class="btn btn-primary btn-block"><i class="far fa-save"></i> Standort speichern</button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('locationActionMenuItems')

    <a class="dropdown-item" href="#">Drucke Übersicht</a>
    <a class="dropdown-item" href="#">Standortbericht</a>
    <a class="dropdown-item" href="#">Formularhilfe</a>

@endsection()

