@extends('layout.layout-admin')

@section('pagetitle')
{{__('Organisation')}} &triangleright; {{__('Organisation')}}
@endsection

@section('mainSection')
    {{__('Organisation')}}
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
            <div class="col-md-3">
                <section class="card-body text-dark">

                    <nav class="tiles-grid mb-3">
                        <a href="{{ route('firma.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-industry"></i></span> <span class="branding-bar text-center">{{__('Firmen')}}</span>
                        </a>
                        <a href="{{ route('firma.create') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Firma')}}</span>
                        </a>

                        <a href="{{ route('contact.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-id-badge"></i></span> <span class="branding-bar text-center">{{__('Kontakte')}}</span>
                        </a>
                        <a href="{{ route('contact.create') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Kontakt')}}</span>
                        </a>



                        <a href="{{ route('adresse.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                           aria-label="Storagee"
                        >
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span> <span class="branding-bar text-center">{{__('Adressen')}}</span>
                        </a>

                        <a href="{{ route('adresse.create') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Adresse')}}</span>
                        </a>
                        <a href="{{ route('profile.index') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-address-card"></i></span> <span class="branding-bar text-center">{{__('Mitarbeiter')}}</span>
                        </a>
                        <a href="{{ route('profile.create') }}"
                           class="tile-small btn-outline-primary rounded"
                           data-role="tile"
                        >
                            <span class="icon"><i class="far fa-plus-square"></i></span> <span class="branding-bar text-center">{{__('Mitarbeiter')}}</span>
                        </a>
                    </nav>
                </section>
            </div>
            <div class="col-md-9">
                <h3 class="h5">{{__('Kürzlich bearbeitete Firmen')}}</h3>
                <table class="table table-responsive-md table-striped">
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
                            <td>
                                <a href="{{ route('firma.show',$loc) }}">{{ $loc->fa_name }}</a>
                            </td>
                            <td>{{ $loc->fa_label }}</td>
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
                <h3 class="h5">{{__('Kürzlich bearbeitete Kontakte')}}</h3>
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th class="w-50">{{__('Name')}}</th>
                        <th>{{__('Firma')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($contacts as $contact)
                        <tr>
                            <td>
                                <a href="{{ route('contact.show',$contact) }}">{{ $contact->fullName() }}</a>
                            </td>
                            <td>{{ $contact->firma->fa_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $contact->updated_at->DiffForHumans() }}</td>
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
                <table class="table table-responsive-md table-striped">
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
                            <td>
                                <a href="{{ route('adresse.show',$loc) }}">{{ $loc->ad_name }}</a>
                            </td>
                            <td>{{ $loc->ad_label }}</td>
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
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th class="w-50">{{__('Name')}}</th>
                        <th>{{__('MA-Nummer')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($profiles as $loc)
                        <tr>
                            <td>
                                <a href="{{ route('adresse.show',$loc) }}">{{ $loc->ma_name }}, {{ $loc->ma_vorname }}</a>
                            </td>
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
