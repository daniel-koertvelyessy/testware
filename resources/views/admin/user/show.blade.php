@extends('layout.layout-admin')

@section('pagetitle')
{{__('Benutzer')}} &triangleright;   @ bitpack.io GmbH
@endsection

@section('mainSection')
    {{__('Admin')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('Portal')}}</a>
            </li>
            <li class="breadcrumb-item active"
                aria-current="page"
            >{{__('Benutzer')}}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('user.update',$user) }}"
              method="post"
              class="mb-4"
        >
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <h1 class="h3">
                        @if(Auth::user()->id === $user->id)
                            {{__('Mein Konto')}}
                        @else
                            {{__('Übersicht Benutzer')}}
                        @endif
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-rtextfield id="name"
                                  label="{{__('Benutzername')}}"
                                  value="{{ $user->name }}"
                    />
                    <x-emailfield id="email"
                                  label="{{__('E-Mail Adresse')}}"
                                  value="{{ $user->email }}"
                    />
                    <x-textfield id="username"
                                 label="{{__('Anmeldename')}}"
                                 value="{{ $user->username }}"
                    />
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <x-datepicker id="created_at"
                                  label="{{__('Erstellt')}}"
                                  value="{{ $user->created_at }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-datepicker id="updated_at"
                                  label="{{__('Aktualisiert')}}"
                                  value="{{ $user->updated_at }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-datepicker id="deleted_at"
                                  label="{{__('Gelöscht')}}"
                                  value="{{ $user->deleted_at }}"
                    />
                </div>
                <div class="col-md-3">
                    <x-selectfield id="locale"
                                   label="{{__('Sprache einstellen')}}"
                    >
                        @foreach(App\User::LOCALES as $locale => $label)
                            <option value="{{ $locale }}"
                                    @if($user->locale === $locale) selected @endif>{{ $label }}</option>
                        @endforeach
                    </x-selectfield>

                </div>
            </div>

            @if(Auth::user()->id === $user->id)
                <x-btnMain>{{__('Nutzerdaten aktualisieren')}} <span class="fas fa-download ml-2"></span></x-btnMain>
            @endif
        </form>

        <div class="row my-4">
            <div class="col">
                <h2 class="h4">{{__('Token für API Zugang')}}</h2>
                @if(Auth::user()->id === $user->id && $user->api_token!==null)
                    <p>{{ __('Ihr persönlicher API Token lautet') }}</p>
                    <form action="{{ route('addApiTokenToUser',$user) }}"
                          method="post"
                    >
                        @csrf
                        <input type="hidden"
                               name="id"
                               id="{{ $user->id }}"
                        >
                        <label for="token"
                               class="sr-only"
                        >{{__('Ihr aktueller API-Token')}}
                        </label>
                        <div class="input-group">
                            <input id="token"
                                   class="form-control"
                                   value="{{ $user->api_token }}"
                            />
                            <button class="btn btn-outline-primary ml-2"><i class="fas fa-redo-alt"></i></button>
                        </div>
                    </form>
                @else
                    <form action="{{ route('addApiTokenToUser',$user) }}"
                          method="post"
                    >
                        @csrf
                        <input type="hidden"
                               name="id"
                               id="{{ $user->id }}"
                        >
                        <button class="btn btn-primary">{{ __('Token für API erstellen') }}</button>
                    </form>
                @endif
            </div>
        </div>

        <form action="{{ route('updateUserTheme') }}"
              id="frmChangeUserTheme"
              name="frmChangeUserTheme"
              method="POST"
        >
            <div class="row">
                <div class="col-md-8 mb-3">
                    <h2 class="h4">{{__('Darstellung Farben')}}</h2>

                    @csrf
                    @method('PUT')
                    <input type="hidden"
                           name="id"
                           id="frmChangeUserTheme-id"
                           value="{{ Auth::user()->id }}"
                    >
                    <div class="form-group">
                        <label for="systemTheme">{{__('Farbschema auswählen')}}</label>
                        <select name="systemTheme"
                                id="systemTheme"
                                class="custom-select"
                        >
                            <option value="css/sand.css"
                                    data-asset="{{ asset('css/sand.css') }}"
                            >Sandstone
                            </option>
                            <option value="css/minty.css"
                                    data-asset="{{ asset('css/minty.css') }}"
                            >Mint
                            </option>
                            <option value="css/flatly.css"
                                    data-asset="{{ asset('css/flatly.css') }}"
                            >Dunkel blau
                            </option>
                            <option value="css/hero.css"
                                    data-asset="{{ asset('css/hero.css') }}"
                            >Hero blau
                            </option>
                            <option value="css/materia.css"
                                    data-asset="{{ asset('css/materia.css') }}"
                            >Material
                            </option>
                        </select>
                    </div>
                    <button type="button"
                            class="btn btn-secondary btn-block"
                            id="btnChangeDisplayTheme"
                    >{{__('Vorschau')}}</button>

                </div>
                <div class="col-md-4">
                    <h2 class="h4">{{__('Darstellung Eingabemasken')}}</h2>
                    <div class="custom-control custom-switch ml-3">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="setUserDisplaySimpleView"
                               name="setUserDisplaySimpleView"
                        >
                        <label class="custom-control-label"
                               for="setUserDisplaySimpleView"
                        >{{__('Vereinfachte Anzeige von Formularen')}}</label>
                    </div>

                    <div class="custom-control custom-switch ml-3">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="setUserDisplayHelperText"
                               name="setUserDisplayHelperText"
                        >
                        <label class="custom-control-label"
                               for="setUserDisplayHelperText"
                        >{{__('Hilfetexte anzeigen')}}</label>
                    </div>
                </div>
            </div>
            @if(Auth::user()->id === $user->id)
                <x-btnSave>{{__('Einstellungen für Benutzer speichern')}}</x-btnSave>
            @endif
        </form>
        <div class="row mt-5">
            <div class="col">
                <h2 class="h4">{{__('Passwort zurücksetzen')}}</h2>
                <form action="{{ route('user.resetPassword') }}">
                    <x-rtextfield id="newPassword"
                                  label="{{__('Neues Passwort')}}"
                    />
                    @if(Auth::user()->id === $user->id)
                        <x-btnSave>{{__('Passwort setzen')}}</x-btnSave>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#btnChangeDisplayTheme').click(function () {
            const theme = $('#systemTheme :selected').data('asset');
            console.log(theme);
            $('#themeId').attr('href', theme);

        });
    </script>
@endsection
