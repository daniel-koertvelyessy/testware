@extends('layout.layout-admin')

@section('pagetitle')
{{__('Firmen')}} &triangleright; {{__('Organisation')}} @ bitpack GmbH
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
                <h1 class="h3">{{__('Firmen')}}</h1>
                <span class="badge badge-light">{{__('Gesamt')}}: {{ $firmaList->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Firma')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Kürzel')}}</th>
                        <th class="d-none d-md-table-cell">{{__('PLZ / Ort')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($firmaList as $firma)
                        <tr>
                            <td><a href="{{ route('firma.show',['firma'=>$firma]) }}">{{ $firma->fa_name }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $firma->fa_label }}</td>
                            <td class="d-none d-md-table-cell">@if ($firma->Adresse) {{ $firma->Adresse->ad_anschrift_plz }} - {{ $firma->Adresse->ad_anschrift_ort }} @endif</td>
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
