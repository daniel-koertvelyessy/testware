<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/testWareLogo_FAV_Grey.svg') }}">
    <script src="https://kit.fontawesome.com/b5297e65e8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @auth
        <link id="themeId" rel="stylesheet" href="{{ Auth::user()->user_theme }}">
    @else
        <link id="themeId" rel="stylesheet" href="{{ url('https://bootswatch.com/4/yeti/bootstrap.min.css') }}">
    @endauth
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.x-git.min.js"></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
       <div class="navbar-brand">
        <button id="NavToggler" type="button" class="btn btn-sm border mr-2">
            <i class="fas fa-bars"></i>
        </button>
        <a href="/">
            <img src="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" alt="" height="30px">
            @yield('mainSection')
            <i class="fas fa-angle-right d-none d-md-inline"></i>
        </a>
       </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLoginLayout" aria-controls="navLoginLayout" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navLoginLayout">
            <ul class="navbar-nav mr-auto">
                @yield('menu')
                @yield('actionMenuItems')
            </ul>

            <form class="d-flex ml-2" id="frmSrchInAdminBereich">
                <input class="form-control mr-2 srchInAdminBereich" id="srchInAdminBereich" name="srchInAdminBereich"  placeholder="Suche" aria-label="Suche" autocomplete="off">
            </form>
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item {{ Request::routeIs('firma')  ? ' active ' : '' }} dropdown dropleft">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserAccount" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user"></i> {{ Auth::user()->username ?? Auth::user()->name }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarUserAccount">
                            <li>
                                <a class="dropdown-item" href="/support"><i class="fas fa-phone-square"></i> Hilfe anfordern</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="/"><i class="fas fa-desktop"></i> Portal</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="fas fa-inbox"></i> Nachrichten <span class="badge badge-light ">0</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#lockUserView"><i class="fas fa-user-lock"></i> Bildschrim sperren</a>
                            </li>
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                ><i class="fas fa-sign-out-alt"></i> Abmelden </a>
                            </li>
                        </ul>


                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
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
<aside class="col-2 position-absolute border bg-primary p-3" style="border-top-right-radius: 1rem; border-bottom-right-radius: 0.6rem ;z-index: 3000; height: 90vh;" id="sideNav" aria-expanded="false">
    <p class="h3  text-white">Menü</p>
   <div class="flex-column">
    <a href="#collapseExample" class="lead text-white "data-toggle="collapse"  role="button" aria-expanded="true" aria-controls="collapseExample">Standorte</a>
    <div class="collapse show" id="collapseExample">
    <nav class="nav">
        <a class="nav-link ml-4 border-left" href="#">Standorte</a>
        <a class="nav-link ml-4 border-left" href="#">Übersicht</a>
        <a class="nav-link ml-4 border-left" href="#">neu</a>
        <a class="nav-link ml-4 border-left" href="#">Gebäude</a>
        <a class="nav-link ml-4 border-left" href="#">Räume</a>
        <a class="nav-link ml-4 border-left" href="#">Stellplätze</a>
    </nav>
    </div>
   </div>
    <div class="flex-column">
    <a href="#Organisation" class="lead text-white "data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="Organisation">Organisation</a>
    <div class="collapse" id="Organisation">
        <nav class="nav">
            <a class="nav-link ml-4 border-left" href="#">Standorte</a>
            <a class="nav-link ml-4 border-left" href="#">Übersicht</a>
            <a class="nav-link ml-4 border-left" href="#">neu</a>
            <a class="nav-link ml-4 border-left" href="#">Gebäude</a>
            <a class="nav-link ml-4 border-left" href="#">Räume</a>
            <a class="nav-link ml-4 border-left" href="#">Stellplätze</a>
        </nav>
    </div>
    </div>

</aside>
<main id="app" class="mt-3">
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
<!-- MODALS ENDE -->
<footer class="page-footer fixed-bottom bg-light px-1">
    <div class="row align-items-center">
        <div class="col-auto small mr-auto pl-3">© 2020 Copyright:
            <a href="https://bitpack.io" target="_blank"> bitpack GmbH</a>
        </div>
        <div class="col-auto">
            <span class="text-muted small">layout-login V1.9</span>
        </div>
    </div>
</footer>
@yield('autoloadscripts')

{{--<script type="text/javascript"  src="{{ asset('plugins/typehead/dist/jquery.typeahead.min.js') }}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>--}}
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js" integrity="sha512-3V4cUR2MLZNeqi+4bPuXnotN7VESQC2ynlNH/fUljXZiQk1BGowTqO5O2gElABNMIXzzpYg5d8DxNoXKlM210w==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

@if (session()->has('status'))
    <script>
        jQuery('.toast').toast('show');
    </script>
@endif

@yield('scripts')
<script>
    $('#sideNav').hide();
    $('#NavToggler').click(function () {
        $('#sideNav').animate({width:'toggle'},350);
    });
</script>


</body>
</html>
