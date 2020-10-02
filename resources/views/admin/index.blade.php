@extends('layout.layout-admin')

@section('pagetitle')
    Systemeinstellungen | Start @ bitpack GmbH
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
                <h1 class="h3">Übersicht Systemverwaltung</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h2 class="h4">Benutzer</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Benutername</th>
                        <th>Erstellt am</th>
                        <th>Rolle</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (App\User::all() as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td><span class="text-truncate" >{{ $user->created_at }}</span></td>
                            <td><span>{{ $user->role_id }}</span></td>
                            <td><a href="/user/{{ $user->id }}">bearbeiten</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
            <div class="col-lg-6">
                <h2 class="h4">Objekt Typen</h2>
                <h3 class="h5">Adressen</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kurzname</th>
                        <th>Erstellt am</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (App\AddressType::all() as $aditem)
                        <tr>
                            <td>{{ $aditem->adt_name  }}</td>
                            <td><span class="text-truncate" >{{ $aditem->created_at }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <h3 class="h5">Gebäude</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kurzname</th>
                        <th>Erstellt am</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (App\BuildingTypes::all() as $aditem)
                        <tr>
                            <td>{{ $aditem->btname  }}</td>
                            <td><span class="text-truncate" >{{ $aditem->created_at }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <h3 class="h5">Räume</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kurzname</th>
                        <th>Erstellt am</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (App\RoomType::all() as $aditem)
                        <tr>
                            <td>{{ $aditem->rt_name_kurz  }}</td>
                            <td><span class="text-truncate" >{{ $aditem->created_at }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <h3 class="h5">Stellplätze</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kurzname</th>
                        <th>Erstellt am</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (App\StellplatzTyp::all() as $aditem)
                        <tr>
                            <td>{{ $aditem->lot_name_kurz  }}</td>
                            <td><span class="text-truncate" >{{ $aditem->created_at }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

@endsection
