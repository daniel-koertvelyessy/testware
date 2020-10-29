@extends('layout.layout-admin')

@section('pagetitle')
    Start &triangleright; {{__('Produkte')}} @ bitpack GmbH
@endsection

@section('mainSection')
{{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">{{__('Produkt-Verwaltung')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                    <nav class="d-flex justify-content-around flex-md-column flex-sm-row mb-3">

                        <a href="{{ route('produkt.index') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="fas fa-boxes"></i></span>
                            <span class="branding-bar text-center">{{__('Übersicht')}}</span>
                        </a>
{{--                        @if (!env('app.makeobjekte') )
                            <span class="tile-small-disabled rounded" data-role="tile">
                                <span class="icon"><i class="fas fa-box"></i></span>
                                <span class="branding-bar text-center">Neu</span>
                            </span>
                            @else--}}
                        <a href="{{ route('produkt.create') }}" class="tile-small rounded mb-lg-3 mb-sm-1" data-role="tile">
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">Neu</span>
                        </a>
{{--                            @endif--}}

                    </nav>


            </div>
            <div class="col-md-10">
                <h3 class="h5">Kürzlich erstellte Produkte</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th class="d-none d-md-table-cell">Kennung</th>
                        <th class="d-none d-md-table-cell">Bearbeitet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\Produkt::all()->sortDesc()->take(10) as $loc)
                        <tr>
                            <td><a href="{{ route('produkt.show',$loc) }}">{{ $loc->prod_name_lang }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $loc->prod_name_kurz }}</td>
                            <td class="d-none d-md-table-cell">{{ $loc->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>Keine Produkte angelegt!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        <h3 class="h4">Neues Produkt aus Kategorie erstellen</h3>
        <div class="row">
            <div class="col">



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
                    <nav class="d-flex justify-lg-content-start justify-sm-content-around">
                        @foreach ($produktKategories as $produktKategorie)
                            <a href="{{ route('produkt.create',['pk'=> $produktKategorie->id]) }}" class="tile-small rounded mr-lg-3 mr-sm-2" data-role="tile">
                                <span class="icon"><i class="fas fa-box"></i></span>
                                <span class="branding-bar text-center">{{$produktKategorie->pk_name_kurz}}</span>
                            </a>
                        @endforeach
                    </nav>
                    {{--                        @endif--}}


{{--                    <section class="card-body text-dark">    </section>--}}
            </div>
        </div>
    </div>

@endsection
