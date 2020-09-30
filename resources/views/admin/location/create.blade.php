@extends('layout.layout-admin')

@section('pagetitle')
    Neu anlegen &triangleright; Standortverwaltung @ bitpack.io GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection


@section('content')
    <div class="container mt-2">
        <h1 class="h3">Neuen Standort anlegen</h1>
        <form action="{{ route('location.store') }}" method="post" class="needs-validation">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        @if (App\Address::all()->count() === 0)
                            <label for="addresses_id">Keine Adressen gefunden!</label>
                            <input type="hidden" name="addresses_id" id="addresses_id">
                            <a href="#" class="btn btn-outline-primary btn-block">neue Adresse anlegen</a>
                        @else
                            <label for="addresses_id">Die Adresse des Standortes festlegen</label>
                            <select class="custom-select" aria-label="Default select example" name="addresses_id" id="addresses_id">
                                @foreach (App\Address::all() as $addItem)
                                    <option value="{{$addItem->id}}">{{ $addItem->ad_name_lang }}</option>
                                @endforeach
                            </select>
                        @endif

                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        @if (App\Profile::all()->count() === 0)
                            <label for="profile_id">Keine Mitarbeiter gefunden!</label>
                            <input type="hidden" name="profile_id" id="profile_id">
                            <a href="#" class="btn btn-outline-primary btn-block">neuen Mitarbeiter anlegen</a>
                        @else
                            <label for="profile_id">Leitung des Standortes hat</label>
                            <select class="custom-select" aria-label="Default select example" name="profile_id" id="profile_id">
                                @foreach (App\Profile::all() as $profileItem)
                                    <option value="{{$profileItem->id}}">{{ $profileItem->ma_name }}, {{ $profileItem->ma_vorname }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="l_name_kurz">Kurzbezeichnung</label>
                        <input type="text" name="l_name_kurz" id="l_name_kurz" class="form-control @error('l_name_kurz') ' is-invalid ' @enderror()" value="{{ old('l_name_kurz')??'' }}">
                        @if ($errors->has('l_name_kurz'))
                            <span class="text-danger small">{{ $errors->first('l_name_kurz') }}</span>
                        @else
                            <span class="small text-primary">max 20 Zeichen, erforderliches Feld</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="l_name_lang">Bezeichnung</label>
                        <input type="text" name="l_name_lang" id="l_name_lang" class="form-control" maxlength="100"  value="{{ old('l_name_lang')??'' }}">
                        @if ($errors->has('l_name_lang'))
                            <span class="text-danger small">{{ $errors->first('l_name_lang') }}</span>
                        @else
                            <span class="small text-primary">max 100 Zeichen</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="l_beschreibung">Beschreibung</label>
                        <textarea name="l_beschreibung" id="l_beschreibung" class="form-control" rows="3">{{ old('l_beschreibung') }}</textarea>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary btn-block">Standort anlegen</button>
        </form>
    </div>

@endsection


@section('actionMenuItems')
{{--    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i> Aktionen </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item" href="#">Drucke Übersicht</a>
            <a class="dropdown-item" href="#">Standortbericht</a>
            <a class="dropdown-item" href="#">Formularhilfe</a>
        </ul>--}}
@endsection()

