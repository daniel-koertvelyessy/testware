@extends('layout.layout-admin')

@section('pagetitle')
{{__('Mitarbeiter')}} &triangleright; {{__('Organisation')}} @ bitpack GmbH
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
                <h1 class="h3">{{__('Mitarbeiter')}}</h1>
                <span class="badge badge-light">{{__('Gesamt')}}: {{ $profileList->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__('Nachname')}}</th>
                        <th class="d-none d-md-table-cell">{{__('MA Nummer')}}</th>
                        <th class="d-none d-md-table-cell">{{__('Eingestellt')}}</th>
                        <th>{{__('Telefon')}}</th>
                        <th class="d-none d-md-table-cell">{{__('E-Mail')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($profileList as $profile)
                        <tr>
                            <td><a href="{{ route('profile.show',['profile'=>$profile]) }}">{{ $profile->ma_vorname . ' ' . $profile->ma_name }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $profile->ma_nummer }}</td>
                            <td class="d-none d-md-table-cell">{{ $profile->ma_eingetreten }}</td>
                            <td>{{ $profile->ma_telefon }}</td>
                            <td class="d-none d-md-table-cell">{{ $profile->user->email }} </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                @if(count($profileList)>0) {{ $profileList->links() }}  @endif
            </div>
        </div>
    </div>

@endsection
