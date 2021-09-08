<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <link id="themeId" rel="stylesheet" href="{{ asset('css/flatly.css') }}">
    <title>@yield('pagetitle')</title>
</head>
<body>
<main id="app">
    @yield('content')
</main>
<x-section-footer/>
<script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@yield('scripts')
</body>
</html>
