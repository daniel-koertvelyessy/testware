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
    <link rel="stylesheet"
          href="{{ asset(mix('css/app.css')) }}"
    >
    <link id="themeId"
          rel="stylesheet"
          href="{{ asset('css/tbs.css') }}"
    >
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
        </a>
        <a href="/"
           class="ml-1 navbar-brand d-lg-none"
           style="border-bottom: 2px solid transparent !important;"
        >
        @yield('mainSection')
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
                        <i class="fas fa-chalkboard"></i> {{__('Portal')}}
                    </a>
                </li>
                @if(isset($edata)||isset($ident))
                    <li class="nav-item {{ (strpos(Request::path(), 'edata')!==false) ? ' active ' : '' }}">
                        <a class="nav-link"
                           href="{{ route('edata',$ident) }}"
                        >
                            <i class="fas fa-box"></i> {{__('Gerät')}}
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos(Request::path(), 'edmg')!==false) ? ' active ' : '' }}">
                        <a class="nav-link"
                           href="{{ route('edmg',$ident) }}"
                        >
                            <i class="fas fa-inbox"></i> {{__('Schaden melden')}}
                        </a>
                    </li>
                @endif
                <li class="nav-item {{ (strpos(Request::path(), 'support')!==false) ? ' active ' : '' }}">
                    <a class="nav-link"
                       href="{{ route('support') }}"
                    >
                        <i class="fas fa-envelope"></i> {{__('Kontakt')}}
                    </a>
                </li>
            </ul>
            <x-accountNav/>
        </div>
    </nav>
</header>
<main id="app">
    @yield('content')
</main>
<x-section-footer/>
<script type="text/javascript"
        src="{{ asset(mix('js/app.js')) }}"
></script>
<script type="text/javascript"
        src="{{ asset('js/main.js') }}"
></script>
@yield('scripts')
</body>
</html>
