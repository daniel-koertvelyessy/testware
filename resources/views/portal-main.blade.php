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
            <div class="alert alert-danger alert-dismissible fade show"
                 role="alert"
            >
                <strong>Fehler!</strong> {!! session()->get('error') !!}
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="row justify-content-md-center">
            <div class="col">
                <section class="mb-2 mb-md-4">
                    <h2 class="h4">{{__('testWare')}}</h2>
                    <nav class="tiles-grid">
                        <a href="{{ route('dashboard') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <div class=" d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/icon/testWare_Logo.svg') }}"
                                     alt="Logo"
                                     class="img-fluid p-1"
                                     style="max-height: 45px; margin-top: 0.8em;"
                                >
                                <span class="branding-bar text-center">Dashboard
                                    @if(!Auth::user())
                                        <i class="fas fa-lock"></i>
                                    @endif
                                </span>
                            </div>
                        </a>
                        <a href="{{ route('docs.start') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                           aria-label="Storage"
                        >
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-book fa-2x"
                                   style="max-height: 45px; margin-top: 0.8em;"
                                ></i>
                                <span class="branding-bar text-center">{{__('Dokumentation')}}</span>
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
                @if(Auth::user())
                    <section class="mb-2 mb-md-4">
                        <h2 class="h4">{{__('Verwaltung')}}</h2>
                        <nav class="tiles-grid"
                             style="grid-template-columns: 32% 32% 32%;"
                        >
                            <a href="{{ route('storageMain') }}"
                               class="tile-small btn-outline-primary rounded"
                               data-role="tile"
                               aria-label="{{__('memStandorte')}}"
                            >
                                <span class="icon"><i class="fa fa-industry"></i></span>
                                <span class="branding-bar text-center">{{__('memStandorte')}}</span>
                            </a>
                            <a href="{{ route('organisationMain') }}"
                               class="tile-small btn-outline-primary rounded"
                               data-role="tile"
                            >
                                <span class="icon"><i class="fas fa-users"></i></span>
                                <span class="branding-bar text-center">{{__('Organisation')}}</span>
                            </a>
                            <a href="{{ route('produktMain') }}"
                               class="tile-small btn-outline-primary rounded"
                               data-role="tile"
                            >
                                <span class="icon"><i class="fas fa-boxes"></i></span>
                                <span class="branding-bar text-center">{{__('Produkte')}}</span>
                            </a>
                            <a href="{{ route('verordnung.main') }}"
                               class="tile-small btn-outline-primary rounded"
                               data-role="tile"
                            >
                                <span class="icon"><i class="fas fa-scroll"></i></span>
                                <span class="branding-bar text-center">{{__('Vorschriften')}}</span>
                            </a>
                            <a href="{{ route('report.index') }}"
                               class="tile-small btn-outline-primary rounded"
                               data-role="tile"
                            >
                                <span class="icon"><i class="far fa-clipboard"></i></span>
                                <span class="branding-bar text-center">{{__('Berichte')}}</span>
                            </a>

                        </nav>
                    </section>
                    @can('isAdmin',Auth::user())
                    <section class="mb-2 mb-md-4">
                        <h2 class="h4">{{__('System')}}</h2>
                        <nav class="tiles-grid"
                             style="grid-template-columns: 32% 32% 32%;"
                        >

                                <a href="/admin/"
                                   class="tile-small btn-outline-primary rounded"
                                   data-role="tile"
                                >
                                    <span class="icon"><i class="fas fa-check-square"></i></span>
                                    <span class="branding-bar text-center">{{__('Systemstatus')}}</span>
                                </a>

                                <a href="{{ route('user.index') }}"
                                   class="tile-small btn-outline-primary rounded"
                                   data-role="tile"
                                >
                                    <span class="icon"><i class="fas fa-cogs"></i></span>
                                    <span class="branding-bar text-center">{{__('Einstellungen')}}</span>
                                </a>

                                <a href="{{ route('user.index') }}"
                                   class="tile-small btn-outline-primary rounded"
                                   data-role="tile"
                                >
                                    <span class="icon"><i class="fas fa-user-cog"></i></span>
                                    <span class="branding-bar text-center">{{__('Benutzer')}}</span>
                                </a>

                        </nav>
                    </section>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
