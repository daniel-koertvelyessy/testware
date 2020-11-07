<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge"
    >
    <link rel="icon"
          type="image/png"
          href="{{ asset('img/icon/InfoSy_Logo_greenYellow.svg') }}"
          sizes="32x32"
    >
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="{{ asset('img/icon/InfoSy_Logo_greenYellow.svg') }}"
    >
    <meta name="msapplication-TileColor"
          content="#ffffff"
    >
    <meta name="msapplication-TileImage"
          content="{{ asset('img/icon/InfoSy_Logo_greenYellow.svg') }}"
    >
    <script src="https://kit.fontawesome.com/b5297e65e8.js"
            crossorigin="anonymous"
    ></script>
    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}"
    >
    <link id="themeId"
          rel="stylesheet"
          href="{{ url('https://bootswatch.com/4/flatly/bootstrap.min.css') }}"
    >
    <link rel="stylesheet"
          href="{{ asset('css/styles.css') }}"
    >
    <script type="text/javascript"
            src="https://code.jquery.com/jquery-3.x-git.min.js"
    ></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand"
           href="#"
        >
            <img src="{{ asset('img/icon/InfoSy_Logo_greenYellow.svg') }}"
                 alt=""
                 height="30px"
            >
            <span class="ml-3 d-md-none">testWare InfoSy</span>
        </a>
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
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('portal-main') }}"
                    >
                        <i class="fas fa-chalkboard"></i> Portal
                    </a>
                </li>
                <li class="nav-item {{ (strpos(Request::path(), 'app')!==false) ? ' active ' : '' }}">
                    <a class="nav-link"
                       href="{{ route('app') }}"
                    >
                        <i class="fas fa-qrcode"></i> Scan
                    </a>
                </li>
                @if(isset($edata)||isset($ident))
                    <li class="nav-item {{ (strpos(Request::path(), 'edata')!==false) ? ' active ' : '' }}">
                        <a class="nav-link"
                           href="{{ route('edata',$ident) }}"
                        >
                            <i class="fas fa-box"></i> Gerät
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos(Request::path(), 'edmg')!==false) ? ' active ' : '' }}">
                        <a class="nav-link"
                           href="{{ route('edmg',$ident) }}"
                        >
                            <i class="fas fa-inbox"></i> Schaden melden
                        </a>
                    </li>
                @endif
                <li class="nav-item {{ (strpos(Request::path(), 'support')!==false) ? ' active ' : '' }}">
                    <a class="nav-link"
                       href="{{ route('support') }}"
                    >
                        <i class="fas fa-envelope"></i> Kontakt
                    </a>
                </li>
                @auth
                    <x-accountNav/>
                @endauth
            </ul>
        </div>
    </nav>
</header>
<main id="app"
      class="pt-3"
>
    @yield('content')
</main>
<footer class="page-footer fixed-bottom px-1">
    <div class="row align-items-center">
        <div class="col-auto small mr-auto pl-3">© 2020 <span style="color: #000;">bitpack</span><span style="color: #c7d301;">.io</span>
        </div>

    </div>
</footer>


<script type="text/javascript"
        src="{{ mix('js/app.js') }}"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js"
        integrity="sha512-3V4cUR2MLZNeqi+4bPuXnotN7VESQC2ynlNH/fUljXZiQk1BGowTqO5O2gElABNMIXzzpYg5d8DxNoXKlM210w=="
        crossorigin="anonymous"
></script>
<script type="text/javascript"
        src="{{ asset('js/main.js') }}"
></script>


@yield('scripts')


</body>
</html>
