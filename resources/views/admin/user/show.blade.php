@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Benutzer')}} &triangleright; {{ __('Systemverwaltung') }}@endsection

@section('mainSection')
    {{__('Benutzer')}}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :breadlist="[
        ['name' => __('Systemverwaltung'),'link' => route('systems')],
        ['name' => __('Benutzer'),'link' => '#'],
    ]"
    />
@endsection

@section('modals')
    <x-modals.form_modal modalRoute="{{ route('user.destroy',$user) }}"
                         method="DELETE"
                         modalId="modalDeleteUser"
                         modalType="danger"
                         modalSize="lg"
                         btnSubmit="{{ __('Benutzer endgültig löschen') }}"
                         title="{{ __('Löschung des Benutzers prüfen!') }}"
    >

        <input type="hidden"
               name="id"
               id="id"
               value="{{ $user->id }}"
        >
        <h1 class="text-waring">{{ __('Hinweis zur Löschung') }}</h1>
        <p class="lead">{{ __('Folgende Einträge werden mit der Löschung des Benutzers aus der Datenbank entfernt. Dies kann ohne vorherige Sicherung nicht wiederhergestellt werden!') }}</p>
        <h2 class="h4">{{ __('Mitarbeiter') }}</h2>
        @if($user->profile)
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-danger">{{ $user->profile->fullName() }} ({{
                $user->profile->ma_nummer }})</li>
            </ul>
        @else
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-success">
                    <span class="far mr-2 fa-fw fa-check-circle"></span> {{ __('Keine Verknüpfung gefunden') }}
                </li>
            </ul>
        @endif
        <h2 class="h4 mt-2">{{ __('Prüfschritte') }}</h2>
        @if($user->AnforderungControlItem)
            <ul class="list-group list-unstyled">
                @foreach($user->AnforderungControlItem as $aci)
                    <li class="list-group-item list-group-item-danger d-flex align-items-center justify-content-between">
                        <span>{{ $aci->aci_name }}</span>
                        <a href="{{ route('anforderungcontrolitem.show',$aci) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-secondary"
                        >{{ __('beheben') }} <i class="fa-external-link-alt fa-sm ml-1 fas"></i></a>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-success">
                    <span class="far mr-2 fa-fw fa-check-circle"></span> {{ __('Keine Verknüpfung gefunden') }}
                </li>
            </ul>
        @endif
        <h2 class="h4 mt-2">{{ __('Befähigt an Gerät') }}</h2>
        @if($user->EquipmentQualifiedUser->count() >0)
            <ul class="list-group list-unstyled">
                @foreach($user->hasEquipment as $equ)
                    <li class="list-group-item list-group-item-danger d-flex align-items-center justify-content-between">
                        <span>{{ $equ->equipment?->eq_name }}</span>
                        <a href="{{ route('equipment.show',$equ->equipment) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-secondary"
                        >{{ __('beheben') }} <i class="fa-external-link-alt fa-sm ml-1 fas"></i></a>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-success">
                    <span class="far mr-2 fa-fw fa-check-circle"></span> {{ __('Keine Verknüpfung gefunden') }}
                </li>
            </ul>
        @endif
        <h2 class="h4 mt-2">{{ __('Eingewiesen an Geräte') }}</h2>
        @if($user->instructedOnEquipment->count() >0)
            <ul class="list-group list-unstyled">
                @foreach($user->instructedOnEquipment as $ioe)
                    <li class="list-group-item list-group-item-danger d-flex align-items-center justify-content-between">
                        <span>{{ $ioe->equipment->eq_name }}</span>
                        <a href="{{ route('equipment.show',$ioe->equipment) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-secondary"
                        >{{ __('beheben') }} <i class="fa-external-link-alt fa-sm ml-1 fas"></i></a>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-success">
                    <span class="far mr-2 fa-fw fa-check-circle"></span> {{ __('Keine Verknüpfung gefunden') }}
                </li>
            </ul>
        @endif

        <h2 class="h4 mt-2">{{ __('Benutzerrollen') }}</h2>
        @if($user->roles->count() >0)
            <ul class="list-group list-unstyled">
                @foreach($roles as $roleUser)
                    <li class="list-group-item list-group-item-danger d-flex align-items-center justify-content-between">
                        <span>{{ $roleUser->name }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="list-group list-unstyled">
                <li class="list-group-item list-group-item-success">
                    <span class="far mr-2 fa-fw fa-check-circle"></span> {{ __('Keine Verknüpfung gefunden') }}
                </li>
            </ul>
        @endif

    </x-modals.form_modal>
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
               id="user_id_revoke_sysadmin"
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
               id="user_id_grand_sysadmin"
               value="{{ $user->id }}"
        >
    </x-modals.form_modal>

    <div class="modal fade "
         tabindex="-1"
         role="dialog"
         aria-labelledby="signaturModalLabel"
         aria-hidden="true"
         id="signatureModal"
    >
        <div class="modal-dialog modal-xl"
             role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="signaturModalLabel"
                    >{{__('Unterschrift')}}
                        <span id="sigHead"></span>
                    </h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="wrapper">
                        <canvas id="signatureField"
                                class="signature-pad"
                        ></canvas>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-warning btn-sm"
                            id="btnClearCanvas"
                    >{{__('Neu')}}</button>
                    <button type="button"
                            class="btn btn-outline-primary btn-sm"
                            id="btnSignZuruck"
                    >{{__('Zurück')}}</button>
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            id="btnStoreSignature"
                    >{{__('speichern')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container">
        <form action="{{ route('user.updatedata',$user) }}"
              method="post"
              class="mb-4"
        >
            @csrf
            @method('put')
            <input type="hidden"
                   name="id"
                   id="user_id"
                   value="{{ $user->id }}"
            >
            <div class="row mb-4 d-md-block d-none">
                <div class="col">
                    <h1 class="h3">
                        {{$isCurrentUser ? __('Mein Konto') : __('Übersicht Benutzer') }}
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <x-rtextfield id="name"
                                  label="{{__('Name')}}"
                                  value="{{ $user->name }}"
                                  max="200"
                    />
                </div>
                <div class="col-md-2">
                    <x-textfield id="username"
                                 label="{{__('Anzeigename')}}"
                                 value="{{ $user->username }}"
                    />
                </div>
                <div class="col-md-5">
                    <x-emailfield id="email"
                                  required
                                  class="required"
                                  label="{{__('E-Mail Adresse')}}"
                                  value="{{ $user->email }}"
                                  max="200"
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
                    <label for="deleted_at">{{__('Gelöscht')}}</label>
                    <input type="text"
                           name="deleted_at"
                           id="deleted_at"
                           readonly
                           class="form-control-plaintext"
                           value="{{ $user->deleted_at }}"
                    >
                </div>
                <div class="col-md-3">
                    <x-selectfield id="locales"
                                   label="{{__('Sprache einstellen')}}"
                    >
                        @foreach(App\User::LOCALES as $locale => $label)
                            <option value="{{ $locale }}"
                                    @if($user->locale === $locale) selected @endif>{{ $label }}</option>
                        @endforeach
                    </x-selectfield>

                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-4">
                    <button type="button"
                            class="btn btn-outline-primary btnAddSiganture"
                            data-toggle="modal"
                            data-target="#signatureModal"
                            {{ !$isCurrentUser ? 'disabled' : ''}}
                    ><i class="fas fa-signature"></i> {{__('Unterschrift erfassen')}}</button>
                </div>
                <div class="col-md-8 border rounded-lg p-4">
                    @if($user->signature )
                        <img src="{{ $user->signature }}"
                             class="img-fluid"
                             alt="Unterschriftbild Benutzer"
                             id="imgSignatureUser"
                        >
                    @else
                        <img src=""
                             class="img-fluid d-none"
                             alt="Unterschriftbild Benutzer"
                             id="imgSignatureUser"
                        >
                        <span id="emptySignaturNotice"
                              class="text-muted small text-center"
                        >{{ __('Die Unterschrift ist noch nicht erfasst worden.') }}</span>
                    @endif

                    <input type="hidden"
                           name="signature"
                           id="signature"
                           value="{{ $user->signature }}"
                    >
                </div>
            </div>
            @if($isCurrentUser|| $isSysAdmin)
                <x-btnMain>{{__('Nutzerdaten aktualisieren')}}
                    <span class="fas fa-download ml-2"></span>
                </x-btnMain>
            @endif
            @if($isSysAdmin && Auth::user()->id != $user->id)
                <button type="button"
                        data-toggle="modal"
                        data-target="#modalDeleteUser"
                        class="btn btn-outline-danger"
                >{{ __('Benutzer löschen') }} <i class="fas fa-trash-alt ml-2"></i></button>
            @endif
        </form>

        @if($isSysAdmin)
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
                                       id="user_id_setpassword"
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
                                    <form method="POST"
                                          action="{{ route('user.revokeSysAdmin',$user) }}"
                                    >
                                        @csrf
                                        @method('delete')
                                        <x-btnSave>{{ __('Entziehen') }}</x-btnSave>
                                    </form>
                                @else
                                    <x-btnModal modalid="revokeUserAsSysAdmin">{{ __('Entziehen') }}</x-btnModal>
                                @endif
                            @else
                                <form method="POST"
                                      action="{{ route('user.grantSysAdmin',$user) }}"
                                >
                                    @csrf
                                    <input type="hidden"
                                           name="user_id"
                                           id="user_id_grand_sysadmin"
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

        @if($isCurrentUser|| $isSysAdmin)
            <div class="row my-5">
                <div class="col">
                    <h2 class="h4">{{$isSysAdmin ? __('Passwort setzen') :  __('Passwort ändern')}}</h2>
                    <form method="POST"
                          action="{{ route('user.setPassword') }}"
                    >
                        @method('PUT')
                        @csrf
                        <input type="hidden"
                               name="id"
                               id="set_user_id"
                               value="{{ $user->id }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-textfield id="setpassword"
                                             type="password"
                                             required
                                             label="{{__('Neues Passwort')}}"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-textfield id="setpassword_confirmation"
                                             type="password"
                                             required
                                             label="{{__('Neues Passwort bestätigen')}}"
                                />
                                <span id="passmsg"
                                      class="small text-warning"
                                ></span>
                            </div>

                        </div>
                        <x-btnSave>{{$isSysAdmin ? __('Neues Passwort setzen') : __('Neues Passwort speichern')}}</x-btnSave>
                    </form>
                </div>
            </div>

            <div class="row my-4">
                <div class="col">
                    @if($isCurrentUser&& $user->api_token!==null)
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
                               value="{{ $user->id }}"
                        >
                        <div class="form-group">
                            <label for="systemTheme">{{__('Farbschema auswählen')}}</label>
                            <select name="systemTheme"
                                    id="systemTheme"
                                    class="custom-select"
                            >
                                <option value="css/tbs.css"
                                        data-asset="{{ asset('css/tbs.css') }}"
                                        {{ $user->user_theme=='css/tbs.css'? ' selected ' : '' }}
                                >Twitter Bootstrap
                                </option>
                                <option value="css/flatly.css"
                                        data-asset="{{ asset('css/flatly.css') }}"
                                        {{ $user->user_theme=='css/flatly.css'? ' selected ' : '' }}
                                >Light
                                </option>
                                <option value="css/space.css"
                                        data-asset="{{ asset('css/space.css') }}"
                                        {{ $user->user_theme=='css/space.css'? ' selected ' : '' }}
                                >Space
                                </option>
                                <option value="css/darkmode.css"
                                        data-asset="{{ asset('css/darkmode.css') }}"
                                        {{ $user->user_theme=='css/darkmode.css'? ' selected ' : '' }}
                                >Dark
                                </option>
                                <option value="css/dark.css"
                                        data-asset="{{ asset('css/dark.css') }}"
                                        {{ $user->user_theme=='css/dark.css'? ' selected ' : '' }}
                                >Dark II
                                </option>
                            </select>
                        </div>
                        <button type="button"
                                class="btn btn-secondary btn-block"
                                id="btnChangeDisplayTheme"
                        >{{__('Vorschau')}}</button>

                    </div>
                </div>
                @if($isCurrentUser|| $isSysAdmin)
                    <x-btnSave>{{__('Einstellungen für Benutzer speichern')}}</x-btnSave>
                @endif
            </form>

        @endif

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/signatures.js') }}"></script>
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


        /**
         *   Signatures
         */
        $('.btnAddSiganture').click(function () {
            signaturePad.clear();
        });

        $('#btnStoreSignature').click(function () {
            var data = signaturePad.toDataURL('image/png');
            $('#signature').val(data);
            $('#imgSignatureUser').removeClass('d-none').attr('src', signaturePad.toDataURL());
            $('#emptySignaturNotice').remove();
            $('#signatureModal').modal('hide');

        });

        function resizeCanvas() {
// When zoomed out to less than 100%, for some very strange reason,
// some browsers report devicePixelRatio as less than 1
// and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);

// This part causes the canvas to be cleared
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

// This library does not listen for canvas changes, so after the canvas is automatically
// cleared by the browser, SignaturePad#isEmpty might still return false, even though the
// canvas looks empty, because the internal data of this library wasn't cleared. To make sure
// that the state of this library is consistent with visual state of the canvas, you
// have to clear it manually.
            signaturePad.clear();
        }

        var canvas = document.getElementById('signatureField'),
            signaturePad = new SignaturePad(canvas, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)'
            });

        $('#signatureModal').on('shown.bs.modal', function () {
            resizeCanvas();
        });

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;


        $('#btnClearCanvas').click(function () {
            signaturePad.clear();
        });
        $('#btnSignZuruck').click(function () {
            var data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line\n'+
                signaturePad.fromData(data);
            }
        });


    </script>
@endsection
