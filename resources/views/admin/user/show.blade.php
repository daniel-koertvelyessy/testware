@extends('layout.layout-admin')

@section('pagetitle')
    Benutzer &triangleright;   @ bitpack.io GmbH
@endsection

@section('mainSection')
    Admin
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Benutzer</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('user.update',$user) }}" method="post" class="mb-4">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <h1 class="h3">Übersicht Benutzer</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-rtextfield id="name" label="Benutzername" value="{{ $user->name }}" />
                    <x-emailfield id="email" label="E-Mail Adresse" value="{{ $user->email }}" />
                    <x-textfield id="username" label="Anmeldename" value="{{ $user->username }}" />
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <x-datepicker id="created_at" label="Erstellt" value="{{ $user->created_at }}" />
                </div>
                <div class="col-md-3">
                    <x-datepicker id="updated_at" label="Aktualisiert" value="{{ $user->updated_at }}" />
                </div>
                <div class="col-md-3">
                    <x-datepicker id="deleted_at" label="Gelöscht" value="{{ $user->deleted_at }}" />
                </div>
                <div class="col-md-3">
                    <x-selectfield id="userlocale" label="UI Sprache">
                        <option value="de">de</option>
                        <option value="en">en</option>
                    </x-selectfield>

                </div>
            </div>
            @if(Auth::user()->id === $user->id)
                <x-btnMain>Nutzerdaten aktualisieren <span class="fas fa-download"></span></x-btnMain>
            @endif
        </form>
        <form action="{{ route('updateUserTheme') }}" id="frmChangeUserTheme" name="frmChangeUserTheme" method="POST">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <h2 class="h4">Darstellung Farben</h2>

                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="frmChangeUserTheme-id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="systemTheme">Farbschema auswählen</label>
                        <select name="systemTheme" id="systemTheme" class="custom-select">
                            <option value="https://bootswatch.com/4/yeti/bootstrap.min.css">Yeti</option>
                            <option value="https://bootswatch.com/4/minty/bootstrap.min.css">Mint</option>
                            <option value="https://bootswatch.com/4/flatly/bootstrap.min.css">Dunkel blau</option>
                            <option value="https://bootswatch.com/4/superhero/bootstrap.min.css">Hero blau</option>
                            {{--                                            <option value="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">TBS v5</option>--}}
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary btn-block" id="btnChangeDisplayTheme">Vorschau</button>

                </div>
                <div class="col-md-4">
                    <h2 class="h4">Darstellung Eingabemasken</h2>
                    <div class="custom-control custom-switch ml-3">
                        <input class="custom-control-input" type="checkbox" id="setUserDisplaySimpleView" name="setUserDisplaySimpleView">
                        <label class="custom-control-label" for="setUserDisplaySimpleView">Vereinfachte Anzeige von Formularen</label>
                    </div>

                    <div class="custom-control custom-switch ml-3">
                        <input class="custom-control-input" type="checkbox" id="setUserDisplayHelperText" name="setUserDisplayHelperText">
                        <label class="custom-control-label" for="setUserDisplayHelperText">Hilfetexte anzeigen</label>
                    </div>
                </div>
            </div>
            @if(Auth::user()->id === $user->id)
            <x-btnSave>Einstellungen für Benutzer speichern</x-btnSave>
                @endif
        </form>
        <div class="row mt-5">
            <div class="col">
                <h2 class="h4">Passwort zurücksetzen</h2>
                <form action="{{ route('user.resetPassword') }}">
                    <x-rtextfield id="newPassword" label="Neues Passwort"/>
                    @if(Auth::user()->id === $user->id)
                    <x-btnSave>Passwort setzen</x-btnSave>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#btnChangeDisplayTheme').click(function () {
            const theme = $('#systemTheme :selected').val();
            console.log(theme);
            $('#themeId').attr('href',theme);

        });
    </script>
@endsection
