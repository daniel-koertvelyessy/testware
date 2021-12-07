@extends('layout.layout-login')

@section('pagetitle')
{{__('Benutzer')}} &triangleright; {{__('Installation')}} &triangleright; testWare
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand"
           href="#"
        >{{ __('Installation') }}</a>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
             id="navbarSupportedContent"
        >
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.server') }}"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('Server') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link disabled"
                       href="{{ route('installer.user') }}"
                    >{{ __('Benutzer') }}<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="{{ route('installer.company') }}"
                    >{{ __('Firmierung') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="{{ route('installer.location') }}"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('memStandort') }}</a>
                </li>
            </ul>
            <div class="navbar-nav">
                <a class="btn btn-sm btn-outline-warning"
                   href="{{ route('portal-main') }}"
                >{{ __('Abbruch') }}</a>

                <a class="btn btn-sm btn-outline-primary ml-2"
                   href="{{ route('installer.server') }}"
                >{{ __('zurück') }}</a>

                <a class="btn btn-sm btn-primary"
                   href="{{ route('installer.company') }}"
                >{{ __('weiter') }}</a>
            </div>
        </div>
    </nav>

    <form method="POST"
          action="{{ route('installer.system') }}"
          id="frmSetuserData"
    >
        @csrf
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-7">
                    <h2 class="h4">{{__('Benutzer')}}</h2>
                    <input type="hidden"
                           name="user_id"
                           id="user_id"
                    >
                    <x-textfield id="name"
                                 label="{{ __('Name') }}"
                                 required
                                 class="required"
                                 max="100"
                    />
                    <x-textfield id="email"
                                 label="{{ __('E-Mail') }}"
                                 required
                                 class="required"
                                 max="100"
                    />

                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="username"
                                         label="{{ __('Benutzername') }}"
                                         max="100"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="role_id"
                                           label="{{ __('Rolle') }}"
                            >
                                @foreach(App\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach

                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @php($pw = App\User::makePassword())
                            <x-textfield id="password"
                                         required
                                         label="{{ __('Passwort') }}"
                                         value="{{ $pw }}"
                                         class="required"
                            />
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sendInvitation" name="sendInvitation" checked>
                                <label class="custom-control-label" for="sendInvitation">{{ __('Benutzer einladen') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-selectfield id="locale"
                                           name="locales"
                                           label="{{ __('Sprache') }}"
                            >
                                <option value="de">{{ __('German') }}</option>
                                <option value="en">{{ __('English') }}</option>
                                <option value="nl">{{ __('Nederlands') }}</option>
                                <option value="th">{{ __('Tailand') }}</option>
                                <option value="fr">{{ __('French') }}</option>
                            </x-selectfield>

                        </div>
                    </div>

                    <div class="dropdown-divider"></div>
                    <h2 class="h4">{{__('Mitarbeiter')}}</h2>
                    <input type="hidden"
                           name="profile_id"
                           id="profile_id"
                           value="{{ $profile->id??'' }}"
                    >
                    <input type="hidden"
                           name="user_id"
                           id="profile_user_id"
                           value=""
                    >
                    <div class="row">
                        <div class="col-md-3">
                            <x-textfield id="ma_nummer"
                                         label="{{ __('MA Nummer') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ma_vorname"
                                         label="{{ __('Vorname') }}"
                            />
                        </div>
                        <div class="col-md-5">
                            <x-textfield id="ma_name"
                                         label="{{ __('Nachname') }}"
                            />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <x-datepicker id="ma_geburtsdatum"
                                          label="{{ __('Geburtstag') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-datepicker id="ma_eingetreten"
                                          label="{{ __('Eingetreten') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="ma_telefon"
                                         label="{{ __('Telefon') }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="reset"
                                    id="btnResetuserForms"
                                    class="btn btn-outline-primary mr-2"
                            >{{ __('Neu') }} <i class="far fa-file ml-2"></i></button>
                            <button type="button"
                                    id="btnStoreUserData"
                                    class="btn btn-outline-primary mr-2"
                            >{{ __('Daten speichern') }} <i class="fas fa-save ml-2"></i></button>
                        </div>
                    </div>


                </div>
                <div class="col-md-5">
                    <h2 class="h4">{{__('Erfasst')}}</h2>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Benutzer</th>
                            <th>Rolle</th>
                            <th><abbr title="{{ __('Ist der Benutzer ein Mitarbeiter') }}">{{ __('MA') }}</abbr></th>
                            <th><abbr title="{{ __('Ist der Benutzer ein SuperAdmin') }}">SU</abbr></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="userList">
                        @foreach(App\User::with('profile')->get() as $user)
                            <tr id="userListItem{{ $user->id }}">
                                <td>{{ $user->username }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td>
                                    @if($user->profile)
                                        <span class="fas fa-check"></span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role_id === 1)
                                        <span class="fas fa-check"></span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary btnEditUser"
                                            data-userid="{{ $user->id }}"
                                    ><span class="fas fa-edit"></span></button>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary btnRemoveUser"
                                            data-userid="{{ $user->id }}"
                                    ><span class="far fa-trash-alt"></span></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')

    <script>

        $('#btnResetuserForms').click(function () {
            $('#user_id, #profile_id, #profile_user_id').val('');
            $('#password').val('21$User@testWare');
        })

        $('#btnStoreUserData').click(function () {
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "{{ route('installer.storeuserData') }}",
                data: $('#frmSetuserData').serialize(),
                success: (res) => {
                    $('#userList').append(res.html)
                }
            });
        })

        $(document).on('click', '.btnEditUser', function () {
            const id = $(this).data('userid');

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('installer.getUserData') }}",
                data: {id},
                success: function (res) {
                    /**
                     *   fill user data
                     */
                    $('#user_id').val(id);
                    $('#name').val(res.user.name);
                    $('#email').val(res.user.email);
                    $('#username').val(res.user.username);
                    $('#role_id').val(res.user.role_id);
                    $('#locale').val(res.user.locale);
                    /**
                     * Fill employe/profile data
                     */
                    $('#profile_id').val(res.profile.id);
                    $('#profile_user_id').val(id);
                    $('#ma_nummer').val(res.profile.ma_nummer);
                    $('#ma_vorname').val(res.profile.ma_vorname);
                    $('#ma_name').val(res.profile.ma_name);
                    $('#ma_geburtsdatum').val(res.profile.ma_geburtsdatum);
                    $('#ma_eingetreten').val(res.profile.ma_eingetreten);
                    $('#ma_telefon').val(res.profile.ma_telefon);
                }
            });

        })

        $(document).on('click', '.btnRemoveUser', function () {
            const id = $(this).data('userid');
            const _token = $('[name="_token"]').val();
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "{{ route('installer.deleteUserData') }}",
                data: {id, _token},
                success: function (res) {
                    if (res.employee && res.user) {
                        $('#userListItem' + id).remove();
                    }
                }
            });
        });

        $(document).on('blur', '#email', function () {
            if ($('#user_id').val().length === 0) {
                const mail = $('#email');
                const email = mail.val();
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('installer.checkemail') }}",
                    data: {email},
                    success: function (res) {
                        if (res) {
                            mail.addClass('is-invalid').removeClass('is-valid');
                            mail.after(`
                       <span class="small text-danger" id="msgEmailError">Die E-Mail wird bereits verwendet!</span>
                       `);
                        } else {
                            mail.removeClass('is-invalid').addClass('is-valid');
                            $('#msgEmailError').remove();
                        }
                    }
                });
            }
        });

        $(document).on('blur', '#name', function () {
            if ($('#user_id').val().length === 0) {
                const nameNode = $('#name');
                const name = nameNode.val();
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('installer.checkname') }}",
                    data: {name},
                    success: function (res) {
                        if (res) {
                            nameNode.addClass('is-invalid').removeClass('is-valid');
                            nameNode.after(`
                       <span class="small text-danger" id="msgNameError">Der Name wird bereits verwendet!</span>
                       `);
                        } else {
                            nameNode.removeClass('is-invalid').addClass('is-valid');
                            $('#msgNameError').remove();
                        }
                    }
                });
            }
        });

        $(document).on('blur', '#username', function () {
            if ($('#user_id').val().length === 0) {
                const usernameNode = $('#username');
                const username = usernameNode.val();
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: "{{ route('installer.checkusername') }}",
                    data: {username},
                    success: function (res) {
                        if (res) {
                            usernameNode.addClass('is-invalid').removeClass('is-valid');
                            usernameNode.after(`
                       <span class="small text-danger" id="msgUserNameError">Der Benutzername wird bereits verwendet!</span>
                       `);
                        } else {
                            usernameNode.removeClass('is-invalid').addClass('is-valid');
                            $('#msgUserNameError').remove();
                        }
                    }
                });
            }
        });

    </script>

@endsection
