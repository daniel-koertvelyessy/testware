@extends('layout.layout-login')

@section('pagetitle')
    {{ __('Bitte anmelden') }}!
@endsection

@section('content')

    <div class=" d-flex justify-content-center align-items-center"
         style="height: 90vh;"
    >

            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h1 class="mb-3"> {{ __('Passwort vergessen') }}</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 d-none d-md-block mb-4">
                                <img src="{{ asset('img/icon/testWare_Logo.svg') }}"
                                     alt="Logo testWare"
                                     class="w-75"
                                >
                            </div>
                            <div class="col-md-8">
                                @if (session()->has('status'))
                                    <div class="alert alert-success" role="alert">
                                        <h2 class="h4">{{ __('Erfolg') }}!</h2>
                                        <p>{!! session()->get('status') !!}</p>

                                        <a href="{{ route('login') }}"  class="alert-link">{{ __('Zurück zur Anmeldung') }}</a>
                                    </div>

                                @else
                                    <p class="lead mb-4">{{ __('Bitte geben Sie die E-Mail Adresse an zu der ein Link mit
                                weiteren Instruktionen gesendet wird.') }}</p>
                                    <form method="POST"
                                          action="{{ route('password.email') }}"
                                    >
                                    @csrf

                                    <!-- Email Address -->
                                        <div>


                                            <x-textfield id="email"
                                                         class="block mt-1 w-full"
                                                         type="email"
                                                         name="email"
                                                         label="{{__('Email')}}"
                                                         :value="old('email')"
                                                         required
                                                         autofocus
                                            />
                                        </div>

                                        <x-btnMain>
                                            {{ __('Link zum Rücksetzen des Passwortes schicken') }}
                                        </x-btnMain>

                                    </form>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
@endsection