@extends('layout.layout-admin')
@section('pagetitle')
{{__('Produkte in Kategorie')}} {{ App\ProduktKategorie::find($id)->pk_label }}
@endsection

@section('mainSection')
{{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuProducts')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{__('Portal')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produkt.index') }}">{{__('Produkte')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ App\ProduktKategorie::find($id)->pk_label }}
            </li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h4">
                    <span class="d-none d-md-inline">{{__('Alle Produkte der Kategorie')}}</span> <span class=" small badge badge-primary">{{ App\ProduktKategorie::find($id)->pk_label }}</span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table  table-striped table-hover">
                    <thead>
                    <tr>
                        <th>@sortablelink('prod_nummer', __('Artikelnummer'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('prod_label', __('Kürzel'))</th>
                        <th class="d-none d-md-table-cell">@sortablelink('ControlProdukt.id', __('Prüfmittel'))</th>
                        <th>{{__('Status')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Aktiv')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Geräte')}}</th>
                        <th class="d-none d-md-table-cell">@sortablelink('updated_at', __('Berarbeitet'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($prodList as $produkt)
                        <tr>
                            <td><a href="{{ route('produkt.show',$produkt) }}">{{ $produkt->prod_nummer }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_label }}</td>
                            <td class="d-none d-md-table-cell">{!! $produkt->ControlProdukt ? '<i class="fas fa-check text-success"></i>' : '' !!}</td>
                            <td>
                                <span class="d-none d-md-table-cell bg-{{$produkt->ProduktState->ps_color}} text-white p-1 small">{{$produkt->ProduktState->ps_name}}</span>

                                <i class="{{ $produkt->ProduktState->ps_icon}} text-{{$produkt->ProduktState->ps_color}} d-md-none" title="{{$produkt->ProduktState->ps_name}}"></i>
                            </td>
                            <td class="d-none d-md-table-cell">{!!  ($produkt->prod_active === 1) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->Equipment->count() }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->updated_at->DiffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-notifyer>{{ __('Keine Produkte gefunden') }}</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $prodList->withQueryString()->onEachSide(2)->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

