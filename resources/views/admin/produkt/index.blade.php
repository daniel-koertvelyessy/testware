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
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Produkt Nummer</th>
                    <th>Bezeichung</th>
                    <th>Kategorie</th>
                    <th>Aktiv</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($produktList as $produkt)
                    <tr>
                        <td>{{ $produkt->prod_nummer }}</td>
                        <td>{{ $produkt->prod_name_kurz }}</td>
                        <td>{{ $produkt->ProduktKategorie->pk_name_kurz }}</td>
                        <td>{!!  ($produkt->prod_active === 1) ? '<i class="far fa-check-circle text-success"></i>' : '<i class="far fa-times-circle text-danger"></i>' !!}</td>
                        <td>{{ $produkt->ProduktState->ps_name_kurz }} </td>
                        <td><a href="{{ route('produkt.show',$produkt) }}">öffnen</a></td>
                    </tr>
                @empty

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


