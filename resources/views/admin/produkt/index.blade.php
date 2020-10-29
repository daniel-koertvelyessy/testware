@extends('layout.layout-admin')

@section('pagetitle')
    Produktübersicht @ bitpack GmbH
@endsection

@section('mainSection')
    Produkte
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
            <h1 class="h4 mb-0">Übersicht Produkte</h1>
            <span class="small mt-0">Gesamt: <span class="badge badge-light">{{ number_format(App\Produkt::all()->count(),0,',','.') }}</span></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{__('Bezeichung')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Produkt Nummer')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Kategorie')}}</th>
                    <th>{{__('Aktiv')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Prüfmittel')}}</th>
                    <th class="d-none d-md-table-cell">{{__('Status')}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($produktList as $produkt)
                    <tr>
                        <td><a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_name_kurz }}</a></td>
                        <td class="d-none d-md-table-cell">{{ $produkt->prod_nummer }}</td>
                        <td class="d-none d-md-table-cell">{{ $produkt->ProduktKategorie->pk_name_kurz }}</td>
                        <td>{!!  ($produkt->prod_active === 1) ? '<i class="far fa-check-circle text-success"></i>' : '<i class="far fa-times-circle text-danger"></i>' !!}</td>
                        <td class="d-none d-md-table-cell">{!! $produkt->ControlProdukt ? '<i class="far fa-check-circle text-success"></i>' : '' !!}</td>
                        <td class="d-none d-md-table-cell">{{ $produkt->ProduktState->ps_name_kurz }} </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <x-notifyer>Keine Produkte gefunden</x-notifyer>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if(count($produktList)>0) {{ $produktList->links() }}  @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection


