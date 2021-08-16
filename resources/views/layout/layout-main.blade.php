<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
        <link id="themeId" rel="stylesheet" href="{{ Auth::user()->user_theme }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">

    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app" class="sr-only">Überspringe Navigationsbereich</a>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" alt="" height="30px" >
                @yield('mainSection')
                <i class="fas fa-angle-right"></i>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLoginLayout" aria-controls="navLoginLayout" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navLoginLayout">
                <ul class="navbar-nav mr-auto">
                    @yield('menu')
                    @yield('actionMenuItems')
                </ul>
                <x-accountNav/>
            </div>
        </div>
    </nav>
    @if (session()->has('status'))
        <div class="toast fixed-top bg-light" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ url('img/icon/testWareLogo_FAV_Grey.svg') }}" class="rounded mr-2" height="18px;" alt="Icon der Systemmeldung ">
                <strong class="mr-auto">Systemnachricht</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <p id="toastMessageBody">
                    {!! session()->get('status') !!}
                </p>
            </div>
        </div>
    @endif
    @yield('breadcrumbs')
</header>
<main id="app" class="mt-4">
    @yield('content')
</main>
@yield('autocomplete')
<!-- MODALS   -->
<div class="modal fade" id="lockUserView"  data-keyboard="false" tabindex="-1" aria-labelledby="lockUserViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lockUserViewLabel">Bildschirm gesperrt</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        Bitte geben Sie Ihre PIN ein, um den Bildschirm zu entsperren
                    </div>
                    <div class="form-group col-md-4">
                        <label for="userSeinPIN" class="sr-only">PIN</label>
                        <input type="password" class="form-control" id="userSeinPIN" placeholder="PIN">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('modals')
@if ($errors->any())
    <div class="alert alert-danger fixed-bottom ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<footer class="page-footer fixed-bottom px-1">
    <div class="row align-items-center">
        <div class="col-auto small mr-auto pl-3">© 2020 :
            <a href="https://bitpack.io/" title="bitpack.io">
                <span style="color: #000;">bitpack</span><span style="color: #c7d301;">.io</span>
            </a>
            GmbH
        </div>
    </div>
</footer>
@yield('autoloadscripts')
{{--<script type="text/javascript"  src="{{ asset('plugins/typehead/dist/jquery.typeahead.min.js') }}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>--}}
<script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js" integrity="sha512-3V4cUR2MLZNeqi+4bPuXnotN7VESQC2ynlNH/fUljXZiQk1BGowTqO5O2gElABNMIXzzpYg5d8DxNoXKlM210w==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

@if (session()->has('status'))
    <script>
        jQuery('.toast').toast('show');
    </script>
@endif
@yield('scripts')
</body>
</html>
