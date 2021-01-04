@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#doc-about">About</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Dokumentation')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Oktober</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <p>{{__('Hier finden Sie die Dokumentation zu den verfügbaren Applikationen')}}</p>
                <p>Die Objekte in der testware werden in zwei Bereichen gepflegt:</p>
                <ul>
                    <li>Verwaltung</li>
                    <li>Anwendung</li>
                </ul>
                <p>Die Verwaltung ist über das
                    <a href="/">Portal</a>
                   in den Register <code>Verwaltung</code> zu finden.
                </p>

                <img src="{{ asset('img/media/textware_docs_Verwaltung_oeffnen.gif') }}"
                     alt="Im Portal kann man mit einem Klick auf die Schaltfläche [Verwaltung] die Module der Verwaltung sehen und auswählen."
                     class="img-fluid img-thumbnail"
                >
                <div class="duik-callout duik-callout-info mb-5">
                    <h4 class="h5">Hinweis</h4>
                    <p class="mb-0">Die Abbildungen in dieser Dokumentation können sich in Form und Farbe von der Darstellung in Ihrem Profil unterscheiden.</p> https://www.json.org/json-de.html
                </div>

                <p>In der Verwaltung werden folgende Module gepflegt:</p>
                <ul>
                    <li>Standorte</li>
                    <li>Gebäude</li>
                    <li>Räume</li>
                    <li>Stellplätze</li>
                    <li>Produkte</li>
                    <li>Verordnungen</li>
                    <li>Anforderungen</li>
                </ul>

            </div>
        </div>
    </div>
@endsection
