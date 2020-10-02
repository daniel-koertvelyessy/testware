@extends('layout.layout-admin')

@section('pagetitle')
    Benutzer &triangleright;   @ bitpack.io GmbH
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
            <li class="breadcrumb-item active" aria-current="page">Benutzer</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3">Übersicht Benutzer</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-rtextfield id="name" label="Benutzername" value="{{ $user->name }}" />
                <x-emailfield id="email" label="E-Mail Adresse" value="{{ $user->email }}" />
                <x-textfield id="username" label="Anmeldename" value="{{ $user->username }}" />
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <x-datepicker id="created_at" label="Erstellt" value="{{ $user->created_at }}" />
            </div>
            <div class="col-md-4">
                <x-datepicker id="updated_at" label="Aktualisiert" value="{{ $user->updated_at }}" />
            </div>
            <div class="col-md-4">
                <x-datepicker id="deleted_at" label="Gelöscht" value="{{ $user->deleted_at }}" />
            </div>

        </div>
        <x-btnMain>Nutzerdaten aktualisieren <span class="fas fa-download"></span></x-btnMain>

        <div class="row mt-3">
            <div class="col">
                <h2 class="h4">Passwort zurücksetzen</h2>
                <form action="{{ route('user.resetPassword') }}">
                    <x-rtextfield id="newPassword" label="Neues Passwort"/>
                    <x-btnSave>Passwort setzen</x-btnSave>
                </form>
            </div>
        </div>
    </div>

@endsection
