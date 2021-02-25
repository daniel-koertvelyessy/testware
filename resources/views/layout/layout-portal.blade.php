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
          href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}"
          sizes="32x32"
    >
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}"
    >
    <meta name="msapplication-TileColor"
          content="#ffffff"
    >
    <meta name="msapplication-TileImage"
          content="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}"
    >
    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}"
    >
    <link id="themeId"
          rel="stylesheet"
          href="{{ asset('css/flatly.css') }}"
    >
    @auth
        <link id="themeId"
              rel="stylesheet"
              href="{{Auth()->user()->user_theme }}"
        >
    @endauth
    <link rel="stylesheet"
          href="{{ asset('css/styles.css') }}"
    >
    <script type="text/javascript"
            src="{{ asset('js/jquery_3.5.min.js') }}"
    ></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app"
   class="sr-only"
>{{__('Überspringe Navigationsbereich')}}</a>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="{{ asset('img/icon/bitpack_logo.svg') }}"
                     alt="Icon bitpack"
                     height="30px"
                >
            </a>
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#basicExampleNav"
                    aria-controls="basicExampleNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"
                 id="basicExampleNav"
            >
                @yield('navigation')
                <x-accountNav/>
            </div>
        </div>
    </nav>
    @yield('breadcrumbs')
    @if (session()->has('status'))
        <div class="toast fixed-top"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
        >
            <div class="toast-header">
                <img src="{{ url('img/icon/testWareLogo_greenYellow.svg') }}"
                     class="rounded mr-2"
                     height="18px;"
                     alt="Icon der Systemmeldung "
                >
                <strong class="mr-auto">{{__('Systemnachricht')}}</strong>
                <button type="button"
                        class="ml-2 mb-1 close"
                        data-dismiss="toast"
                        aria-label="Close"
                >
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
    {{--    <x-sidebar/>--}}
    @yield('content')
</main>
<x-section-footer/>

<script type="text/javascript"
        src="{{ mix('js/app.js') }}"
></script>
<script type="text/javascript"
        src="{{asset('js/main.js')}}"
></script>
@if (session()->has('status'))
    <script>
        jQuery('.toast').toast('show');
    </script>
@endif

</body>
</html>
