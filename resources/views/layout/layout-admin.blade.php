<!DOCTYPE html>
<html lang="{{ session('locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link id="themeId" rel="stylesheet" href="{{ asset(Auth::user()->user_theme) }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery_3.5.min.js') }}"></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app" class="sr-only">{{__('Überspringe gesamte Navigation')}}</a>
<div style="width: 100vw; height: 100vh; background-color: #d7efb0; position: fixed; z-index: 2500; display: none;" id="lockscreen" aria-label="Element zum verbergen von Inhalten, wenn der Bildschirm vom Benutzer gesperrt wird"></div>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="/" class="ml-5 navbar-brand">
            <img src="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" alt="" height="30px" class="d-md-none">
            @yield('mainSection')
            {{--            <i class="fas fa-angle-right d-none d-md-inline"></i>--}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLoginLayout" aria-controls="navLoginLayout" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navLoginLayout">
            <ul class="navbar-nav mr-auto">
                @yield('menu')
                @yield('actionMenuItems')
            </ul>
            <form class="d-flex ml-2" id="frmSrchInAdminBereich" autocomplete="off" action="{{ route('search.index') }}">
                <input class="form-control mr-2" id="srchTopMenuTerm" name="srchTopMenuTerm"  placeholder="{{__('Suche')}}" aria-label="{{__('Suche')}}" autocomplete="off" value="{{ old('srchTopMenuTerm') ?? '' }}">
            </form>
            <x-accountNav/>
        </div>
    </nav>
    @if (session()->has('status'))
        <div class=" fixed-top d-flex justify-content-end d-block" >
            <div class="toast bg-light" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ url('img/icon/testWareLogo_greenYellow.svg') }}" class="rounded mr-2" height="18px;" alt="Icon der Systemmeldung ">
                    <strong class="mr-auto">{{__('Systemnachricht')}}</strong>
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
        </div>

    @endif
    @yield('breadcrumbs')
</header>
<section id="messageBox">
    <div class="modal fade" id="userMsgModal" tabindex="-1" aria-labelledby="userMsgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">

                    @forelse(auth()->user()->unreadNotifications()->get() as $notification)
                        <div class="d-flex border p-2 flex-column"
                             id="msg{{ $notification->id }}"
                        >
                            <div class="d-flex ml-2 justify-content-between small">
                                <span>
                                    {{__('Nachricht')}}:
                                     {{ $notification->type === 'App\Notifications\EquipmentEventChanged' ? 'Änderung Ereignis' : 'Neues Ereignis' }}
                                </span>

                                <span>{{ $notification->created_at->DiffForHumans() }}</span>
                            </div>
                            <div class="d-flex mt-3 ml-2 flex-row align-items-center">
                                <div class="d-flex
                                 flex-column">
                                    <span class="small">{{__('von')}}: {{ $notification->data['userid'] }}</span>
                                    <span class="small">{{__('Nachricht')}}:</span>
                                    <span class="lead"> {{ $notification->data['message'] }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span class="list-group-item">
                                <x-notifyer>{{__('Keine neuen Nachrichten')}}</x-notifyer>
                            </span>
                    @endforelse
                        <div class="d-flex justify-content-end align-items-center">
                            <form action="{{ route('user.setMsgRead') }}"
                                  method="post">
                                @csrf
                                <button class="btn btn-sm btn-link">
                                    {{__('Nachrichten als gelesen markieren')}}
                                </button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<main id="app" class="mt-3 ">
    <a href="#content" class="sr-only">{{__('Überspringe Seiten-Navigation')}}</a>
    <x-sidebar/>
    <a id="content"></a>
    @yield('content')
</main>
@yield('autocomplete')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $("#srchTopMenuTerm").autocomplete({
        position: { my : "right top", at: "right bottom" },
        source: function (request, response) {
            $.ajax({
                url: "{{ route('searchInModules') }}",
                type: 'GET',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {

                    let resp = $.map(data, function (obj) {
                        return {
                            label: obj.label,
                            link: obj.link
                        };
                    });
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            // console.log();
            location.href=ui.item.link;
        }
    });


</script>
<!-- MODALS   -->
<div class="modal fade" id="lockUserView" style="z-index: 3000;" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="lockUserViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lockUserViewLabel">{{__('Bildschirm gesperrt')}}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        {{__('Bitte geben Sie Ihre PIN ein, um den Bildschirm zu entsperren')}}
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
{{--@if (\App\Lizenz::checkNumObjectsOverflow())
    <div class="alert alert-info fixed-bottom  alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Wichiger Hinweis!</h4>
        <p>Sie haben die maximale Anzahl von <strong>{{ env('MAX_OBJEKT') }}</strong> Objekten erreicht, welche mit Ihrem Lizenzpaket angelegt werden können. Sie können das Programm weiter nutzen, aber keine weiteren Objekte anlegen.</p>
        <p>Bitte wenden Sie sich vertrauensvoll an Ihren Ansprechpartner, um Ihre Lizenz zu erweitern.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif--}}
@if ($errors->any())
    <div class="alert alert-danger fixed-bottom alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<footer class="page-footer fixed-bottom px-1">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto small mr-auto pl-3">
            <span>
                © 2020
            <a href="https://bitpack.io/" title="bitpack.io">
                <span style="color: #000;">bitpack</span><span style="color: #c7d301;">.io</span>
            </a>
            &nbsp; GmbH
            </span>

            <span>

            </span>
        </div>
{{--        <x-lizenzbar maxObj="{{ App\Lizenz::getMaxObjects(config('app.lizenzid')) }}" numObj="{{ App\Lizenz::getNumObjekte() }}" />--}}
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
/*    $(document).on('click','.markNoteAsRead',function () {
        const id = $(this).data('id');
        $.ajax({
            type: "post",
            dataType: 'json',
            url: '{{ route('user.setMsgRead') }}',
            data: {id},
            success: (res) => {
                console.debug(res);

            }
        });
        console.log(id);
    });*/
    // $('#lockscreen').hide();
    // $('#sideNav').hide();
    // $('#NavToggler').click(function () {
    //     $('#sideNav').animate({width:'toggle'},350);
    // });
</script>


</body>
</html>
