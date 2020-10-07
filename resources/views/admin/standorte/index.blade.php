@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Standorte
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Standort-Verwaltung</h1>
                <p>Sie können in diesem Modul folgende Aufgaben ausführen</p>

                {{ env('app.maxobjekte') }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <nav class="tiles-grid ">

                        <a href="{{ route('location.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">Standorte</span>
                        </a>
                        @if (\App\Lizenz::checkNumObjectsOverflow() )
                            <span class="tile-small-disabled rounded" data-role="tile" data-toggle="tooltip" data-placement="top">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </span>
                        @else
                            <a class="tile-small rounded" data-role="tile">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </a>
                        @endif

                        <a href="{{ route('building.index') }}" class="tile-small rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-building"></i></span>
                            <span class="branding-bar text-center">Gebäude</span>
                        </a>

                        @if (\App\Lizenz::checkNumObjectsOverflow() )
                            <span class="tile-small-disabled rounded" data-role="tile" data-toggle="tooltip" data-placement="top">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </span>
                        @else
                            <a href="{{ route('building.create') }}" class="tile-small rounded" data-role="tile">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </a>
                        @endif
                        <a href="{{ route('room.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-door-open"></i></span>
                            <span class="branding-bar text-center">Räume</span>
                        </a>


                        @if (\App\Lizenz::checkNumObjectsOverflow() )

                            <span class="tile-small-disabled rounded" data-role="tile" data-toggle="tooltip" data-placement="top">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </span>
                        @else
                            <a href="{{ route('room.create') }}" class="tile-small rounded" data-role="tile">
                                <span class="icon"><i class="far fa-plus-square"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </a>
                        @endif
                    </nav>
                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5">Kürzlich bearbeitete Standorte</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Kennung</th>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Location::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->l_name_kurz }}</td>
                            <td>{{ $loc->l_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('location.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Standorte angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">Kürzlich bearbeitete Gebäude</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Kennung</th>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Building::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->b_name_kurz }}</td>
                            <td>{{ $loc->b_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('building.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Gebäude angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">Kürzlich bearbeitete Räume</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Kennung</th>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Room::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->r_name_kurz }}</td>
                            <td>{{ $loc->r_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('room.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Räume angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
