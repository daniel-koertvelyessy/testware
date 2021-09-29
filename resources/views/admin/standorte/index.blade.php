@extends('layout.layout-admin')

@section('pagetitle')
{{__('Start')}} &triangleright; {{__('Standortverwaltung')}}
@endsection

@section('mainSection')
    {{__('memStandorte')}}
@endsection

@section('menu')
    @include('menus._menuStorage')
@endsection

@section('content')

    <div class="container">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1>
                    <span class="d-none d-md-block">{{__('Standortverwaltung')}}</span> <span class="d-md-none">{{__('memStandorte')}}</span>
                </h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <section class="card-body text-dark">
                    @can('isAdmin', Auth()->user())
                        <a href="{{ route('lexplorer') }}"
                           class="tile-small btn-outline-primary rounded mb-3"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-project-diagram"></i></span> <span class="branding-bar text-center">{{__('Explorer')}}</span>
                        </a>
                    @endcan
                    <nav class="tiles-grid mb-3">
                        <a href="{{ route('location.index') }}"
                           class="tile-small rounded btn-outline-primary"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-industry"></i></span> <span class="branding-bar text-center">{{__('Standorte')}}</span>
                        </a>
                        @can('isAdmin', Auth()->user())
                            <a href="{{ route('location.create') }}"
                               class="tile-small rounded btn-outline-primary"
                               data-role="tile"
                            >
                                <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Standort')}}</span>
                            </a>
                        @endcan
                    </nav>
                    <nav class="tiles-grid mb-3">
                        <a href="{{ route('building.index') }}"
                           class="tile-small rounded btn-outline-primary"
                           data-role="tile"
                           aria-label="Storagee"
                        >
                            <span class="icon"><i class="far fa-building"></i></span> <span class="branding-bar text-center">{{__('Gebäude')}}</span>
                        </a>
                        @can('isAdmin', Auth()->user())
                            <a href="{{ route('building.create') }}"
                               class="tile-small rounded btn-outline-primary"
                               data-role="tile"
                            >
                                <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Gebäude')}}</span>
                            </a>
                        @endcan
                    </nav>
                    <nav class="tiles-grid mb-3">
                        <a href="{{ route('room.index') }}"
                           class="tile-small rounded btn-outline-primary"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-door-open"></i></span> <span class="branding-bar text-center">{{__('Räume')}}</span>
                        </a>
                        @can('isAdmin', Auth()->user())
                            <a href="{{ route('room.create') }}"
                               class="tile-small rounded btn-outline-primary"
                               data-role="tile"
                            >
                                <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Raum')}}</span>
                            </a>
                        @endcan
                    </nav>
                    <nav class="tiles-grid mb-3">
                        <a href="{{ route('stellplatz.index') }}"
                           class="tile-small rounded btn-outline-primary"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-inbox"></i></span> <span class="branding-bar text-center">{{__('Stellplätze')}}</span>
                        </a>
                        @can('isAdmin', Auth()->user())
                            <a href="{{ route('stellplatz.create') }}"
                               class="tile-small rounded btn-outline-primary"
                               data-role="tile"
                            >
                                <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Stellplatz')}}</span>
                            </a>
                        @endcan
                    </nav>
                </section>
            </div>
            <div class="col-md-9">
                <h3 class="h5">{{__('Kürzlich bearbeitete Standorte')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($locations as $loc)
                        <tr>
                            <td>
                                <a href="{{ route('location.show',$loc) }}">{{ $loc->l_name }}</a>
                            </td>
                            <td>{{ $loc->l_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Standorte angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Gebäude')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($buildings as $loc)
                        <tr>
                            <td>
                                <a href="{{ route('building.show',$loc) }}">{{ $loc->b_name }}</a>
                            </td>
                            <td>{{ $loc->b_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Gebäude angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Räume')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($rooms as $loc)
                        <tr>
                            <td>
                                <a href="{{ route('room.show',$loc) }}">{{ $loc->r_name }}</a>
                            </td>
                            <td>{{ $loc->r_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Räume angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Stellplätze')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($compartments as $compartment)
                        <tr>
                            <td>
                                <a href="{{ route('room.show',$compartment) }}">{{ $compartment->sp_name }}</a>
                            </td>
                            <td>{{ $compartment->sp_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $compartment->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Stellplätze angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
