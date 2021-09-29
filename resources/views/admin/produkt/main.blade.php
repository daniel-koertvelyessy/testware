@extends('layout.layout-admin')

@section('pagetitle')
{{__('Start')}} &triangleright; {{__('Produkte')}}
@endsection

@section('mainSection')
    <span class="d-md-block d-none">{{__('Produktverwaltung')}}</span><span class="d-md-none">{{ __('Produkte') }}</span>
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('content')

    <div class="container">
        <div class="row d-md-block d-none">
            <div class="col">
                <h1 class="h4">{{__('Produktverwaltung')}}</h1>
                <p>{{__('Sie können in diesem Modul folgende Aufgaben ausführen')}}:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <nav class="justify-content-around flex-md-column flex-sm-row mb-3">
                    <a href="{{ route('produkt.index') }}"
                       class="tile-small btn-outline-primary rounded mb-lg-3 mb-2"
                       data-role="tile"
                    >
                        <span class="icon"><i class="fas fa-boxes"></i></span> <span
                            class="branding-bar text-center">{{__('Übersicht')}}</span>
                    </a>

                    <a href="{{ route('produkt.create') }}"
                       class="tile-small btn-outline-primary rounded mb-lg-3 mb-2"
                       data-role="tile"
                    >
                        <span class="icon"><i class="fas fa-box"></i></span> <span
                            class="branding-bar text-center">{{__('Neu')}}</span>
                    </a>

                </nav>
            </div>
            <div class="col-md-10">
                <h3 class="h5">{{__('Kürzlich erstellte Produkte')}}</h3>
                <table class="table table-striped" id="tabProduktListe">
                    <thead>
                    <tr>
                        <th>{{__('Bezeichnung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Kennung')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Bearbeitet')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($produkts as $produkt)
                        <tr>
                            <td>
                                <a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_name }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_label }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-notifyer>{{__('Keine Produkte angelegt!')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @can('isAdmin', Auth::user())
        <h3 class="h4">{{__('Neues Produkt aus Kategorie erstellen')}}</h3>
        <div class="row">
            <div class="col">
                @php $produktKategories = App\ProduktKategorie::all(); @endphp
                <nav class="tiles-grid">
                    @foreach ($produktKategories as $produktKategorie)
                        <a href="{{ route('produkt.create',['pk'=> $produktKategorie->id]) }}"
                           class="tile-small btn-outline-primary rounded mr-lg-3 mr-sm-2"
                           data-role="tile"
                        >
                            <span class="icon"><i class="fas fa-box"></i></span>
                            <span class="branding-bar text-center">{{$produktKategorie->pk_label}}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
        @endcan
    </div>

@endsection
