@extends('layout.layout-admin')

@section('pagetitle')
    Firmen &triangleright; Organnisation @ bitpack GmbH
@endsection

@section('mainSection')
    Organisation
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h1>Firmen</h1>
                <span class="badge badge-light">Gesamt: {{ $firmaList->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Kürzel</th>
                        <th>Typ</th>
                        <th>Firma</th>
                        <th>Straße / Nr</th>
                        <th>PLZ / Ort</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($firmaList as $firma)
                        <tr>
                            <td>{{ $firma->fa_name_kurz }}</td>
                            <td>{{ $firma->fa_name_lang }}</td>
                            <td>{{ $firma->ad_name_firma }}</td>
                            <td>{{ $firma->fa_kreditor_nr }}</td>
                            <td>{{ $firma->Adresse->ad_anschrift_plz }} - {{ $firma->Adresse->ad_anschrift_ort }} </td>
                            <td><a href="{{ route('firma.show',['firma'=>$firma]) }}">öffnen</a></td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                @if(count($firmaList)>0) {{ $firmaList->links() }}  @endif
            </div>
        </div>
    </div>

@endsection
