@extends('layout.layout-admin')

@section('pagetitle')
    {{__('Produktübersicht')}}
@endsection

@section('mainSection')
    {{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
    {{--    <nav aria-label="breadcrumb">--}}
    {{--        <ol class="breadcrumb">--}}
    {{--            <li class="breadcrumb-item"><a href="/">Portal</a></li>--}}
    {{--            <li class="breadcrumb-item"><a href="/building">Gebäude</a></li>--}}
    {{--            <li class="breadcrumb-item active" aria-current="page">{{  $building->b_name_kurz  }}</li>--}}
    {{--        </ol>--}}
    {{--    </nav>--}}
@endsection

@section('modals')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h4 mb-0">{{__('Übersicht Produkte')}}</h1>
                <span class="small mt-0">Gesamt: <span class="badge badge-light">{{ number_format(App\Produkt::all()->count(),0,',','.') }}</span></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped"
                       id="tabProduktListe"
                >
                    <thead>
                    <tr>
                        <th>@sortablelink('prod_name_kurz', __('Bezeichung'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('prod_nummer', __('Artikelnummer'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ProduktKategorie.pk_name_kurz', __('Kategorie'))</th>
                        <th>@sortablelink('prod_active', __('Aktiv'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ControlProdukt.id', __('Prüfmittel'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ProduktState.ps_name_kurz', __('Status'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($produktList as $produkt)
                        <tr>
                            <td>
                                <a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_name_kurz }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_nummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->ProduktKategorie->pk_name_kurz }}</td>
                            <td>{!!  ($produkt->prod_active === 1) ? '<i class="far fa-check-circle text-success"></i>' : '<i class="far fa-times-circle text-danger"></i>' !!}</td>
                            <td class="d-none d-md-table-cell">{!! $produkt->ControlProdukt ? '<i class="far fa-check-circle text-success"></i>' : '' !!}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->ProduktState->ps_name_kurz }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-notifyer>{{__('Keine Produkte gefunden')}}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($produktList->count() >10)
                    <div class="d-flex justify-content-center">
                        {!! $produktList->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection


