@extends('layout.layout-admin')

@section('pagetitle')
    Neuen Mitarbeiter anlegen &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Neuen Mitarbeiter anlegen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('profile.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <x-textfield id="ma_vorname" label="Vorname" />
                        </div>
                        <div class="col-md-4">
                            <x-rtextfield id="ma_name" label="Name" />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ma_name_2" label="2. Name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <x-textfield id="ma_nummer" label="MA Nummer" />
                        </div>
                        <div class="col-md-4">
                            <x-selectfield id="user_id" label='Verknüpftung zu Benutzer</a>'>
                                @foreach(App\User::all() as $user)
                                    <option value="{{ $user->id }}" >
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </x-selectfield>
                        </div>
                        <div class="col-md-3">
                            <x-datepicker id="ma_eingetreten" label="Eingetreten"/>
                        </div>
                        <div class="col-md-3">
                            <x-datepicker id="ma_ausgetreten" label="Ausgetreten" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <x-textfield id="ma_telefon" label="Telefon" />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="ma_mobil" label="Mobil" />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="ma_fax" label="Fax" />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="ma_com_1" label="Com 1" />
                        </div>
                    </div>
                    <x-btnMain>Mitarbeiter anlegen <span class="fas fa-download"></span></x-btnMain>
                </form>
            </div>
        </div>
    </div>

@endsection
