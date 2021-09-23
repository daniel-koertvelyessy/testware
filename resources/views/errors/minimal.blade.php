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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link id="themeId" rel="stylesheet" href="{{ asset('css/tbs.css') }}">
{{--    <meta http-equiv="refresh" content="3; {{ route('portal-main') }}">--}}
    <title>@yield('title')</title>
</head>
<body>
<main id="app" class="d-flex justify-content-center align-items-center" style="height: 90vh;">
    <section class="container">
        <div class="row shadow p-4 border rounded">
            <div class="col-md-3 d-flex justify-content-center flex-column align-items-center">
                <img src="{{ asset('img/icon/testWare_Logo.svg') }}" alt="Logo testWare" style="max-height: 150px;">
                <p class="h3 text-muted">{{ __('Fehler ') }} @yield('code')</p>
            </div>
            <div class="col-md-6">
                <p class="mb-5">@yield('message')</p>
                <div class="mt-5">
                    @yield('buttons')
                </div>
            </div>
        </div>
    </section>
</main>
<footer class="page-footer fixed-bottom px-1">
    <div class="row align-items-center">
        <div class="col-auto small mr-auto pl-3">© 2020
            <span style="color: #000;">bitpack</span><span style="color: #c7d301;">.io</span>
        </div>
    </div>
</footer>


<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js" integrity="sha512-3V4cUR2MLZNeqi+4bPuXnotN7VESQC2ynlNH/fUljXZiQk1BGowTqO5O2gElABNMIXzzpYg5d8DxNoXKlM210w==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
</body>
</html>
