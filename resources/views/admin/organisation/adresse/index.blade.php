@extends('layout.layout-admin')

@section('pagetitle')
{{__('Adressen')}} &triangleright; {{__('Organisation')}} @ bitpack GmbH
@endsection

@section('mainSection')
{{__('Organisation')}}
@endsection

@section('menu')
    @include('menus._menuOrga')
@endsection

@section('content')

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h1 class="h3">{{__('Adressen')}}</h1>
                <span class="badge badge-light">{{__('Gesamt')}}: {{ $adresseList->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Firma')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Kürzel')}}</th>
                        <th class="d-none d-lg-table-cell">{{__('Typ')}}</th>
                        <th>{{__('Straße / Nr')}}</th>
                        <th class="d-none d-md-table-cell">{{__('PLZ / Ort')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($adresseList as $adddress)
                        <tr>
                            <td><a href="{{ route('adresse.show',['adresse'=>$adddress]) }}">{{ $adddress->ad_name_firma }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $adddress->ad_label }}</td>
                            <td class="d-none d-lg-table-cell">{{ $adddress->AddressType->adt_name }}</td>
                            <td>{{ $adddress->ad_anschrift_strasse }} / {{ $adddress->ad_anschrift_hausnummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $adddress->ad_anschrift_plz }} - {{ $adddress->ad_anschrift_ort }} </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                @if($adresseList->count() >0)
                    <div class="d-flex justify-content-center">
                        {!! $adresseList->withQueryString()->onEachSide(2)->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
