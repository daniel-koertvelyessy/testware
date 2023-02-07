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
                    <x-tiles>
                        <x-tile link="{{ route('dashboard') }}"
                                :label="__('Dashboard')"
                        >
                            <img src="{{ asset('img/icon/testWare_Logo.svg') }}"
                                 alt="Logo"
                                 style="height: 2.9rem;"
                            >
                            @if(!Auth::user())
                                <i class="fas fa-lock" style="position: absolute;top:10px;right:10px"></i>
                            @endif
                        </x-tile>

                        <x-tile link="{{ route('docs.start') }}"
                                :label="__('Dokumentation')"
                        >
                            <i class="fas fa-book fa-3x"></i>
                        </x-tile>

                    </x-tiles>

                </section>
                @if(Auth::user())
                    <section class="mb-2 mb-md-4">
                        <h2 class="h4">{{__('Verwaltung')}}</h2>
                        <x-tiles>
                            <x-tile link="{{ route('storageMain') }}"
                                    :label="__('memStandorte')"
                            >
                                <i class="fas fa-industry fa-2x"></i>
                            </x-tile>

                            <x-tile link="{{ route('organisationMain') }}"
                                    :label="__('Organisation')"
                            >
                                <i class="fas fa-users fa-2x"></i>
                            </x-tile>

                            <x-tile link="{{ route('produktMain') }}"
                                    :label="__('Produkte')"
                            >
                                <i class="fas fa-boxes fa-2x"></i>
                            </x-tile>

                            <x-tile link="{{ route('verordnung.main') }}"
                                    :label="__('Vorschriften')"
                            >
                                <i class="fas fa-scroll fa-2x"></i>
                            </x-tile>

                            <x-tile link="{{ route('report.index') }}"
                                    :label="__('Berichte')"
                            >
                                <i class="fas fa-clipboard fa-2x"></i>
                            </x-tile>

                        </x-tiles>
                    </section>
                    @can('isAdmin',Auth::user())
                        <section class="mb-2 mb-md-4">
                            <h2 class="h4">{{__('System')}}</h2>

                            <x-tiles>
                                <x-tile link="{{ route('admin.index') }}"
                                        :label="__('Systemstatus')"
                                >
                                    <i class="far fa-check-square fa-2x"></i>
                                </x-tile>

                                <x-tile link="{{ route('user.index') }}"
                                        :label="__('Benutzer')"
                                >
                                    <i class="fas fa-user-cog fa-2x"></i>
                                </x-tile>

                                <x-tile link="{{ route('systems') }}"
                                        :label="__('Einstellungen')"
                                >
                                    <i class="fas fa-cogs fa-2x"></i>
                                </x-tile>

                            </x-tiles>


                        </section>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
