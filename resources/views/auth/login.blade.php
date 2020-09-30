@extends('layout.layout-login')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center" style="height: 90vh;">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="d-flex justify-content-between px-3 py-2">
                        <h1 class="h5 mb-3">
                            <i class="fas fa-lock"></i> {{ __('Anmeldung') }}
                        </h1>
                        <img src="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" height="30" alt="">
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Addresse') }}</label>

                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group mt-1">
                                <label for="password">{{ __('Passwort') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Angemeldet bleiben') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Anmelden') }}
                                </button>


                            </div>

                        </form>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-link" href="{{ route('register') }}">
                            <i class="fas fa-pen-alt"></i>  {{ __('Jetzt registrieren!') }}
                        </a>
                        @if (Route::has('password.request'))
                            <a class="btn btn-sm btn-link" href="{{ route('password.request') }}">
                                <i class="fas fa-question"></i>  {{ __('Passwort vergessen?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
