@extends('layout.layout-admin')

@section('pagetitle')
{{__('Start')}} &triangleright; {{__('Standortverwaltung')}} @ bitpack.io GmbH
@endsection

@section('mainSection')
    {{__('Standorte')}}
@endsection

@section('menu')
    @include('menus._menuStandort')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{__('Standortverwaltung')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <nav class="tiles-grid ">

                        <a href="{{ route('location.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">{{__('Standorte')}}</span>
                        </a>
                        <a href="{{ route('location.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                        <a href="{{ route('building.index') }}" class="tile-small rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-building"></i></span>
                            <span class="branding-bar text-center">{{__('Gebäude')}}</span>
                        </a>

                        <a href="{{ route('building.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                        <a href="{{ route('room.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-door-open"></i></span>
                            <span class="branding-bar text-center">{{__('Räume')}}</span>
                        </a>

                        <a href="{{ route('room.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5">{{__('Kürzlich bearbeitete Standorte')}}</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Kennung')}}</th>
                        <th>{{__('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($locations as $loc)
                        <tr>
                            <td>{{ $loc->l_name_kurz }}</td>
                            <td>{{ $loc->l_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('location.show',$loc) }}">{{__('öffnen')}}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>{{__('Keine Standorte angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Gebäude')}}</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Kennung')}}</th>
                        <th>{{__('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($buildings as $loc)
                        <tr>
                            <td>{{ $loc->b_name_kurz }}</td>
                            <td>{{ $loc->b_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('building.show',$loc) }}">{{__('öffnen')}}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>{{__('Keine Gebäude angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Räume')}}</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>{{__('Kennung')}}</th>
                        <th>{{__('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($rooms as $loc)
                        <tr>
                            <td>{{ $loc->r_name_kurz }}</td>
                            <td>{{ $loc->r_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('room.show',$loc) }}">{{__('öffnen')}}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>{{__('Keine Räume angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
