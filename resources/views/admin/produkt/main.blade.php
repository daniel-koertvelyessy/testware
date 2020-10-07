@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; Produkte @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Produkt-Verwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Sie können in diesem Modul folgende Aufgaben ausführen</p>
                <section class="card-body text-dark">
                    <nav class="tiles-grid justify-content-around">

                        <a href="{{ route('produkt.index') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-boxes"></i></span>
                            <span class="branding-bar text-center">Übersicht</span>
                        </a>
{{--                        @if (!env('app.makeobjekte') )
                            <span class="tile-small-disabled rounded" data-role="tile">
                                <span class="icon"><i class="fas fa-box"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </span>
                            @else--}}
                        <a href="{{ route('produkt.create') }}" class="tile-small rounded" data-role="tile">
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
{{--                            @endif--}}

                    </nav>
                </section>

                <section class="card-body text-dark">
                    <h3 class="h5">Neues Produkt aus Kategorie erstellen</h3>

                    @php $produktKategories = App\ProduktKategorie::all(); @endphp
{{--                    @if (!env('app.makeobjekte') )--}}
{{--                        <nav class="tiles-grid justify-content-md-around justify-content-sm-center">--}}
{{--                            @foreach ($produktKategories as $produktKategorie)--}}
{{--                                <span class="tile-small-disabled rounded" data-role="tile">--}}
{{--                                    <span class="icon"><i class="fas fa-box"></i></span>--}}
{{--                                    <span class="branding-bar text-center">{{$produktKategorie->pk_name_kurz}}</span>--}}
{{--                                </span>--}}
{{--                            @endforeach--}}
{{--                        </nav>--}}
{{--                    @else--}}
                        <nav class="tiles-grid justify-content-md-around justify-content-sm-center">
                            @foreach ($produktKategories as $produktKategorie)
                                <a href="{{ route('produkt.create',['pk'=> $produktKategorie->id]) }}" class="tile-small rounded" data-role="tile">
                                    <span class="icon"><i class="fas fa-box"></i></span>
                                    <span class="branding-bar text-center">{{$produktKategorie->pk_name_kurz}}</span>
                                </a>
                            @endforeach
                        </nav>
{{--                        @endif--}}


                </section>

            </div>
            <div class="col-md-8">
                <h3 class="h5">Kürzlich erstellte Produkte</h3>
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
                    @forelse (App\Produkt::all()->sortDesc()->take(10) as $loc)
                        <tr>
                            <td>{{ $loc->prod_name_kurz }}</td>
                            <td>{{ $loc->prod_name_lang }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at }}</td>
                            <td><a href="{{ route('produkt.show',$loc) }}">öffnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Produkte angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
