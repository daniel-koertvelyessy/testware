@extends('layout.layout-admin')

@section('pagetitle')
    Benutzer &triangleright;  Systemeinstellungen | Start @ bitpack GmbH
@endsection

@section('mainSection')
    Admin
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verwaltung</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Benutzer</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-responsive-md table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Benutzername</th>
                        <th>Status</th>
                        <th>Erstellt</th>
                        <th>Rolle</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse (App\User::all() as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->role_id }}</td>
                            <td><a href="{{ route('user.show',$user->id) }}">bearbeiten</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>Keine Benutzer erstellt! Wer hat sich denn dann angemeledet?????</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>

@endsection
