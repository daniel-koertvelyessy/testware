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
                            <h1 class="mb-3"> {{ __('Anmeldung') }}</h1>
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
                            @if (session()->has('expired'))
                                <p class="lead">{{ __('Ihre Sitzung ist abgelaufen und Sie wurden abgemeldet.') }}</p>
                            @endif
                            <form method="POST"
                                  action="{{ route('login') }}"
                                  autocomplete="on"
                            >
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Adresse') }}</label>

                                    <input id="email"
                                           type="text"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus
                                           autocomplete="username"
                                    >
                                    @error('email')
                                    <span class="invalid-feedback"
                                          role="alert"
                                    >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="form-group mt-1">
                                    <label for="password">{{ __('Passwort') }}</label>

                                    <input id="password"
                                           type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                    >

                                    @error('password')
                                    <span class="invalid-feedback"
                                          role="alert"
                                    >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="form-group my-3">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input"
                                               type="checkbox"
                                               name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="remember"
                                        >{{ __('Angemeldet bleiben') }}</label>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit"
                                            class="btn btn-primary btn-lg"
                                    >
                                        <i class="fas fa-sign-in-alt"></i> {{ __('Jetzt anmelden') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="bg-light border-top p-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('portal-main') }}"><span class="fas fa-angle-left fa-fw"></span> {{__('zurück zum Portal')}}</a>
                                </div>
                                <div>
                                    {{--
                                   <a class="btn btn-sm btn-link" href="{{ route('register') }}">
                                       <i class="fas fa-pen-alt"></i>  {{ __('Jetzt registrieren!') }}
                                   </a>
                                    --}}
                                   @if (Route::has('password.request'))
                                       <a class="btn btn-sm btn-link" href="{{ route('password.email') }}">
                                           <i class="fas fa-question fa-fw"></i>  {{ __('Passwort vergessen') }}
                                       </a>
                                   @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
