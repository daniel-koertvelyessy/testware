@extends('layout.layout-admin')

@section('pagetitle')
{{__('Benutzer')}} &triangleright; {{ __('Systemverwaltung') }}
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

@section('modals')
    <x-modals.form_modal modalRoute="{{ route('user.revokeSysAdmin',$user) }}"
                         method="DELETE"
                         modalId="revokeUserAsSysAdmin"
                         modalType="danger"
                         title="{{ __('Systemwarnung!') }}"
    >
        <h1 class="text-danger">{{__('Achtung!')}}</h1>
        <div class="lead">
            <p>{{__('Es sind keine weiteren SysAdmin im System gesetzt. Wenn Sie sich die SysAdmin-Rechte entziehen, kann das System nicht mehr vollständig gepflegt werden.')}}</p>
            <p>{{__('Ebenso können <strong>keine</strong> weiteren Benutzer mit SysAdmin-Rechten versehen werden.')}}</p>
        </div>
        @csrf
        <label for="confirmRevokeSysAdmin">{{ __('Ich habe verstanden und möchte mir trotzdem die SysAdmin-Rechte entziehen!') }}</label>
        <input type="checkbox"
               name="confirmRevokeSysAdmin"
               id="confirmRevokeSysAdmin"
               value="1"
               required
        >
        <input type="hidden"
               name="user_id"
               id="user_id"
               value="{{ $user->id }}"
        >
    </x-modals.form_modal>

    <x-modals.form_modal modalRoute="{{ route('user.grantSysAdmin',$user) }}"
                         method="DELETE"
                         modalId="grantUserAsSysAdmin"
                         modalType="danger"
    >

        @csrf
        <input type="hidden"
               name="user_id"
               id="user_id"
               value="{{ $user->id }}"
        >
    </x-modals.form_modal>

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
            @if(Auth::user()->id === $user->id || Auth::user()->isSysAdmin())
                <x-btnMain>{{__('Nutzerdaten aktualisieren')}} <span class="fas fa-download ml-2"></span></x-btnMain>
            @endif
        </form>

        {{--
        Set Userpassword
        --}}
        @if(Auth::user()->isSysAdmin())
            <div class="row my-5">
                <div class="col">
                    <h2 class="h4">{{__('Benutzerrollen ändern')}}</h2>
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <form method="POST"
                                  action="{{ route('user.grantrole') }}"
                            >
                                @csrf
                                <input type="hidden"
                                       name="user_id"
                                       id="user_id"
                                       value="{{ $user->id }}"
                                >
                                @foreach($roles as $role)
                                    <input type="hidden"
                                           id="roleuser_{{ $role->id }}"
                                           name="roleuser[]"
                                           value="{{ $role->id }}"
                                    >
                                @endforeach
                                <x-selectfield id="setUserRole"
                                               name="roleuser[]"
                                               label="{{ __('Rolle hinzufügen') }}"
                                >
                                    @foreach(\App\Role::all() as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }} </option>
                                    @endforeach
                                </x-selectfield>
                                <x-btnMain>{{ __('Hinzufügen') }}</x-btnMain>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <h3 class="h5">{{ __('Zugeordnete Rollen') }}</h3>
                            @foreach($roles as $role)
                                <x-userroletile :role="$role"
                                                :user="$user"
                                >{{ $role->name }}</x-userroletile>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <h3 class="h5">{{ __('SysAdmin') }}</h3>
                            @if($user->isSysAdmin())
                                <i class="fas fa-user-shield fa-3x mb-2"></i>
                                @if(\App\User::where('role_id','1')->count()>1)
                                    <form method="POST" action="{{ route('user.revokeSysAdmin',$user) }}">
                                        @csrf
                                        @method('delete')
                                        <x-btnSave>{{ __('Entziehen') }}</x-btnSave>
                                    </form>
                                @else
                                <x-btnModal modalid="revokeUserAsSysAdmin">{{ __('Entziehen') }}</x-btnModal>
                                @endif
                            @else
                                <form method="POST" action="{{ route('user.grantSysAdmin',$user) }}">
                                    @csrf
                                    <input type="hidden"
                                           name="user_id"
                                           id="user_id"
                                           value="{{ $user->id }}"
                                    >
                                    <x-btnSave>{{ __('Status setzen') }}</x-btnSave>
                                </form>

                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endif

        @if(Auth::user()->id === $user->id || Auth::user()->isSysAdmin())
            <div class="row my-5">
                <div class="col">
                    <h2 class="h4">{{__('Passwort ändern')}}</h2>
                    <form method="POST"
                          action="{{ route('user.resetPassword') }}"
                    >
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="newPassword"
                                             type="password"
                                             required
                                             label="{{__('Neues Passwort')}}"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="confirmPassword"
                                             type="password"
                                             required
                                             label="{{__('Neues Passwort bestätigen')}}"
                                />
                                <span id="passmsg"
                                      class="small text-warning"
                                ></span>
                            </div>

                        </div>

                        <x-btnSave>{{__('Passwort setzen')}}</x-btnSave>

                        {{--
                        $2y$10$QTYenoYuRpR6Kp5e2UjidOZ8xRDlxnQjtdxFed/ecvfSzE3UVezna
                        --}}
                    </form>
                </div>
            </div>

            <div class="row my-4">
                <div class="col">
                    @if(Auth::user()->id === $user->id && $user->api_token!==null)
                        <h2 class="h4">{{__('Token für API Zugang')}}</h2>
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
                        @can('isAdmin', Auth()->user())
                            <h2 class="h4">{{__('Token für API Zugang')}}</h2>
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
                        @endcan
                    @endif
                </div>
            </div>

            <form action="{{ route('updateUserTheme') }}"
                  id="frmChangeUserTheme"
                  name="frmChangeUserTheme"
                  method="POST"
            >
                <div class="row">
                    <div class="col mb-3">
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
                               {{-- <option value="css/sand.css"
                                        data-asset="{{ asset('css/sand.css') }}"
                                        {{ $user->user_theme=='css/sand.css'? ' selected ' : '' }}
                                >Sandstone
                                </option>
                                <option value="css/minty.css"
                                        data-asset="{{ asset('css/minty.css') }}"
                                        {{ $user->user_theme=='css/minty.css'? ' selected ' : '' }}
                                >Mint
                                </option>--}}
                                <option value="css/flatly.css"
                                        data-asset="{{ asset('css/flatly.css') }}"
                                        {{ $user->user_theme=='css/flatly.css'? ' selected ' : '' }}
                                >Light
                                </option>
                                <option value="css/hero.css"
                                        data-asset="{{ asset('css/hero.css') }}"
                                        {{ $user->user_theme=='css/hero.css'? ' selected ' : '' }}
                                >Dark
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
                    {{--
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
                    --}}
                </div>
                @if(Auth::user()->id === $user->id)
                    <x-btnSave>{{__('Einstellungen für Benutzer speichern')}}</x-btnSave>
                @endif
            </form>

        @endif
    </div>

@endsection

@section('scripts')
    <script>
        $('#btnChangeDisplayTheme').click(function () {
            const theme = $('#systemTheme :selected').data('asset');
            $('#themeId').attr('href', theme);
        });

        $(document).on('blur', '#confirmPassword', function () {
            const passmsg = $('#passmsg');
            if ($(this).val() === $('#newPassword').val()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                passmsg.text('');

            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
                passmsg.text('{{ __('Die Passwörter stimmen nicht überein!') }}');
            }
        });


    </script>
@endsection
