@extends('layout.layout-admin')

@section('pagetitle')
    Adressen &triangleright; Organnisation @ bitpack GmbH
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
                <h1>Adressen</h1>
                <span class="badge badge-light">Gesamt: {{ $adresseList->total() }}</span>
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
                    @forelse ($adresseList as $adddress)
                        <tr>
                            <td>{{ $adddress->ad_name_kurz }}</td>
                            <td>{{ $adddress->AddressType->adt_name }}</td>
                            <td>{{ $adddress->ad_name_firma }}</td>
                            <td>{{ $adddress->ad_anschrift_strasse }} / {{ $adddress->ad_anschrift_hausnummer }}</td>
                            <td>{{ $adddress->ad_anschrift_plz }} - {{ $adddress->ad_anschrift_ort }} </td>
                            <td><a href="{{ route('adresse.show',['adresse'=>$adddress]) }}">öffnen</a></td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                @if(count($adresseList)>0) {{ $adresseList->links() }}  @endif
            </div>
        </div>
    </div>

@endsection
