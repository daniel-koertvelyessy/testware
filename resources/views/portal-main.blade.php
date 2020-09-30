@extends('layout.layout-portal')

@section('pagetitle')
    Willkommen @ bitpack GmbH
@endsection

@section('navigation')
    @include('menus._menuPortal')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8 mt-5">
                <div class="accordion card active" id="portalAuswahl">

                        <div id="headingTwo" class="border-bottom bg-primary text-light">
                            <h2 class="mb-0">
                                <button class="btn btn-primary btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#sectionAdminApps" aria-expanded="false" aria-controls="sectionAdminApps">
                                    Verwaltung
                                </button>
                            </h2>
                        </div>
                        <div id="sectionAdminApps" class="collapse" aria-labelledby="headingTwo" data-parent="#portalAuswahl">
                            <section class="card-body text-dark">
                                <nav class="tiles-grid justify-content-center">
                                    <a href="/location" class="tile-medium rounded" data-role="tile" aria-label="Standorte">
                                        <span class="icon"><i class="fas fa-industry"></i></span>
                                        <span class="branding-bar text-center">Standorte</span>
                                    </a>
                                    <a href="/organisation/" class="tile-medium rounded" data-role="tile">
                                        <span class="icon"><i class="fas fa-users"></i></span>
                                        <span class="branding-bar text-center">Organisation</span>
                                    </a>
                                    <a href="{{ route('produkt.index') }}" class="tile-medium rounded" data-role="tile">
                                        <span class="icon"><i class="fas fa-boxes"></i></span>
                                        <span class="branding-bar text-center">Produkte</span>
                                    </a>
                                    <a href="/admin/" class="tile-medium rounded" data-role="tile">
                                        <span class="icon"><i class="fas fa-user-cog"></i></span>
                                        <span class="branding-bar text-center">Admin</span>
                                    </a>
                      {{--              <a href="admin/reports" class="tile-medium rounded" data-role="tile">
                                        <span class="icon"><i class="fab fa-wpforms"></i></span>
                                        <span class="branding-bar text-center">Berichte</span>
                                    </a>--}}
                                </nav>
                            </section>
                        </div>
                        <div class="border bg-primary text-light" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-primary btn-block text-left" type="button" data-toggle="collapse" data-target="#sectionUserApps" aria-expanded="true" aria-controls="sectionUserApps">Anwendungen</button>
                            </h2>
                        </div>
                        <div id="sectionUserApps" class="collapse show" aria-labelledby="headingOne" data-parent="#portalAuswahl">
                            <div class="card-body">
                                <div class="tiles-grid">
                                    <div class="tile-medium rounded" data-role="tile">
                                        <a href="{{ route('testware.index') }}">
                                            <img src="{{ url('img/icon/icon_testWare_35.svg') }}" alt="Logo" class="img-fluid p-1" style="max-height: 250px;">
                                        </a>
                                        <span class="branding-bar text-center">testWare</span>
                                    </div>
                                    <a href="registerphone" class="tile-medium rounded" data-role="tile" aria-label="Standorte">
                                        <span class="icon"><i class="fas fa-qrcode"></i></span>
                                        <span class="branding-bar text-center">App</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="border-top  bg-primary text-light" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-primary btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Externe Apps
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#portalAuswahl">
                            <div class="card-body">
                                <div class="tiles-grid">
                                    <a href="https://mail02.thermo-control.com/webapp/" class="tile-medium rounded" data-role="tile">
                                        <img src="{{ url('img/icon/icon_kopano.svg') }}" alt="Logo" class="img-fluid p-3" style="max-height: 250px;">
                                        <span class="branding-bar text-center">Webmail</span>
                                    </a>
                                    <a href="https://dc01.bln.thermo-control.com/" class="tile-medium rounded" data-role="tile">
                                        <img src="{{ url('img/icon/ucs_logo_gray.svg') }}" alt="Logo" class="img-fluid p-2" style="max-height: 250px;">
                                        <span class="branding-bar text-center">UCS</span>
                                    </a>
                                    <a href="https://dc01.bln.thermo-control.com/nagios" class="tile-medium rounded" data-role="tile">
                                        <img src="{{ url('img/icon/logofullsize.png') }}" alt="Logo" class="img-fluid p-2 mt-5" style="max-height: 250px;">
                                        <span class="branding-bar text-center">UCS</span>
                                    </a>

                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
