@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Organnisation @ bitpack.io GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Standortplanung</h1>
                <p>Sie können in diesem Bereich folgende Aufgaben ausführen</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">
                        <a href="{{ route('firma.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-industry"></i></span>
                            <span class="branding-bar text-center">Firmen</span>
                        </a>
                        <a href="{{ route('firma.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                        <a href="{{ route('adresse.index') }}" class="tile-small rounded" data-role="tile" aria-label="Standorte">
                            <span class="icon"><i class="far fa-address-card"></i></span>
                            <span class="branding-bar text-center">Adressen</span>
                        </a>

                        <a href="{{ route('adresse.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-folder"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                        <a href="{{ route('profile.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                            <span class="branding-bar text-center">Mitarbeiter</span>
                        </a>
                        <a href="{{ route('profile.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-user-plus"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5">Kürzlich bearbeitete Firmen</h3>
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
                    @forelse (App\Firma::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->fa_name_kurz }}</td>
                            <td>{{ $loc->fa_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('firma.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Firmen angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">Kürzlich bearbeitete Adressen</h3>
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
                    @forelse (App\Adresse::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->ad_name_kurz }}</td>
                            <td>{{ $loc->ad_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('adresse.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Adressen angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dropdown-divider mx-3 my-md-5 my-sm-3"></div>
                <h3 class="h5">Kürzlich bearbeitete Mitarbeiter</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>MA-Nummer</th>
                        <th>Name, Vorname</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Profile::all()->sortDesc()->take(5) as $loc)
                        <tr>
                            <td>{{ $loc->ma_nummer }}</td>
                            <td>{{ $loc->ma_name }}, {{ $loc->ma_vorname }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('adresse.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Adressen angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
