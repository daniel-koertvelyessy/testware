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
                <h1 class="h3">{{__('Vorschriften')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <h3 class="h4 mt-md-3 mt-sm-1">{{__('Verordnungen')}}</h3>
        <div class="row">
            <div class="col-md-2">
                <section class="card-body text-dark">

                    <nav class="d-flex justify-content-around flex-lg-column">

                        <a href="{{ route('verordnung.index') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="fas fa-book"></i></span>
                            <span class="branding-bar text-center">{{__('Übersicht')}}</span>
                        </a>
                        <a href="{{ route('verordnung.create') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>

                    </nav>
                </section>
            </div>
            <div class="col-md-10">
                <h3 class="lead mt-md-3 mt-sm-1">Kürzlich erstellte Verordnungen</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                    </tr>
                    </thead>
                    <tbody>

                @forelse (App\Verordnung::take(5)->latest()->get() as $verordnung)
                    <tr>
                        <td><a href="{{ route('verordnung.show',$verordnung) }}">{{ $verordnung->vo_name }}</a></td>
                        <td class="d-none d-md-table-cell">{{ $verordnung->vo_nummer }}</td>
                        <td class="d-none d-md-table-cell">{{ $verordnung->updated_at? $verordnung->updated_at->DiffForHumans() : '-' }}</td>
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
        <h3 class="h4 mt-md-3 mt-sm-1">Anforderungen</h3>
        <div class="row">
            <div class="col-lg-2 col-md-4">
                <section class="card-body text-dark">

                    <nav class="d-flex justify-content-around flex-md-row flex-lg-column">

                        <a href="{{ route('anforderung.index') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="far fa-list-alt"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>
                        <a href="{{ route('anforderung.create') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>

                    </nav>

                </section>
            </div>
            <div class="col-lg-10 col-md-8">
                <h3 class="lead mt-4">Kürzlich erstellte Anforderungen</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-5">Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Anforderung::take(5)->latest()->get() as $anforderung)
                        <tr>
                            <td><a href="{{ route('anforderung.show',$anforderung) }}">{{ $anforderung->an_name }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $anforderung->an_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $anforderung->updated_at?$anforderung->updated_at->DiffForHumans() :'-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{ __('Keine Anforderung gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <h3 class="h4 mt-md-3 mt-sm-1">{{__('Prüfungen')}}</h3>
        <div class="row">
            <div class="col-md-2">
                <section class="card-body text-dark">

                    <nav class="d-flex justify-content-around flex-lg-column">

                        <a href="{{ route('anforderungcontrolitem.index') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="far fa-list-alt"></i></span>
                            <span class="branding-bar text-center">{{__('Übersicht')}}</span>
                        </a>
                        <a href="{{ route('anforderungcontrolitem.create') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="far fa-plus-square"></i></span>
                            <span class="branding-bar text-center">{{__('Neu')}}</span>
                        </a>

                    </nav>

                </section>
            </div>
            <div class="col-md-10">
                <h3 class="lead mt-4">{{__('Kürzlich erstellte Prüfungen')}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\AnforderungControlItem::take(5)->latest()->get() as $anforderungItem)
                        <tr>
                            <td><a href="{{ route('anforderungcontrolitem.show',$anforderungItem) }}">{{ $anforderungItem->aci_name }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $anforderungItem->aci_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $anforderungItem->updated_at? $anforderungItem->updated_at->DiffForHumans(): '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
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
