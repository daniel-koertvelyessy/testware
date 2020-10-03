@extends('layout.layout-login')

@section('pagetitle')
    Bitte anmelden @ bitpack GmbH
@endsection



@section('target-app-menu-item')
    <li class="nav-item active">
        <a class="nav-link" href="location">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
            </svg>
            Standort</a>
    </li>
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
