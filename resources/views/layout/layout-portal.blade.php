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
    <script src="https://kit.fontawesome.com/b5297e65e8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="css/styles.css">
    @auth
        <link id="themeId" rel="stylesheet" href="{{ Auth::user()->user_theme }}">
    @else
        <link id="themeId" rel="stylesheet" href="{{ url('https://bootswatch.com/4/minty/bootstrap.min.css') }}">
    @endauth
    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app" class="sr-only">Überspringe Navigationsbereich</a>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="{{ url('img/icon/testWareLogo_greenYellow.svg') }}"  alt="Icon bitpack" height="30px" >
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @yield('navigation')
        </div>
    </nav>
    @yield('breadcrumbs')
    @if (session()->has('status'))
        <div class="toast fixed-top" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ url('img/icon/testWareLogo_greenYellow.svg') }}" class="rounded mr-2" height="18px;" alt="Icon der Systemmeldung ">
                <strong class="mr-auto">Systemnachricht</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <p>
                    {{ session()->get('status') }}
                </p>
            </div>
        </div>
    @endif
</header>

<main id="app">
    @yield('content')
</main>

@auth
    <footer class="page-footer fixed-bottom bg-light px-1 border-top">
        <div class="row align-items-center">
            <div class="col-auto small mr-auto pl-3">
                <span class="d-none d-md-inline" >© 2020 Copyright:</span>
                <a href="https://bitpack.io" target="_blank"> bitpack.io GmbH</a>
                <span class="text-muted d-none d-md-inline">layout-login V1.4</span>
            </div>
            <div class="col-auto">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ Auth::user()->username ?? Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
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

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@else
    <footer class="page-footer fixed-bottom bg-light px-1">
        <div class="row align-items-center">
            <div class="col-auto small mr-auto pl-3">© 2020 Copyright:
                <a href="https://bitpack.io" target="_blank"> bitpack GmbH</a>
            </div>
            <div class="col-auto">
                <span class="text-muted small">layout-login V1.4</span>
            </div>
        </div>
    </footer>
@endauth
<script type="text/javascript" src="https://code.jquery.com/jquery-3.x-git.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
{{-- <script type="text/javascript" src="{{ url('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/main.js"></script>
@if (session()->has('status'))
    <script>
        jQuery('.toast').toast('show');
    </script>
@endif

</body>
</html>
