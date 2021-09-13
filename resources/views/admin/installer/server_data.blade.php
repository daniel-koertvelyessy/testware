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
                    <a class="nav-link"
                       href="{{ route('installer.user') }}"
                    >{{ __('Benutzer') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('installer.company') }}"
                    >{{ __('Firmierung') }} </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled"
                       href="#"
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

    <form action=""
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
                                         value="{{ env('APP_URL') }}"
                            />
                        </div>
                        <div class="col-md-2">
                            <x-textfield id="APP_PORT"
                                         label="{{ __('Port') }}"
                                         required
                                         class="required"
                                         max="5"
                                         value="{{ env('APP_PORT') }}"
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
                    <h2 class="h4">{{__('E-Mail Server konfigurieren')}}</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="MAIL_HOST"
                                         label="{{ __('Host') }}"
                                         required
                                         class="required"
                                         max="100"
                                         value="{{ env('MAIL_HOST') }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-textfield id="MAIL_PORT"
                                         label="{{ __('Port') }}"
                                         required
                                         class="required"
                                         max="10"
                                         value="{{ env('MAIL_PORT') }}"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-selectfield id="MAIL_ENCRYPTION"
                                           label="{{ __('Verschlüsselung') }}"
                                           required
                                           class="required"
                                           value="{{ env('MAIL_ENCRYPTION') }}"

                            >
                                <option value="" {{ env('MAIL_ENCRYPTION')==='' ? ' selected ': '' }}>{{ __('ohne') }}</option>
                                <option value="ssl" {{ env('MAIL_ENCRYPTION')==='ssl' ? ' selected ': '' }}>ssl</option>
                                <option value="tls" {{ env('MAIL_ENCRYPTION')==='tls' ? ' selected ': '' }}>tls</option>
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
                                         max="10"
                                         value="{{ env('MAIL_USERNAME') }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield type="password"
                                         id="MAIL_PASSWORD"
                                         label="{{ __('Passwort') }}"
                                         required
                                         class="required"
                                         max="10"
                                         value="{{ $smtpdata['MAIL_PASSWORD'] }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-textfield id="MAIL_FROM_NAME"
                                         label="{{ __('Angezeiger Name der System E-Mails') }}"
                                         value="{{ env('MAIL_FROM_NAME') }}"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-textfield id="MAIL_FROM_ADDRESS"
                                         label="{{ __('E-Mail Adresse der Systememails') }}"
                                         value="{{ env('MAIL_FROM_ADDRESS') }}"
                            />

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-btnSave>{{ __('E-Mail Server speichern') }}</x-btnSave>
                            <button class="btn btn-outline-secondary ml-2" id="sendTestEmail">{{ __('Testmail versenden') }}</button>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')


@endsection
