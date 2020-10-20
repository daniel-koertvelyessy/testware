@extends('layout.layout-admin')

@section('pagetitle','Verordnungen')

@section('mainSection')
    {{__('Vorschriften')}}
@endsection

@section('menu')
    @include('menus._menuVerordnung')
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Vorschriften</h1>
                <p>Sie können in diesem Modul folgende Aufgaben ausführen</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <h3 class="h5">Verordnungen</h3>
                    <nav class="tiles-grid justify-content-around">

                        <a href="{{ route('verordnung.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-book"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>
                        <a href="{{ route('verordnung.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>
                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5">Kürzlich erstellte Verordnungen</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                @forelse (App\Verordnung::take(5)->latest()->get() as $verordnung)
                    <tr>
                        <td>{{ $verordnung->vo_name_lang }}</td>
                        <td>{{ $verordnung->vo_nummer }}</td>
                        <td>{{ $verordnung->updated_at??'-' }}</td>
                        <td><a href="{{ route('verordnung.show',$verordnung) }}">Bearbeiten</a></td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <x-notifyer>{{ __('Keine Verordnungen gefunden') }}</x-notifyer>
                        </td>
                    </tr>
                @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <h3 class="h5">Anforderungen</h3>
                    <nav class="tiles-grid justify-content-around">

                        <a href="{{ route('anforderung.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-list-alt"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>
                        <a href="{{ route('anforderung.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>

                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5 mt-4">Kürzlich erstellte Anforderungen</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Anforderung::take(5)->latest()->get() as $anforderung)
                        <tr>
                            <td>{{ $anforderung->an_name_lang }}</td>
                            <td>{{ $anforderung->an_name_kurz }}</td>
                            <td>{{ $anforderung->updated_at??'-' }}</td>
                            <td><a href="{{ route('anforderung.show',$anforderung) }}">Bearbeiten</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>{{ __('Keine Anforderung gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <section class="card-body text-dark">
                    <h3 class="h5">Prüfungen</h3>
                    <nav class="tiles-grid justify-content-around">

                        <a href="{{ route('anforderungcontrolitem.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-list-alt"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>
                        <a href="{{ route('anforderungcontrolitem.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>

                </section>
            </div>
            <div class="col-md-8">
                <h3 class="h5 mt-4">Kürzlich erstellte Prüfungen</h3>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\AnforderungControlItem::take(5)->latest()->get() as $anforderungItem)
                        <tr>
                            <td>{{ $anforderungItem->aci_name_lang }}</td>
                            <td>{{ $anforderungItem->aci_name_kurz }}</td>
                            <td>{{ $anforderungItem->updated_at??'-' }}</td>
                            <td><a href="{{ route('anforderungcontrolitem.show',$anforderungItem) }}">Bearbeiten</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>{{ __('Keine Prüfungen gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
