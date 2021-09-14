@extends('layout.layout-login')

@section('pagetitle')
{{__('Server')}} &triangleright; {{__('Installation')}} &triangleright; testWare
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
                <li class="nav-item active">
                    <a class="nav-link disabled"
                       href="{{ route('installer.server') }}"
                       tabindex="-1"
                       aria-disabled="true"
                    >{{ __('Server') }}<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="{{ route('installer.user') }}"
                    >{{ __('Benutzer') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="{{ route('installer.company') }}"
                    >{{ __('Firmierung') }} </a>
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
                   href="{{ route('installer.company') }}"
                >{{ __('Abbruch') }}</a>
                <a class="btn btn-sm btn-primary ml-2"
                   href="{{ route('installer.location') }}"
                >{{ __('weiter') }}</a>
            </div>
        </div>
    </nav>

    <form action="{{ route('installer.setAppUrl') }}"
          method="POST"
    >
        @csrf
        <div class="container">
            <div class="row my-3">
                <div class="col">
                    <h2 class="h4">{{__('Server URL konfigurieren')}}</h2>
                    <p>{{ __('Die Server wird zur Generierung von Links aus der testWare heras benötigt, beispielsweise der Link in den QR-Codes der Geräte.') }}</p>
                    <div class="row">
                        <div class="col-md-10">
                            <x-textfield id="APP_URL"
                                         label="{{ __('URL') }}"
                                         required
                                         class="required"
                                         max="100"
                                         value="{{ $env_app['APP_URL'] }}"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="APP_PORT"
                                         type="number"
                                         label="{{ __('Port') }}"
                                         required
                                         class="required"
                                         max="5"
                                         value="{{ $env_app['APP_PORT'] }}"
                            />
                        </div>
                    </div>
                    <x-btnSave>{{ __('Server URL setzen') }}</x-btnSave>
                </div>
            </div>
        </div>
    </form>

    <form method="POST"
          action="{{ route('email.setserver') }}"
          id="frmSetEmailServer"
    >
        @csrf
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <h2 class="h4">{{__('SMTP Server konfigurieren')}}</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="MAIL_HOST"
                                         label="{{ __('Host') }}"
                                         required
                                         class="required"
                                         max="100"
                                         value="{{ $env_smtp['MAIL_HOST'] }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="MAIL_PORT"
                                         label="{{ __('Port') }}"
                                         required
                                         class="required"
                                         max="10"
                                         value="{{ $env_smtp['MAIL_PORT'] }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-selectfield id="MAIL_ENCRYPTION"
                                           label="{{ __('Verschlüsselung') }}"
                                           required
                                           class="required"
                                           value="{{ $env_smtp['MAIL_ENCRYPTION'] }}"

                            >
                                <option value="" {{ $env_smtp['MAIL_ENCRYPTION']==='' ? ' selected ': '' }}>{{ __('ohne') }}</option>
                                <option value="ssl" {{ $env_smtp['MAIL_ENCRYPTION']==='ssl' ? ' selected ': '' }}>ssl</option>
                                <option value="tls" {{ $env_smtp['MAIL_ENCRYPTION']==='tls' ? ' selected ': '' }}>tls</option>
                            </x-selectfield>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="MAIL_USERNAME"
                                         label="{{ __('Benutzername') }}"
                                         max="100"
                                         required
                                         class="required"
                                         max="100"
                                         value="{{ $env_smtp['MAIL_USERNAME'] }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield type="password"
                                         id="MAIL_PASSWORD"
                                         label="{{ __('Passwort') }}"
                                         required
                                         class="required"
                                         max="100"
                                         value="{{ $env_smtp['MAIL_PASSWORD'] }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="MAIL_FROM_NAME"
                                         label="{{ __('Angezeiger Name der System E-Mails') }}"
                                         value="{{ $env_smtp['MAIL_FROM_NAME'] }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="MAIL_FROM_ADDRESS"
                                         label="{{ __('E-Mail Adresse der Systememails') }}"
                                         value="{{ $env_smtp['MAIL_FROM_ADDRESS'] }}"
                            />

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <x-btnSave>{{ __('SMTP Server speichern') }}</x-btnSave>
                            <button type="button"
                                    class="btn btn-outline-secondary ml-md-2 mr-2 mr-md-4"
                                    id="sendTestEmail"
                            >{{ __('Verbindung prüfen') }}</button>
                        </div>
                        <div class="col-md-7">
                            <div id="testMailSpinner" class="d-none align-items-center">
                                <div class="fa-2x text-muted mr-2 mr-md-4">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                                <span class="lead">{{ __('Prüfe Verbindung zu SMPT Server '. env('MAIL_HOST') . ':'.env('MAIL_PORT')) }}</span>
                            </div>
                            <div id="testMailSucess" class="d-none">
                                <i class="fas fa-check text-success fa-2x mr-2 mr-md-4"></i>
                                <span class="lead">{{ __('Erfolg') }}</span>
                            </div>
                            <div id="testMailFail" class="d-none">
                                <i class="fas fa-times text-warning fa-2x mr-2 mr-md-4"></i>
                                <div class="d-flex flex-column">
                                    <span class="lead">{{ __('Fehler') }}</span>
                                    <span id="testMailFailText"></span>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')


    <script>
        $('#sendTestEmail').click(function () {
            const testMailSpinner = $('#testMailSpinner');
            testMailSpinner.removeClass('d-none').addClass('d-flex');
            $('#testMailSucess').addClass('d-none');
            $('#testMailFail').addClass('d-none');

            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('email.test') }}",
                data: {},
                success: function (res) {

                    testMailSpinner.removeClass('d-flex').addClass('d-none');
                    if (res.status){
                        $('#testMailSucess').removeClass('d-none').addClass('d-flex');
                    } else if(res.error) {
                        $('#testMailFailText').text(res.error);
                        $('#testMailFail').removeClass('d-none').addClass('d-flex');
                    } else {
                        $('#testMailFailText').text('{{ __('Da ist was schief gegangen. Bitte den Support benachrichtigen. Danke!') }}');
                        $('#testMailFail').removeClass('d-none').addClass('d-flex');
                    }
                }
            });
        });
    </script>
@endsection
