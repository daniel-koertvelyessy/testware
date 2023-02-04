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

                    <x-sidetiles>

                        <x-tile link="{{ route('profile.index') }}" label="{{__('Mitarbeiter')}}">
                            <i class="fas fa-id-badge fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('profile.create') }}" label="{{__('Neu')}}">
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>
                        <hr>
                        <hr>

                        <x-tile link="{{ route('firma.index') }}" label="{{__('Firmen')}}">
                            <i class="fas fa-industry fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('firma.create') }}" label="{{__('Neu')}}">
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('contact.index') }}" label="{{__('Kontakte')}}">
                            <i class="fas fa-id-badge fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('contact.create') }}" label="{{__('Neu')}}">
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('adresse.index') }}" label="{{__('Addressen')}}">
                            <i class="fas fa-id-badge fa-2x"></i>
                        </x-tile>

                        <x-tile link="{{ route('adresse.create') }}" label="{{__('Neu')}}">
                            <i class="far fa-plus-square fa-2x"></i>
                        </x-tile>

                    </x-sidetiles>
                </section>
            </div>
            <div class="col-md-9">
                <h3 class="h5">{{__('Kürzlich bearbeitete Firmen')}}</h3>
                <table class="table  table-striped">
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
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at? $loc->updated_at->DiffForHumans
                            ():'-' }}</td>
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
                <table class="table  table-striped">
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
                            <td>{{ $contact->firma->fa_label??'-' }}</td>
                            <td class="d-none d-md-table-cell">{{ $contact->updated_at?
                            $contact->updated_at->DiffForHumans():'-' }}</td>
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
                <table class="table  table-striped">
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
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at ? $loc->updated_at->DiffForHumans():'-' }}</td>
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
                <table class="table  table-striped">
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
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at? $loc->updated_at->DiffForHumans():'-' }}</td>
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
