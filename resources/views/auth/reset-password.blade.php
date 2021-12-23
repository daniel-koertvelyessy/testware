@extends('layout.layout-login')

@section('pagetitle')
    {{ __('Passwort zurücksetzen') }}!
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
                            <h1 class="mb-3"> {{ __('Neues Passwort vergeben') }}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form method="POST"
                                  action="{{ route('password.update') }}"
                            >
                            @csrf

                            <!-- Password Reset Token -->
                                <input type="hidden"
                                       name="token"
                                       value="{{ $request->route('token') }}"
                                >

                                <!-- Email Address -->
                                <div>
                                    <x-textfield id="email"
                                                 label="{{ __('E-Mail Adresse') }}"
                                             type="email"
                                             :value="old('email', $request->email)"
                                             required
                                             autofocus
                                    />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-textfield id="password"
                                                 label="{{ __('Neues Passwort') }}"
                                             type="password"
                                             name="password"
                                             required
                                    />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4">

                                    <x-textfield id="password_confirmation"
                                             label="{{ __('Neues Passwort bestätigen') }}"
                                             class="block mt-1 w-full"
                                             type="password"
                                             name="password_confirmation"
                                             required
                                    />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-btnMain>
                                        {{ __('Neues Password speichern') }}
                                    </x-btnMain>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
