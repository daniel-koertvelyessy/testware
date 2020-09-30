@extends('layout.layout-admin')

@section('pagetitle')
    Bitte anmelden @ bitpack GmbH
@endsection

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Portal</a></li>
    <li class="breadcrumb-item active" aria-current="page">Standortverwaltung</li>
  </ol>
</nav>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Standortverwaltung</h1>
                <p class="lead">Der Zugang zur Standortverwaltung erfordert eine Authorisierung. Bitte melden Sie sich mit Ihrem Benutzernamen und Passwort an!</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form method="post" action="/location/index">
                    @csrf
                    @method('GET')
                    <div class="mb-3">
                        <label for="logInUserName" class="form-label">Benutzername</label>
                        <input type="email" class="form-control form-control-lg" id="logInUserName" name="logInUserName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="logInUserPassword" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="logInUserPassword" name="logInUserPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">Anmelden</button>
                </form>
            </div>
        </div>
    </div>

@endsection
