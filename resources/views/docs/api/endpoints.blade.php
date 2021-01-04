@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#definitions">{{__('Definitionen')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#locations">{{__('Standorte')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#buildings">{{__('Gebäude')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#rooms">{{__('Räume')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#storageplace">{{__('Stellplätze')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#products">{{__('Produkte')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#equipment">{{__('Geräte')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#testing">{{__('Prüfungen')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#regulations">{{__('Verordnungen')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#requirements">{{__('Anforderungen')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#testevents">{{__('Vorgänge')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#events">{{__('Ereignisse')}}</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Endpunkte')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Dezember</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <section id="definitions">
                    <article>
                        <h2>Definitionen</h2>
                        <p>Auf dieser Seite finden Sie alle Endpunkte der testware API. Zur leichteren Verwendung finden hier eine Auflistung der verwendeten Nomenklatur nebst einer kurzen Erklärung</p>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Endpunkt</code></dt>
                            <dd class="col-sm-10">
                                Adresse des Endpunktes ohne Domainnamen. Damit der Zurgiff stattfinden kann muss der komplette mit Domainnamen als Adresse verwendet werden. Beispiel: der Endpunkt <code>/api/v1/status</code> würde mit dem Domainnamen <code>https://testware.io</code> müsste als
                                komplette Adressse <code>https://testware.io/api/vi/status</code> lauten.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Variable(n)</code></dt>
                            <dd class="col-sm-10">
                                <p>Wenn zur Identifizierung eines Objektes eine Variable benötigt wird wird dies in <code>{ }</code> angegeben.</p>
                                <p>Beispiel:</p>
                                <p>Für den Endpunkt <code>api/v1/location/{id}</code> ist <code>id</code> die Variable. Ein Objekt mit der id 1 wird dann als <code>api/v1/location/1</code> abgerufen.</p>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Aufgabe</code></dt>
                            <dd class="col-sm-10">
                                Kurze Beschreibung der Aufgabe des Endpunktes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Methode</code></dt>
                            <dd class="col-sm-10">
                                Verwendetes Übertragungsprotokoll GET, POST, PUT oder DELETE
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>JSON</code></dt>
                            <dd class="col-sm-10">
                                <p>JSON Schema für die Antwort der API oder das notwendige Schema zum Senden von Daten zur API. <br>Beispiel für die Antwort des Endpunktes <code>/api/v1/status</code> mit der <code>GET</code> Methode:</p>
                                <pre><code class="language-json">
{
    "status": "OK"
}
                        </code></pre>

                                <div class="duik-callout duik-callout-info mb-5">
                                    <h4 class="h5">Hinweis</h4>
                                    In dem Schema repräsentiert <code>{...}</code> das weitere Datensätze möglich sein können.
                                </div>
                                <div class="duik-callout duik-callout-info mb-5">
                                    <h4 class="h5">Hinweis</h4>
                                    In dem Schema zum Senden von Daten werden alle Felder aufgelistet. Diese können auch optionale Felder enthalten, welche für eine erfolgreiche Transaktion nicht erforderlich sind.
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Feldtyp</code></dt>
                            <dd class="col-sm-10">
                                <p>Felder werden für die Übertragung vom Clienten zur API verwendet. Diese können verschiedene Typen repräsentieren:</p>
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Typ</th>
                                        <th>Name</th>
                                        <th>Beispiel</th>
                                    </tr>
                                    <tr>
                                        <td>Text</td>
                                        <td><span class="badge badge-dark-soft">STRING</span></td>
                                        <td><code>Hallo Welt!</code></td>
                                    </tr>
                                    <tr>
                                        <td>Ganze Zahl</td>
                                        <td><span class="badge badge-dark-soft">INTEGER</span></td>
                                        <td><code>10</code></td>
                                    </tr>
                                    <tr>
                                        <td>Dezinmalzahl</td>
                                        <td><span class="badge badge-dark-soft">FLOAT</span></td>
                                        <td><code>1.3</code></td>
                                    </tr>
                                    <tr>
                                        <td>Boolscher Wert (Wahr/Falsch)</td>
                                        <td><span class="badge badge-dark-soft">BOOLEAN</span></td>
                                        <td><code>true</code> oder <code>false</code></td>
                                    </tr>
                                    <tr>
                                        <td>Objekt</td>
                                        <td><span class="badge badge-dark-soft">OBJECT</span></td>
                                        <td>
                                            <p>Sammlung von weiteren Feldern mit <code>{ }</code> umschlossen.</p>
                                            <pre><code class="language-json">
{
    "feldname" : "wert",
    "feldname 2" : "wert 2"
}
                                        </code></pre>
                                        </td>
                                    </tr>
                                </table>
                                <div class="duik-callout duik-callout-info mb-5">
                                    <h4 class="h5">Hinweis</h4>
                                    Manche Felder haben einen voreingestellten Wert. Dieser wird mit <span class="badge badge-dark-soft">DEFAULT</span> gekennzeichnet. Wenn ein Feld explizit leer gelassen werden soll ist der Wert <code>null</code> einzutragen.
                                </div>


                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2"><code>Felder</code></dt>
                            <dd class="col-sm-10">
                                <p> Listet alle <code>Felder</code> mit dem entsprechendem <span class="badge badge-dark-soft">Typ</span>. Sollten Felder zwingend notwendig sein, werden diese gesondert als <code>Erforderliche Daten</code> ausgewiesen.</p>
                                <p><code>Felder</code> die innerhalb eines <span class="badge badge-dark-soft">OBJECT</span> Typs werden mit dem Namen des Objektfeldes mit einem <code>.</code> als Präfix versehen.</p>
                                <p>Beispiel für folgendes Objekt: </p>
                                <pre><code class="language-json">
{
    "location" : {
        "name" : "Werk 1"
    }
}
                                        </code></pre>
                                <p>Das Feld für <code>name</code> wird mit <code>location.name</code> referenziert.</p>
                                <div class="duik-callout duik-callout-warning my-5">
                                    <h4 class="h5">Wichtig für das Anlegen von Datensätzen</h4>
                                    <p class="mb-0">Ist ein Feld vom Typ <span class="badge badge-dark-soft">OBJECT</span> angegeben, sind zwei verschiedene Möglichkeiten verfügbar:</p>
                                    <h5 class="h6 mt-2">Angabe als Objekt</h5>
                                    <p>Verwendet man das Feld als Objekt muss die entsprechende Struktur angegeben werden. Das System prüft, ob ein Datensatz mit der entsprechenden Referenz existiert und legt gegebenefalls einen neuen Datensatz an.</p>

                                    <h5 class="h6 mt-2">Angabe mit Referenz-ID</h5>
                                    <p>Ist die Referenz-ID bekannt, so kann diese direkt angegeben werden. Hierzu muss dem Feldnamen ein <code>_id</code> angehängt werden.</p>
                                    <p>Aus dem obigen Beispiel würde:</p>
                                    <pre><code class="language-json">
{
    "location_id" : 1
}
                                        </code></pre>

                                </div>
                                <div class="duik-callout duik-callout-info mb-5">
                                    <h4 class="h5">Hinweis</h4>
                                    <p class="mb-0">Sind keine Felder zur Übertragung zur API notwendig bleibt die Spalte leer.</p>
                                </div>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="locations">
                    <h2>{{ __('Standorte') }}</h2>
                    <p>Folgende Endpunkte sind verfügbar:</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-location"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/location</span>
                        </a>
                        <a href="#endpoint-get-location_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/location_list_complete</span>
                        </a>
                        <a href="#endpoint-get-location_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/location/{id}</span>
                        </a>
                        <a href="#endpoint-post-location"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/location</span>
                        </a>
                        <a href="#endpoint-put-location_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/location/{id}</span>
                        </a>
                        <a href="#endpoint-delete-location_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/location/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-location">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Abrufen aller Betriebe in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "identifier": "bln153",
        "description": "Hauptsitz der Firma Testfirma GmbH",
        "address_id": 2,
        "employee_id": 4
    },
    {...}
]
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-location_list_complete">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Abrufen aller Betriebe inklusive der kompletten Adresse und leitenden Person in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                            <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "identifier": "bln153",
        "description": "Hauptsitz der Firma Testfirma GmbH",
        "address": {
            "type": {
                "name": "Heimadress",
                "description": "Standard Adresse"
            },
            "identifier": "Gmb5423212",
            "name": "Deckerweg 5/8 15868 Neukirchen-Vluyn",
            "company": "Testfirma GmbH",
            "company_2": null,
            "company_co": null,
            "company_unloading_point": null,
            "company_goods_income": null,
            "company_division": "UWTZIZ79",
            "street": "Christiane-Brandt-Platz",
            "no": "67",
            "zip": "63550",
            "city": "Bruchsal",
            "floor": null,
            "enterance": null
        },
        "employee": {
            "first_name": "Anja",
            "name": "Janssen",
            "name_2": "Frau Adele Fleischer",
            "employee_number": "1526",
            "date_birth": "2001-10-04",
            "date_entry": "2013-06-05",
            "date_leave": null,
            "phone": "+49 (0) 6180 690281",
            "mobile": "+2556088034473",
            "fax": null,
            "com_1": null,
            "com_2": null
        }
    },
    {...}
]
                            </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-location_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Ruft die Daten zum einem Betrieb mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                            <pre><code class="language-json">
{
    "created": "2020-12-29 11:30:16",
    "updated": "2021-01-03 19:10:04",
    "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
    "name": "HQbln153",
    "identifier": "bln153",
    "description": "Hauptsitz der Firma Testfirma GmbH",
    "address_id": 2,
    "employee_id": 4
}
                            </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-location">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Erstellt einen Betrieb mit dazugehöriger Adresse und Leitung.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#locations_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="locations_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="locations_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address</code> <span class="badge badge-dark-soft">OBJECT</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee</code> <span class="badge badge-dark-soft">OBJECT</span>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>address</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>address.identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>address.street</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>address.no</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>address.zip</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>address.city</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#address_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="address_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="address_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.address_type</code>  <span class="badge badge-dark-soft">OBJECT</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company_2</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company_co</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company_unloading_point</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company_goods_income</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address.company_division</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>

                                <p class="mt-3">Wird das Objekt <code>employee</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>employee.name</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#employees_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="employees_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="employees_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.first_name</code> <span>
                                            </span> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.name_2</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.date_birth</code> <span>
                                                <span class="badge badge-dark-soft">Datum</span> <code>{{ date('Y-m-d') }}</code>
                                            </span> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.employee_number</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.date_entry</code> <span>
                                                <span class="badge badge-dark-soft">Datum</span> <code>{{ date('Y-m-d') }}</code>
                                            </span> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.date_leave</code> <span>
                                                <span class="badge badge-dark-soft">Datum</span> <code>{{ date('Y-m-d') }}</code>
                                            </span> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.phone</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.mobile</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.fax</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.com_1</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee.com_2</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Struktur</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
{
    "name": "Loc-bln153",
    "identifier": "bln153",
    "description": "Nihil aut qui nostrum ...",
    "address": {
        "street": "Christiane-Brandt-Platz",
        "no": "67",
        "zip": "63550",
        "city": "Bruchsal",
        "address_type": {
            "name" : "Hausadresse"
        },
        "identifier": "Gmb5423212",
        "name": "Hausadresse Barth GmbH",
        "company": "Barth GmbH",
        "company_2": null,
        "company_co": null,
        "company_unloading_point": null,
        "company_goods_income": null,
        "company_division": "UWTZIZ79",
        "floor": null,
        "enterance": null
    },
    "employee": {
        "first_name": "Anja",
        "name": "Janssen",
        "name_2": "Fleischer",
        "date_birth": "2001-10-04",
        "employee_number": "1526",
        "date_entry": "2013-06-05",
        "date_leave": null,
        "phone": "+496180690281",
        "mobile": "+496180690281",
        "fax": "+496180690281",
        "com_1": null,
        "com_2": null
    }
}
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-location_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#locations_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="locations_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="locations_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>address_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>employee_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Struktur</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
{
    "identifier": "bln153",
    "name": "Loc-bln153",
    "description": "Nihil aut qui nostrum ...",
    "uid": "e05d683e-976d-4509-8486-09cb96e78134",
    "address_id" : 1,
    "employee_id" : 1
}
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-location_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
{
    "status" : "location deleted"
}
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="buildings">
                    <h2>{{ __('Gebäude') }}</h2>
                    <p>Folgende Endpunkte sind verfügbar:</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-building"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/building</span>
                        </a>
                        <a href="#endpoint-get-api-v1-building_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/building_list_complete</span>
                        </a>
                        <a href="#endpoint-get-building_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/building/{id}</span>
                        </a>
                        <a href="#endpoint-post-building"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/building</span>
                        </a>
                        <a href="#endpoint-put-building_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/building/{id}</span>
                        </a>
                        <a href="#endpoint-delete-building_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/building/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-building">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Abrufen aller Gebäude der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2020-12-29 11:30:16",
        "identifier": "geb-4027",
        "name": "Werkstatt Kfz",
        "location": null,
        "description": "Veritatis quasi sit beatae perspiciatis ut tempore. Cupiditate qui consectetur quia odio accusantium.",
        "goods_income_has": false,
        "goods_income_name": null
    },
    {...}
]
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-api-v1-building_list_complete">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Abrufen aller Gebäude der testWare inklusive Gebäudetyp und Betrieb
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2020-12-29 11:30:16",
        "identifier": "geb-4027",
        "uid": "1c077d5b-2ed5-3ad7-b08f-0c66e31255cb",
        "name": "deleniti-reiciendis-est",
        "place": "521",
        "description": "Veritatis quasi sit beatae perspiciatis ut tempore. Cupiditate qui consectetur quia odio accusantium. Et enim rerum ut at illum quis reprehenderit. Consectetur accusamus animi modi illo amet sed quo et. Neque quod voluptatem maxime rem laborum. Voluptas libero ut id sunt voluptatem velit. Consequatur fugiat deserunt ut maxime quas nam.",
        "goods_income_has": false,
        "goods_income_name": null,
        "type": {
            "name": "Büro",
            "description": "Gebäude mit reiner Büronutzung"
        },
        "location": {
            "name": "neuer Name 6",
            "identifier": "bln153"
        }
    },
    {...}
]
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-building_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Ruft die Daten zum einem Gebäude mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                            <pre><code class="language-json">
{
    "created": "2020-12-29 11:30:16",
    "updated": "2020-12-29 11:30:16",
    "identifier": "geb-4027",
    "uid": "1c077d5b-2ed5-3ad7-b08f-0c66e31255cb",
    "type": {
        "name": "Büro",
        "description": "Gebäude mit reiner Büronutzung"
    },
    "name": "deleniti-reiciendis-est",
    "place": "521",
    "description": "Veritatis quasi sit beatae perspiciatis ut tempore. Cupiditate qui consectetur quia odio accusantium.",
    "goods_income_has": false,
    "goods_income_name": null
}
                            </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-building">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Erstellt ein Gebäude.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>goods_income_has</code> <span class="badge badge-dark-soft">BOOLEAN</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#buildings_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="buildings_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="buildings_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>place</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type</code> <span class="badge badge-dark-soft">OBJECT</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>location_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.name</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#buildings_put_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="buildings_put_optional_type"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="buildings_put_optional_type"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Struktur</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
{
    "identifier" : "b12345",
    "goods_income_has" : false,
    "uid" : "430eb8b6-619c-4ebf-8c54-b139b99e7a33",
    "type" : {
        "name": "Büro",
        "description": "Gebäude mit reiner Büronutzung"
    },
    "name" : "Gebäude 12345",
    "place" : "Tor Nord",
    "description" : "Bürogebäude Zentraleinkauf",
    "goods_income_name" : null,
    "location_id" : 1
}
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-building_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>goods_income_has</code> <span class="badge badge-dark-soft">BOLEAN</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#buildings_put_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="buildings_put_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="buildings_put_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>goods_income_name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>place</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>location_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
{
    "created": "2021-01-04 22:53:55",
    "updated": "2021-01-04 23:06:55",
    "identifier": "geb-402ghz7323",
    "uid": "430eb8b6-619c-4ebf-8c54-b139b99e7a33",
    "type": {
        "name": "Büro",
        "description": "Gebäude mit reiner Büronutzung"
    },
    "name": null,
    "place": null,
    "description": null,
    "goods_income_has": true,
    "goods_income_name": null
}
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-building_id">
                        <dl class="row">
                            <dt class="col-sm-3">Endpunkt</dt>
                            <dd class="col-sm-9">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Variable</dt>
                            <dd class="col-sm-9">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Aufgabe</dt>
                            <dd class="col-sm-9">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Methode</dt>
                            <dd class="col-sm-9">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Felder</dt>
                            <dd class="col-sm-9">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-3">Antwort</dt>
                            <dd class="col-sm-9">
                                <pre><code class="language-json">
    {
        "status" : "building deleted"
    }
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                </section>
            </div>
        </div>
    </div>
@endsection
