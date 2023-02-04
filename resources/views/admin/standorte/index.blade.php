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
                        <nav class="row row-cols-1 px-1">
                            <x-tile link="{{ route('lexplorer') }}"
                                    :label="__('Explorer')"
                            >
                                <i class="fas fa-project-diagram fa-2x"></i>
                            </x-tile>
                        </nav>


                    @endcan
                    <x-sidetiles>

                        <x-tile link="{{ route('location.index') }}"
                                :label="__('Standorte')"
                        >
                            <i class="fas fa-industry fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('location.create') }}"
                                :label="__('Standort')"
                        >
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('building.index') }}"
                                :label="__('Gebäude')"
                        >
                            <i class="fas fa-building fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('building.create') }}"
                                :label="__('Gebäude')"
                        >
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>


                        <x-tile link="{{ route('room.index') }}"
                                :label="__('Räume')"
                        >
                            <i class="fas fa-door-open fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('room.create') }}"
                                :label="__('Raum')"
                        >
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('stellplatz.index') }}"
                                :label="__('Stellplätze')"
                        >
                            <i class="fas fa-inbox fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('stellplatz.create') }}"
                                :label="__('Stellplatz')"
                        >
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>


                    </x-sidetiles>

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
