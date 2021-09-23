@extends('layout.layout-portal')

@section('pagetitle')
    {{__('testWare')}}
@endsection

@section('navigation')
    @include('menus._menuPortal')
@endsection

@section('content')
    <div class="container mt-sm-5">
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Fehler!</strong> {!! session()->get('error') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif


        <div class="row justify-content-md-center">
            <div class="col">
                <section class="card-body text-dark">
                    <h2 class="h4 text-primary">{{__('Apps')}}</h2>
                    <nav class="tiles-grid">
                        <a href="{{ route('testware.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <div class=" d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/icon/testWare_Logo.svg') }}"
                                     alt="Logo"
                                     class="img-fluid p-1"
                                     style="max-height: 45px; margin-top: 0.8em;"
                                >
                                <span class="branding-bar text-center">testWare</span>
                            </div>
                        </a>
                        <a href="{{ route('app') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                           aria-label="Storage"
                        >
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/icon/InfoSy_Logo_greenYellow.svg') }}"
                                     alt="Logo"
                                     class="img-fluid p-1"
                                     style="max-height: 45px; margin-top: 0.8em;"
                                >
                                <span class="branding-bar text-center">{{__('InfoSy')}}</span>
                            </div>
                        </a>
                        {{--                      <a href="registerphone"
                                                 class="tile-small btn-outline-primary rounded"
                                                 data-role="tile"
                                                 aria-label="Storagee"
                                              >
                                                  <span class="icon"><i class="fas fa-mobile-alt"></i></span> <span class="branding-bar text-center">{{__('Registrieren')}}</span>
                                              </a>--}}
                    </nav>
                </section>

                <section class="card-body text-dark">
                    <h2 class="h4 text-primary">{{__('Einstellungen')}}</h2>
                    <nav class="tiles-grid">
                        <a href="{{ route('storageMain') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                           aria-label="{{__('memStandorte')}}"
                        >
                            <span class="icon"><i class="fa fa-industry"></i></span> <span class="branding-bar text-center">{{__('memStandorte')}}</span>
                        </a>
                        <a href="{{ route('organisationMain') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-users"></i></span> <span class="branding-bar text-center">{{__('Organisation')}}</span>
                        </a>
                        <a href="{{ route('produktMain') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-boxes"></i></span> <span class="branding-bar text-center">{{__('Produkte')}}</span>
                        </a>
                        <a href="{{ route('verordnung.main') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-scroll"></i></span> <span class="branding-bar text-center">{{__('Vorschriften')}}</span>
                        </a>
                        @can('isAdmin',Auth::user())
                        <a href="/admin/"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-user-cog"></i></span> <span class="branding-bar text-center">{{__('Admin')}}</span>
                        </a>
                        @endcan
                        <a href="{{ route('report.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-clipboard"></i></span> <span class="branding-bar text-center">{{__('Berichte')}}</span>
                        </a>

                    </nav>
                </section>


                <div class="tiles-grid">
                    {{--
                                                    <a href="https://mail02.thermo-control.com/webapp/"
                                                       class="tile-small btn-outline-primary rounded"
                                                       data-role="tile"
                                                    >
                                                        <img src="{{ url('img/icon/icon_kopano.svg') }}"
                                                             alt="Logo"
                                                             class="img-fluid p-3"
                                                             style="max-height: 250px;"
                                                        >
                                                        <span class="branding-bar text-center">Webmail</span>
                                                    </a>
                                                    <a href="https://dc01.bln.thermo-control.com/"
                                                       class="tile-small btn-outline-primary rounded"
                                                       data-role="tile"
                                                    >
                                                        <img src="{{ url('img/icon/ucs_logo_gray.svg') }}"
                                                             alt="Logo"
                                                             class="img-fluid p-2"
                                                             style="max-height: 250px;"
                                                        >
                                                        <span class="branding-bar text-center">UCS</span>
                                                    </a>
                                                    <a href="https://dc01.bln.thermo-control.com/nagios"
                                                       class="tile-small btn-outline-primary rounded"
                                                       data-role="tile"
                                                    >
                                                        <img src="{{ url('img/icon/logofullsize.png') }}"
                                                             alt="Logo"
                                                             class="img-fluid p-2 mt-5"
                                                             style="max-height: 250px;"
                                                        >
                                                        <span class="branding-bar text-center">UCS</span>
                                                    </a>
                    --}}

                </div>
            </div>
        </div>
    </div>
@endsection
