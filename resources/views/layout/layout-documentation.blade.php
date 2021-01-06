<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>@yield('pagetitle')</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />

    <!-- Favicon -->
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

    <script type="text/javascript"
            src="{{ asset('js/jquery_3.5.min.js') }}"
    ></script>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}"
    />
    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/jquery-ui/themes/base/jquery-ui.min.css') }}"
    />
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/prism/prism.css') }}"
    />

    <!-- CSS Template -->
    <link rel="stylesheet"
          href="{{ asset('assets/css/theme.css') }}"
    />{{-- --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/layout.css') }}"
    />

</head>
<body class="bg-white">
<!-- Header -->
<header class="duik-header">
    <nav
        class="navbar navbar-expand-md fixed-top bg-white border-bottom text-dark py-2"
    >
        <a class="link-dark mr-lg-7 mr-0 mr-md-5"
           href="/docs/"
        >
            <img
                class="mr-1"
                src="{{ url('img/icon/testWareLogo_greenYellow.svg') }}"
                alt="Docs UI Kit"
                style="width: 30px;"
            />
            <span class="small">{{ __('Dokumentation') }}
                <span class="badge badge-dark text-space-1">v0.9.3</span>
            </span>
        </a>

        <!-- Header Links -->
        <ul class="navbar-nav align-items-md-center ml-md-auto">
            <li class="nav-item mx-md-1 mx-lg-2">
                <a
                    class="nav-link link-dark small"
                    href="{{ route('portal-main') }}"
                    target="_blank"
                >
                    <i class="fa fa-desktop"></i> {{ __('zurück zum Portal') }}
                </a>
            </li>
        </ul>
    </nav>
</header>
<!-- End Header -->

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav
            class="col-md-3 col-lg-2 duik-sidebar border-md-right navbar-expand-md"
        >
            <div class="d-flex justify-content-between mb-3">
                <!-- Sidebar Search -->
{{--                <form class="col form-inline input-group-sm pt-2">
                    <label for="searchfield" class="sr-only">Suche in Dokumentation</label>
                    <input id="searchfield"
                        class="js-search form-control form-control-sm w-100"
                        type="text"
                        placeholder="{{__('Suche')}}..."
                        data-url="{{asset('assets/include/json/autocomplete-data-for-documentation-search.json')}}"
                    />
                </form>--}}
                <!-- End Sidebar Search -->

                <!-- Responsive Toggle Button -->
                <button
                    class="btn btn-link pl-0 d-md-none"
                    type="button"
                    data-toggle="collapse"
                    data-target="#sidebar-nav"
                    aria-controls="sidebar-nav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewbox="0 0 30 30"
                        width="30"
                        height="30"
                        focusable="false"
                    >
                        <path
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-miterlimit="10"
                            d="M4 7h22M4 15h22M4 23h22"
                        />
                    </svg>
                </button>
                <!-- End Responsive Toggle Button -->
            </div>

            <!-- Sidebar Nav -->
            <div
                class="collapse navbar-collapse border-bottom border-md-0"
                id="sidebar-nav"
            >
                <div class="js-scrollbar duik-sidebar-sticky">
                    <h5 class="duik-sidebar__heading">{{__('Einführung')}}</h5>
                    <ul class="duik-sidebar__nav">
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.start') ? ' active ' : '' }}"
                               href="{{ route('docs.start') }}"
                            >Übersicht
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('systems') ? ' active ' : '' }}"
                               href="#"
                            >Module
                            </a>
                        </li>
                    </ul>

                    <h5 class="duik-sidebar__heading">{{__('Verwaltung')}}</h5>
                    <ul class="duik-sidebar__nav">
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.backend.locations') ? ' active ' : '' }}"
                               href="{{ route('docs.backend.locations') }}"
                            >{{ __('memStandorte') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.backend.organization') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Organisation') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.backend.products') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Produkte') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.backend.reports') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Berichte') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.backend.admin') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Admin') }}
                            </a>
                        </li>
                    </ul>
                    <h5 class="duik-sidebar__heading">{{__('testWare')}}</h5>
                    <ul class="duik-sidebar__nav">
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.testware.index') ? ' active ' : '' }}"
                               href="{{ route('docs.testware.index') }}"
                            >{{ __('Übersicht') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.testware.testing') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Prüfungen') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.testware.equipment') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Geräte') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.testware.requirements') ? ' active ' : '' }}"
                               href="#"
                            >{{ __('Verordnungen') }}
                            </a>
                        </li>

                    </ul>
                    <h5 class="duik-sidebar__heading">{{__('API V1')}}</h5>
                    <ul class="duik-sidebar__nav">
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.api.index') ? ' active ' : '' }}"
                               href="{{ route('docs.api.index') }}"
                            >{{ __('Einführung') }}
                            </a>
                        </li>
                        <li class="duik-sidebar__item">
                            <a class="duik-sidebar__link {{ Request::routeIs('docs.api.endpoints') ? ' active ' : '' }}"
                               href="{{ route('docs.api.endpoints') }}"
                            >{{ __('Endpunkte') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Sidebar Nav -->
        </nav>
        <!-- End Sidebar -->

        <main class="ml-sm-auto col-md-9 col-lg-10 px-4 pt-0 pt-md-11">
            <div class="row pt-1">
                <!-- Content Nav -->
                <div class="col-xl-2 order-xl-2 d-none d-xl-inline-block">
                    <ul class="js-scroll-nav duik-content-nav">
                        @yield('doc-right-nav')
                    </ul>
                </div>
                <!-- End Content Nav -->

                <!-- Content -->
                <div class="col-xl-10 order-xl-1 duik-content border-bottom">
                    @yield('content')
                </div>
                <!-- End Content -->
            </div>

            <!-- Footer -->
            <footer class="small py-4">
                <div class="row">
                    <!-- Copyright -->
                    <div
                        class="col-md-6 text-center text-dark text-md-left mb-3 mb-md-0"
                    >

                        <a class="text-dark"
                           href="https://htmlstream.com"
                        >
                            {{ __('Template by') }}
                            <img
                                class="mr-1"
                                src="{{asset('assets/img/logo-dark.png')}}"
                                alt="Docs UI Kit"
                                style="width: 80px"
                            />
                            <span class="small">
            <span class="badge badge-dark text-space-1">v1.0.0</span>
          </span>
                        </a>

                    </div>
                    <!-- End Copyright -->
                </div>
            </footer>
            <!-- End Footer -->
        </main>
    </div>
</div>

<!-- Go to Top -->
<a class="js-go-to duik-go-to"
   href="javascript:;"
>
    <span class="fas fa-arrow-up duik-go-to__inner"></span>
</a>
<!-- End Go to Top -->

<!-- JS Global Compulsory -->
<script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('assets/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
<script src="{{ asset('assets/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- JS Implementing Plugins -->
<script src="{{ asset('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.core.min.js')}}"></script>
<script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/menu.js')}}"></script>
<script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/mouse.js')}}"></script>
<script src="{{ asset('assets/vendor/jquery-ui/ui/widgets/autocomplete.js')}}"></script>
<script src="{{ asset('assets/vendor/prism/prism.js')}}"></script>

<!-- JS -->
<script src="{{ asset('assets/js/main.js')}}"></script>
<script src="{{ asset('assets/js/autocomplete.js')}}"></script>
<script src="{{ asset('assets/js/custom-scrollbar.js')}}"></script>
</body>
</html>
