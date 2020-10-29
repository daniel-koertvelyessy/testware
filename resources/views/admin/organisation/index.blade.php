@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; {{__('Organisation')}} @ bitpack.io GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuOrga' )
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Organisation')}}</h1>
                <p>{{__('Sie können in diesem Bereich folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('firma.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">{{__('Firmen')}}</span>
                        </a>
                        <a href="{{ route('firma.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>

                        <a href="{{ route('adresse.index') }}" class="tile-small rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-address-card"></i></span>
                            <span class="branding-bar text-center">{{__('Adressen')}}</span>
                        </a>

                        <a href="{{ route('adresse.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-folder"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                        <a href="{{ route('profile.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                            <span class="branding-bar text-center">{{__('Mitarbeiter')}}</span>
                        </a>
                        <a href="{{ route('profile.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-plus"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5">{{__('Kürzlich bearbeitete Firmen')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="w-50">{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($firmas as $loc)
                        <tr>
                            <td><a href="{{ route('firma.show',$loc) }}">{{ $loc->fa_name_lang }}</a></td>
                            <td>{{ $loc->fa_name_kurz }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Firmen angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Adressen')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="w-50">{{__('Bezeichnung')}}</th>
                        <th>{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($adresses as $loc)
                        <tr>
                            <td><a href="{{ route('adresse.show',$loc) }}">{{ $loc->ad_name_lang }}</a></td>
                            <td>{{ $loc->ad_name_kurz }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Adressen angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">{{__('Kürzlich bearbeitete Mitarbeiter')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="w-50">{{__('Name, Vorname')}}</th>
                        <th>{{__('MA-Nummer')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($profiles as $loc)
                        <tr>
                            <td><a href="{{ route('adresse.show',$loc) }}">{{ $loc->ma_name }}, {{ $loc->ma_vorname }}</a></td>
                            <td>{{ $loc->ma_nummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Adressen angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
