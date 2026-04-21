<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/testWare_Logo.svg') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/testWare_Logo.svg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/testWare_Logo.svg') }}">

    <script src="{{ asset('js/jquery_3.5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1-12-1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/main.js'])
    <link id="themeId" rel="stylesheet" href="{{ asset('css/tbs.css') }}">
    <title>@yield('pagetitle')</title>
</head>
<body>
<main id="app">
    @yield('content')
</main>
<x-section-footer/>
@yield('scripts')
</body>
</html>
