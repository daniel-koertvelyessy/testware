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
    <link id="themeId" rel="stylesheet" href="{{ url('https://bootswatch.com/4/flatly/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.x-git.min.js"></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<main id="app">
    @yield('content')
</main>
<footer class="page-footer fixed-bottom px-1">
    <div class="row align-items-center">
        <div class="col-auto small mr-auto pl-3">© 2020
            <span style="color: #000;">bitpack</span><span style="color: #c7d301;">.io</span>
        </div>

    </div>
</footer>


<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

{{--<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>--}}


@yield('scripts')



</body>
</html>
