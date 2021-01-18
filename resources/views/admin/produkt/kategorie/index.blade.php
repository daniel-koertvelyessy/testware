@extends('layout.layout-admin')
@section('pagetitle')
{{__('Produkte in Kategorie')}} {{ App\ProduktKategorie::find($id->id)->pk_label }}
@endsection

@section('mainSection')
{{__('Produkte')}}
@endsection

@section('menu')
    @include('menus._menuMaterial')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{__('Portal')}}</a></li>
            <li class="breadcrumb-item"><a href="/produkt">{{__('Produkte')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ App\ProduktKategorie::find($id->id)->pk_label }}
            </li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">
                    <span class="d-none d-md-inline">{{__('Alle Produkte der Kategorie')}}</span> <span class="badge badge-primary">{{ App\ProduktKategorie::find($id->id)->pk_label }}</span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">Nummer</th>
                        <th class="d-none d-md-table-cell">Erstell am</th>
                        <th>Kürzel</th>
                        <th>Status</th>
                        <th>Aktiv</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($prodList as $produkt)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $produkt->prod_nummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $produkt->created_at }}</td>
                            <td>{{ $produkt->prod_label }}</td>
                            <td><i class="{{ $produkt->ProduktState->ps_icon}} text-{{$produkt->ProduktState->ps_color}}" title="{{$produkt->ProduktState->ps_name}}"></i></td>
                            <td>{!!  ($produkt->prod_active === 1) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                            <td><a href="/produkt/{{ $produkt->id }}">öffnen</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $prodList->withQueryString()->onEachSide(2)->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

