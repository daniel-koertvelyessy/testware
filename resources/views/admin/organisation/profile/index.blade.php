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
                <h1>Mitarbeiter</h1>
                <span class="badge badge-light">Gesamt: {{ $profileList->total() }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>MA Nummer</th>
                        <th>Nachname</th>
                        <th>Eingestellt</th>
                        <th>Telefon</th>
                        <th>E-Mail</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($profileList as $profile)
                        <tr>
                            <td>{{ $profile->ma_nummer }}</td>
                            <td>{{ $profile->ma_name }}</td>
                            <td>{{ $profile->ma_eingetreten }}</td>
                            <td>{{ $profile->ma_telefon }}</td>
                            <td>{{ $profile->user->email }} </td>
                            <td><a href="{{ route('profile.show',['profile'=>$profile]) }}">öffnen</a></td>
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
