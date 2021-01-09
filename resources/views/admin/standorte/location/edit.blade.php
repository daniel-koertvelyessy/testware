@extends('layout.layout-admin')

@section('pagetitle')
{{__('Standortverwaltung')}}
@endsection

@section('mainSection')
{{__('memStandorte')}}
@endsection

@section('menu')
     @include('menus._menuStandort')
@endsection


@section('content')

    <div class="container mt-2">
        <h1 class="h3">{{__('Standort Stammdaten bearbeiten')}}</h1>
        <div class="row">
            <div class="col">
                <form action="{{ route('location.update',['location'=>$location->id]) }}" method="post">
                    @method('PUT')
                     @csrf
                    <div class="form-group">
                        <label for="l_label">Kurzbezeichnung (max 10 Zeichen)</label>
                        <input type="text" name="l_label" id="l_label" class="form-control {{ $errors->has('l_label') ? ' is-invalid ': '' }}" maxlength="10" value="{{ $location->l_label }}">
                    </div>
                    <div class="form-group">
                        <label for="l_name">Bezeichnung (max 100 Zeichen)</label>
                        <input type="text" name="l_name" id="l_name" class="form-control" maxlength="100" value="{{ $location->l_name ?? '' }}">
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


@section('actionMenuItems')

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="#">Drucke Übersicht</a>
            <a class="dropdown-item" href="#">Standortbericht</a>
            <a class="dropdown-item" href="#">Formularhilfe</a>
        </ul>
    </li>



@endsection()

