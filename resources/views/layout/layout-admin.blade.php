<!DOCTYPE html>
<html lang="{{ session('locale') }}">
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
          href="{{ asset(mix('css/app.css')) }}"
    >
    <link id="themeId"
          rel="stylesheet"
          href="{{ asset(Auth::user()->user_theme) }}"
    >
{{--    <link rel="stylesheet"--}}
{{--          href="{{ asset('css/styles.min.css') }}"--}}
{{--    >--}}
    <script type="text/javascript"
            src="{{ asset('js/jquery_3.5.min.js') }}"
    ></script>
    <title>@yield('pagetitle')</title>
</head>
<body>
<a href="#app"
   class="sr-only"
>{{__('Überspringe gesamte Navigation')}}</a>
@auth
    <div style="width: 100vw; height: 100vh; background-color: #d7efb0; position: fixed; z-index: 2500; display: none;"
         id="lockscreen"
         aria-label="Element zum verbergen von Inhalten, wenn der Bildschirm vom Benutzer gesperrt wird"
    ></div>
@endauth
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <span id="sidebarCollapse"
              class="mr-2 m-0"
              style="border-bottom: 4px solid transparent !important; cursor:pointer;"
        >
            <img src="{{ asset('img/icon/toggle_icon.svg') }}"
                 alt="toggle icon sidemenu"
                 height="20"
            >
        </span>
        <a href="/"
           class="ml-1 navbar-brand d-lg-none"
           style="border-bottom: 2px solid transparent !important;"
        >
            {{--            <img src="{{ asset('img/icon/testWareLogo_greenYellow.svg') }}" alt="" height="30px" class="d-md-none">--}}
            @yield('mainSection')
            {{--            <i class="fas fa-angle-right d-none d-md-inline"></i>--}}
        </a>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navLoginLayout"
                aria-controls="navLoginLayout"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse "
             id="navLoginLayout"
        >
            <ul class="navbar-nav mr-auto">
                @yield('menu')
                @yield('actionMenuItems')
            </ul>
            <form class="d-flex ml-2"
                  id="frmSrchInAdminBereich"
                  autocomplete="off"
                  action="{{ route('search.index') }}"
            >
                <input class="form-control mr-2"
                       id="srchTopMenuTerm"
                       name="srchTopMenuTerm"
                       placeholder="{{__('Suche')}}"
                       aria-label="{{__('Suche')}}"
                       autocomplete="off"
                       value="{{ old('srchTopMenuTerm') ?? '' }}"
                >
            </form>
            <x-accountNav/>
        </div>
    </nav>
    @if (session()->has('status'))
        <div class=" fixed-top d-flex justify-content-end ">
            <div class="toast bg-light"
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
                    <p id="toastMessageBody">
                        {!! session()->get('status') !!}
                    </p>
                </div>
            </div>
        </div>

    @endif
    @yield('breadcrumbs')
</header>
<a href="#content"
   class="sr-only"
>{{__('Überspringe Seiten-Navigation')}}</a>
<section id="messageBox">
    <div class="modal fade"
         id="userMsgModal"
         tabindex="-1"
         aria-labelledby="userMsgModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    @forelse(auth()->user()->unreadNotifications()->get() as $notification)
                        <x-message_modal :notification="$notification" :link="route('event.show',$notification->data['eventid'])" />
                    @empty
                        <span class="list-group-item">
                                <x-notifyer>{{__('Keine neuen Nachrichten')}}</x-notifyer>
                            </span>
                    @endforelse
                    <div class="d-flex justify-content-end align-items-center">
                        <form action="{{ route('user.setMsgRead') }}"
                              method="post"
                        >
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
<div class="wrapper">
    <nav id="sidebar"
         class="active border-right border-light"
    >
        <x-sidebar/>
    </nav>
    <main id="app"
          class="mt-2"
          style="flex:1;"
    >
        <a id="content"></a>
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/jquery-ui-1-12-1.min.js') }}"></script>
@yield('autocomplete')
<script>
    $("#srchTopMenuTerm").autocomplete({
        position: {my: "right top", at: "right bottom"},
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
            location.href = ui.item.link;
        }
    });
</script>
<!-- MODALS   -->
<div class="modal fade"
     id="lockUserView"
     style="z-index: 3000;"
     data-backdrop="static"
     data-keyboard="false"
     tabindex="-1"
     aria-labelledby="lockUserViewLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title"
                    id="lockUserViewLabel"
                >{{__('Bildschirm gesperrt')}}</h5>
                <span class="lead">für DEMO PIN 2231</span>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-8">
                        {{__('Bitte geben Sie Ihre PIN ein, um den Bildschirm zu entsperren')}}
                    </div>
                    <div class="form-group col-md-4">
                        <label for="userSeinPIN"
                               class="sr-only"
                        >PIN
                        </label>
                        <input type="password"
                               class="form-control"
                               id="userSeinPIN"
                               placeholder="PIN"
                               autocomplete="off"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('modals')
<!-- MODALS ENDE -->
@if ($errors->any())
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger fixed-bottom alert-dismissible fade show">
                    <p class="lead my-2">{{ __('Fehler') }}</p>
                    <ul class="list-group mb-4">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endif
<x-section-footer/>
@yield('autoloadscripts')

<script type="text/javascript"
        src="{{ asset(mix('js/app.js')) }}"
></script>
<script type="text/javascript"
        src="{{ asset('js/main.js') }}"
></script>

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
