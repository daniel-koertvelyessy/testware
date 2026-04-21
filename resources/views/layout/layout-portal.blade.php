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
          href="{{ asset('img/icon/testWare_Logo.svg') }}"
          sizes="32x32"
    >
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="{{ asset('img/icon/testWare_Logo.svg') }}"
    >
    <meta name="msapplication-TileColor"
          content="#ffffff"
    >
    <meta name="msapplication-TileImage"
          content="{{ asset('img/icon/testWare_Logo.svg') }}"
    >
    <script src="{{ asset('js/jquery_3.5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1-12-1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.de.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/main.js'])

    <link id="themeId"
          rel="stylesheet"
          href="{{ asset('css/tbs.css') }}"
    >
    @auth
        <link id="themeId"
              rel="stylesheet"
              href="{{Auth()->user()->user_theme }}"
        >
    @endauth

    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app"
   class="sr-only"
>{{__('Überspringe Navigationsbereich')}}</a>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand"
               style="color:#c7d301;"
            >
                testWare
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
                <img src="{{ url('img/icon/testWare_Logo.svg') }}"
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
@if (session()->has('status'))
    <script>
        $(document).ready(function () {
            jQuery('.toast').toast('show');
        });
    </script>
@endif

</body>
</html>
