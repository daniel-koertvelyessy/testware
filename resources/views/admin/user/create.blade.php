@extends('layout.layout-admin')

@section('pagetitle')
{{__('Benutzer')}} &triangleright; {{ __('Systemverwaltung') }}
@endsection

@section('mainSection')
    {{__('Neuer Benutzer')}}
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

@endsection

@section('content')
    <div class="container">
        <form action="{{ route('user.store') }}"
              method="post"
              class="mb-4"
        >
            @csrf
            <div class="row mb-4 d-md-block d-none">
                <div class="col">
                    <h1 class="h3">
                        {{__('Neuen Benutzer anlegen')}}
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-emailfield id="email"
                                  label="{{__('E-Mail Adresse')}}"
                                  required
                                  max="200"
                    />

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <x-textfield id="name"
                                 label="{{__('Name')}}"
                                 class="required"
                                 required
                                 max="200"
                    />
                </div>
                <div class="col-md-4">
                    <x-textfield id="username"
                                 label="{{__('Anzeigename')}}"
                    />
                </div>
                <div class="col-md-4">
                    <x-selectfield id="locales"
                                   label="{{ __('Sprache') }}"
                    >
                        @foreach(\App\User::LOCALES as $locale)
                            <option value="{{ \App\User::LANGS[$locale] }}">{{ \App\User::LANGS[$locale] }} - {{ $locale }}</option>
                        @endforeach
                    </x-selectfield>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-textfield id="password"
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
            <x-btnMain>{{__('Benutzer anlegen')}} <span class="fas fa-download ml-2"></span></x-btnMain>

        </form>


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
            if ($(this).val() === $('#password').val()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                passmsg.text('');

            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
                passmsg.text('{{ __('Die Passwörter stimmen nicht überein!') }}');
            }
        });
        $('#email').blur(function () {
            const email = $('#email');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('checkUserEmailAddressExists') }}",
                data: {term:email.val()},
                success: (emailAddress) => {
                    if (emailAddress.exists){
                        email.addClass('is-invalid').removeClass('is-valid');
                    } else{
                        email.removeClass('is-invalid').addClass('is-valid');
                    }

               }
            });
        });
        $('#username').blur(function () {
            const username = $('#username');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('checkUserUserNameExists') }}",
                data: {term:username.val()},
                success: (userName) => {
                    if (userName.exists){
                        username.addClass('is-invalid').removeClass('is-valid');
                    } else{
                        username.removeClass('is-invalid').addClass('is-valid');
                    }

                }
            });
        });

    </script>
@endsection

