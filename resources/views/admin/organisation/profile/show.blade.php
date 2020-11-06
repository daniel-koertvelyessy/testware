@extends('layout.layout-admin')

@section('pagetitle')
    Profil {{ $profile->fa_name_kurz }} &triangleright; Organisation @ bitpack GmbH
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
                <h1 class="h3">Mitarbeiter bearbeiten</h1>
            </div>
        </div>
        <form action="{{ route('profile.update',['profile'=>$profile]) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="id"
                   value="{{ $profile->id??(old('id')??'') }}"
            >
            <div class="row">
                <div class="col-md-4">
                    <x-textfield id="ma_vorname" label="Vorname" value="{{ $profile->ma_vorname }}"/>
                </div>
                <div class="col-md-4">
                    <x-rtextfield id="ma_name" label="Name" value="{{ $profile->ma_name }}"/>
                </div>
                <div class="col-md-4">
                    <x-textfield id="ma_name_2" label="2. Name" value="{{ $profile->ma_name_2 }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <x-textfield id="ma_nummer" label="MA Nummer" value="{{ $profile->ma_nummer }}"/>
                </div>
                <div class="col-md-4">
                    <x-selectfield id="adresse_id" label='Verknüpfter <a href="/user/{{ $profile->user->id }}">System Benutzer</a>'>
                        @foreach(App\User::all() as $user)
                            <option value="{{ $user->id }}"
                                    @if($user->id === $profile->user_id) selected @endif >
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </x-selectfield>
                </div>
                <div class="col-md-3">
                    <x-datepicker id="ma_eingetreten" label="Eingetreten" value="{{ $profile->ma_eingetreten }}"/>
                </div>
                <div class="col-md-3">
                    <x-datepicker id="ma_ausgetreten" label="Ausgetreten" value="{{ $profile->ma_ausgetreten }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-textfield id="ma_telefon" label="Telefon" value="{{ $profile->ma_telefon }}"/>
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_mobil" label="Mobil" value="{{ $profile->ma_mobil }}"/>
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_fax" label="Fax" value="{{ $profile->ma_fax }}"/>
                </div>
                <div class="col-md-3">
                    <x-textfield id="ma_com_1" label="Com 1" value="{{ $profile->ma_com_1 }}"/>
                </div>
            </div>

            <x-btnMain>Mitarbeiter speichern <span class="fas fa-download"></span></x-btnMain>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener ("keydown", function (zEvent) {

            if ( zEvent.altKey  &&  zEvent.key === "s") {  // case sensitive
                document.forms[0].submit()
            }
            if ( zEvent.altKey  &&  zEvent.key === "n") {  // case sensitive
                location.href = "{{ route('profile.create') }}"

            }
        } );


    </script>
@endsection
