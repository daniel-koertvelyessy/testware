@extends('layout.layout-admin')

@section('pagetitle')
{{__('Neu anlegen')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection


@section('content')
    <div class="container mt-2">
        <h1 class="h3">{{__('Neuen Standort anlegen')}}</h1>
        <form action="{{ route('location.store') }}" method="post" class="needs-validation">
            @csrf
            <input type="hidden"
                   name="standort_id"
                   id="standort_id"
                   value="{{ Str::uuid() }}"
            >
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        @if (App\Adresse::count() === 0)
                            <label for="adresse_id">Keine Adressen gefunden!</label>
                            <input type="hidden" name="adresse_id" id="adresse_id">
                            <a href="{{ route('adresse.create') }}" class="btn btn-outline-primary btn-block">neue Adresse anlegen</a>
                        @else
                            <label for="adresse_id">Die Adresse des Standortes festlegen</label>
                            <select class="custom-select" aria-label="Default select example" name="adresse_id" id="adresse_id">
                                @foreach (App\Adresse::all() as $addItem)
                                    <option value="{{$addItem->id}}">{{ $addItem->ad_name_kurz  }} - {{ $addItem->ad_anschrift_strasse }}</option>
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
                            <a href="{{ route('profile.create') }}" class="btn btn-outline-primary btn-block">neuen Mitarbeiter anlegen</a>
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
                    <x-rtextfield id="l_name_kurz" label="Kürzel" />
                    <x-textfield id="l_name_lang" label="Bezeichnung" />
                    <x-textarea id="l_beschreibung" label="Beschreibung" />

                </div>
            </div>
            <x-btnMain>Standort anlegen <span class="ml-3 fas fa-download"></span></x-btnMain>
            {{--    @if (!env('app.makeobjekte') )        @else
                <x-btnMainDisabled>Standort anlegen <span class="ml-2 fas fa-download"></span></x-btnMainDisabled>
            @endif--}}
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

