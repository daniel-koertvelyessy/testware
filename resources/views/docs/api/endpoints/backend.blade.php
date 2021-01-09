@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#definitions">{{__('Definitionen')}}</a>
    </li>
    <li class="duik-content-nav__item mt-3">
        <strong>Verwaltung</strong>
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
        <a href="#compartments">{{__('Stellplätze')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#products">{{__('Produkte')}}</a>
    </li>
    <li class="duik-content-nav__item mt-3">
        <strong>testWare</strong>
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
                                <p>Möchte man die Anzahl der Datensätze pro Abruf begrenzen so kann man hinter dem Endpunkt ein <span class="badge badge-dark">?per_page=x</span> anfügen. <code>x</code> steuert hierbei die Anzahl der Datensätze pro Seite. </p>
                                <p>Beispiel des Endpunktes für Lagerfächer <code>api/v1/compartment?per_page=10</code></p>
                                <pre><code class="language-json">{
    "data": [
        {
            "id": 1,
            "created": "2021-01-06 22:23:44",
            "updated": "2021-01-06 22:23:44",
            "identifier": "SP.7-ru0rxn",
            "uid": "c9903a08-728a-3067-bf79-ec24ab757713",
            "name": "quos-repudiandae-et-quia-quas-ad-voluptatem-ratione",
            "description": null,
            "type_id": 2,
            "room_id": 9
        },
        },
        {...}
    ],
    "links": {
        "first": "https://testware.io/api/v1/compartment?page=1",
        "last": "https://testware.io/api/v1/compartment?page=5",
        "prev": null,
        "next": "https://testware.io/api/v1/compartment?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "path": "https://testware.io/api/v1/compartment",
        "per_page": "10",
        "to": 10,
        "total": 48
    }
}</code></pre>
                                <p>Das Antwort-Schema der API wird in diesem Fall über drei weitere Elemente <code>data</code> <code>links</code> und <code>meta</code> erweitert.</p>
                                <p><code class="mr-2">data</code> enthält die Datensätze der aktuellen Seite</p>
                                <p><code class="mr-2">links</code> enthält Navigation-Links</p>
                                <p><code class="mr-2">meta</code> enthält Daten, wie die aktelle Seite <span class="badge badge-dark">current_page</span> oder die Gesamtzahl an Datensätzen <span class="badge badge-dark">total</span> </p>
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
                                Verwendetes Übertragungsprotokoll <code>GET</code>, <code>POST</code>, <code>PUT</code> oder <code>DELETE</code>
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
    "Objekt" :{
        "feldname" : "wert",
        "feldname 2" : "wert 2"
    }
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
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Betriebe in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                            <ul class="nav nav-bordered" id="api_get_location-docs-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="api_get_location-docs-tab-scheme" data-toggle="tab" href="#api_get_location-docs-tab-scheme-content" role="tab" aria-controls="api_get_location-docs-tab-tab1-content" aria-selected="false">Senden</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="api_get_location-docs-tab-response" data-toggle="tab" href="#api_get_location-docs-tab-response-content" role="tab" aria-controls="api_get_location-docs-tab-tab2-content" aria-selected="true">Antwort</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="api_get_location-docs-tabContent">
                                <div class="tab-pane bg-light fade p-3" id="api_get_location-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_location-docs-tab-scheme">
                                    -
                                </div>
                                <div class="tab-pane bg-light fade p-3 show active" id="api_get_location-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_location-docs-tab-response">
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
                                </div>
                            </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-location_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Betriebe in der testWare inklusive:
                                <ul>
                                    <li>der kompletten Adresse</li>
                                    <li>leitenden Person </li>
                                    <li>Objekte in dem Betrieb</li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_location_full_list-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_location_full_list-docs-tab-scheme" data-toggle="tab" href="#api_get_location_full_list-docs-tab-scheme-content" role="tab" aria-controls="api_get_location_full_list-docs-tab-tab1-content" aria-selected="false">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_location_full_list-docs-tab-response" data-toggle="tab" href="#api_get_location_full_list-docs-tab-response-content" role="tab" aria-controls="api_get_location_full_list-docs-tab-tab2-content" aria-selected="true">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_location_full_list-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_location_full_list-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_location_full_list-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_location_full_list-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_location_full_list-docs-tab-response">
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
        "manager": {
            "first_name": "Lenard",
            "name": "Hammer",
            "name_2": "Herr Lenard H",
            "employee_number": "1187",
            "date_birth": "1972-09-03",
            "date_entry": "2007-10-12",
            "date_leave": null,
            "phone": "0808862546",
            "mobile": "+5211706111601",
            "fax": null,
            "com_1": null,
            "com_2": null
        },
        "location_objects": {
            "buildings": 2,
            "rooms": 5,
            "compartments": 18,
            "equipment": 738
        }
    },
    {...}
]
                            </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-location_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem Betrieb mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_location_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_location_id-docs-tab-scheme" data-toggle="tab" href="#api_get_location_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_location_id-docs-tab-tab1-content" aria-selected="false">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_location_id-docs-tab-response" data-toggle="tab" href="#api_get_location_id-docs-tab-response-content" role="tab" aria-controls="api_get_location_id-docs-tab-tab2-content" aria-selected="true">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_location_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_location_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_location_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_location_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_location_id-docs-tab-response">
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
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-location">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Erstellt einen Betrieb. Optional mit dazugehöriger Adresse und Leitung.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
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
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_location-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_location-docs-tab-scheme" data-toggle="tab" href="#api_post_location-docs-tab-scheme-content" role="tab" aria-controls="api_post_location-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_location-docs-tab-response" data-toggle="tab" href="#api_post_location-docs-tab-response-content" role="tab" aria-controls="api_post_location-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_location-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_location-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_location-docs-tab-scheme">
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
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_post_location-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_location-docs-tab-response">
                                <pre><code class="language-json">
{
    "status": true,
    "id": 3,
    "uid": "74fc7d7c-04ad-4f12-a5be-07111cd73679",
    "address": 34,
    "employee": 6
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-location_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
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
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_location_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_location_id-docs-tab-scheme" data-toggle="tab" href="#api_put_location_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_location_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_location_id-docs-tab-response" data-toggle="tab" href="#api_put_location_id-docs-tab-response-content" role="tab" aria-controls="api_put_location_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_location_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_location_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_location_id-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "identifier": "bln251",
    "uid": "9f1cf9d5-370b-3413-a51c-c97c2308fe2b",
    "name": "quam-officiis-eligendi-veritatis",
    "description": "Minima maxime omnis cupiditate quas...",
    "address_id": 2,
    "employee_id": 4
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_location_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_location_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 12:26:19",
    "updated": "2021-01-06 18:41:57",
    "identifier": "bln251",
    "uid": "9f1cf9d5-370b-3413-a51c-c97c2308fe2b",
    "name": "quam-officiis-eligendi-veritatis",
    "description": "Minima maxime omnis cupiditate quas...",
    "address_id": 2,
    "employee_id": 4
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-location_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/location/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_delete_location_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_delete_location_id-docs-tab-scheme" data-toggle="tab" href="#api_delete_location_id-docs-tab-scheme-content" role="tab" aria-controls="api_delete_location_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_delete_location_id-docs-tab-response" data-toggle="tab" href="#api_delete_location_id-docs-tab-response-content" role="tab" aria-controls="api_delete_location_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_delete_location_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_delete_location_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_delete_location_id-docs-tab-scheme">
-
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_delete_location_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_delete_location_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "status" : "location deleted"
}
                                </code></pre>
                                    </div>
                                </div>
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
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Gebäude der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_buildings-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_buildings-docs-tab-scheme" data-toggle="tab" href="#api_get_buildings-docs-tab-scheme-content" role="tab" aria-controls="api_get_buildings-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_buildings-docs-tab-response" data-toggle="tab" href="#api_get_buildings-docs-tab-response-content" role="tab" aria-controls="api_get_buildings-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_buildings-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_buildings-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_buildings-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_buildings-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_buildings-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-05 10:44:20",
        "updated": "2021-01-05 10:44:20",
        "identifier": "geb-8200",
        "uid": "2a54b8f9-6ec3-3add-8e96-54f1868e1331",
        "name": "Halle T61",
        "place": "Tor Süd T61",
        "description": "Molestias cupiditate et architecto provident ut libero laborum.....",
        "goods_income_has": true,
        "goods_income_name": "WE-GT61",
        "building_type_id": 1,
        "location_id": 1
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-api-v1-building_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Gebäude der testWare inklusive Gebäudetyp und Betrieb
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_building_list_complete-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_building_list_complete-docs-tab-scheme" data-toggle="tab" href="#api_get_building_list_complete-docs-tab-scheme-content" role="tab" aria-controls="api_get_building_list_complete-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_building_list_complete-docs-tab-response" data-toggle="tab" href="#api_get_building_list_complete-docs-tab-response-content" role="tab" aria-controls="api_get_building_list_complete-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_building_list_complete-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_building_list_complete-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_building_list_complete-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_building_list_complete-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_building_list_complete-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-05 10:44:20",
        "updated": "2021-01-05 10:44:20",
        "identifier": "geb-8200",
        "uid": "2a54b8f9-6ec3-3add-8e96-54f1868e1331",
        "name": "Halle T61",
        "place": "Tor Süd T61",
        "description": "Molestias cupiditate et architecto provident ut libero laborum.....",
        "goods_income_has": true,
        "goods_income_name": "WE-GT61",
        "type": {
            "name": "Lager",
            "description": "Gebäude zur Lagerung von Baugeräten"
        },
        "location": {
            "name": "Werk 12",
            "identifier": "bln153"
        },
        "building_objects": {
            "rooms": 2,
            "compartments": 4,
            "equipment": 226
        }
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-building_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zu einem Gebäude mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_building_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_building_id-docs-tab-scheme" data-toggle="tab" href="#api_get_building_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_building_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_building_id-docs-tab-response" data-toggle="tab" href="#api_get_building_id-docs-tab-response-content" role="tab" aria-controls="api_get_building_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_building_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_building_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_building_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_building_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_building_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "created": "2021-01-05 10:44:20",
    "updated": "2021-01-05 10:44:20",
    "identifier": "geb-8200",
    "uid": "2a54b8f9-6ec3-3add-8e96-54f1868e1331",
    "name": "Halle T61",
    "place": "Tor Süd T61",
    "description": "Molestias cupiditate et architecto provident ut libero laborum.....",
    "goods_income_has": true,
    "goods_income_name": "WE-GT61",
    "type": {
        "name": "Lager",
        "description": "Gebäude zur Lagerung von Maschienen"
    },
    "location": {
        "name": "Werk 12",
        "identifier": "bln153"
    }
}
                            </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-building">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Erstellt ein Gebäude.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
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
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_building-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_building-docs-tab-scheme" data-toggle="tab" href="#api_post_building-docs-tab-scheme-content" role="tab" aria-controls="api_post_building-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_building-docs-tab-response" data-toggle="tab" href="#api_post_building-docs-tab-response-content" role="tab" aria-controls="api_post_building-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_building-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_building-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_building-docs-tab-scheme">
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
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_post_building-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_building-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 7,
    "created": "2021-01-06 19:15:06",
    "updated": "2021-01-06 19:15:06",
    "identifier": "b123435",
    "uid": "430eb8b6-619c-4ebf-8c54-b139b99e7a32",
    "name": "Bürogebäude Zentraleinkauf",
    "place": "Tor Nord",
    "description": null,
    "goods_income_has": true,
    "goods_income_name": null,
    "building_type_id": 1,
    "location_id": 1
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-building_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
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
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_building_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_building_id-docs-tab-scheme" data-toggle="tab" href="#api_put_building_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_building_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_building_id-docs-tab-response" data-toggle="tab" href="#api_put_building_id-docs-tab-response-content" role="tab" aria-controls="api_put_building_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_building_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_building_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_building_id-docs-tab-scheme">
                                        <pre><code class="language-json">
{
    "identifier": "geb-1498",
    "uid": "3e982f3e-4fd2-3dae-b748-f5c19efd1cae",
    "name": "necessitatibus-ullam-eum",
    "place": "5c",
    "description": "Voluptas libero voluptatum vel maxime. Fugiat quod quis vitae saepe quis harum libero eaque. Qui quam et ab voluptatem cum. Ea commodi harum consequatur neque.",
    "goods_income_has": true,
    "goods_income_name": "3",
    "type_id" : 2,
    "location_id" : 1
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_building_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_building_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "created": "2021-01-06 12:26:19",
    "updated": "2021-01-06 20:05:22",
    "identifier": "geb-1498",
    "uid": "3e982f3e-4fd2-3dae-b748-f5c19efd1cae",
    "name": "necessitatibus-ullam-eum",
    "place": "5c",
    "description": "Voluptas libero voluptatum vel maxime. Fugiat quod quis vitae saepe quis harum libero eaque. Qui quam et ab voluptatem cum. Ea commodi harum consequatur neque.",
    "goods_income_has": true,
    "goods_income_name": "3",
    "type": {
        "name": "Werkstatt",
        "description": "Gebäude mit reiner Werkstattnutzung"
    },
    "location": {
        "name": "quam-officiis-eligendi-veritatis",
        "identifier": "bln251"
    }
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-building_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/building/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Antwort</dt>
                            <dd class="col-sm-10">
                                <pre><code class="language-json">
    {
        "status" : "building deleted"
    }
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="rooms">
                    <h2>{{ __('Räume') }}</h2>
                    <p>Folgende Endpunkte sind verfügbar:</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-room"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/room</span>
                        </a>
                        <a href="#endpoint-get-api-v1-room_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/room_list_complete</span>
                        </a>
                        <a href="#endpoint-get-room_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/room/{id}</span>
                        </a>
                        <a href="#endpoint-post-room"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/room</span>
                        </a>
                        <a href="#endpoint-put-room_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/room/{id}</span>
                        </a>
                        <a href="#endpoint-delete-room_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/room/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-room">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Räume der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_room-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_room-docs-tab-scheme" data-toggle="tab" href="#api_get_room-docs-tab-scheme-content" role="tab" aria-controls="api_get_room-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_room-docs-tab-response" data-toggle="tab" href="#api_get_room-docs-tab-response-content" role="tab" aria-controls="api_get_room-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_room-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_room-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_room-docs-tab-scheme">
                                -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_room-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_room-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-06 12:26:19",
        "updated": "2021-01-06 12:26:19",
        "identifier": "rm-142",
        "uid": "3e0b5fb1-423f-383e-b040-9f93d0c47c9d",
        "name": "ipsum",
        "description": "Optio et mollitia tempore consequatur. Magnam debitis doloremque voluptatem pariatur omnis. Alias ut beatae enim aperiam laborum pariatur. Quod voluptate et quis omnis voluptatem et dolorum. Cumque est eum ducimus nemo dolores eos. Nesciunt ut fuga quia et sed assumenda.",
        "building_id": 2,
        "room_type_id": 3
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-api-v1-room_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Räume der testWare inklusive Räumetyp, Details des Gebäude und Anzhal der Objekte des Raums im Zusatzfeld <code>room_objects</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_room_list_complete-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_room_list_complete-docs-tab-scheme" data-toggle="tab" href="#api_get_room_list_complete-docs-tab-scheme-content" role="tab" aria-controls="api_get_room_list_complete-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_room_list_complete-docs-tab-response" data-toggle="tab" href="#api_get_room_list_complete-docs-tab-response-content" role="tab" aria-controls="api_get_room_list_complete-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_room_list_complete-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_room_list_complete-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_room_list_complete-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_room_list_complete-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_room_list_complete-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-05 10:44:20",
        "updated": "2021-01-05 10:44:20",
        "identifier": "rm-117",
        "uid": "1e0cfa36-e485-36c7-8f22-21c83884a442",
        "name": "quis",
        "description": "Amet minus dolorum at reprehenderit velit iste...",
        "type": {
            "identifier": "Material"
        },
        "building": {
            "identifier": "geb-7715",
            "uid": "11a26323-672d-3ebf-92c0-349d1c397f6a",
            "name": "fugit-qui",
            "description": "Et magnam atque quidem ratione qui voluptates..."
        },
        "room_objects": {
            "compartments": 7,
            "equipment": 240
        }
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-room_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem Räume mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_room_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_room_id-docs-tab-scheme" data-toggle="tab" href="#api_get_room_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_room_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_room_id-docs-tab-response" data-toggle="tab" href="#api_get_room_id-docs-tab-response-content" role="tab" aria-controls="api_get_room_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_room_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_room_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_room_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_room_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_room_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-05 10:44:20",
    "updated": "2021-01-05 10:44:20",
    "identifier": "rm-117",
    "uid": "1e0cfa36-e485-36c7-8f22-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "building_id": 2,
    "room_type_id": 3
}
                            </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-room">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Erstellt ein Räume.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#rooms_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="rooms_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="rooms_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>building_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>room_type_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>type</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#rooms_post_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="rooms_post_optional_type"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="rooms_post_optional_type"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_room-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_room-docs-tab-scheme" data-toggle="tab" href="#api_post_room-docs-tab-scheme-content" role="tab" aria-controls="api_post_room-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_room-docs-tab-response" data-toggle="tab" href="#api_post_room-docs-tab-response-content" role="tab" aria-controls="api_post_room-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_room-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_room-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_room-docs-tab-scheme">
                                        <pre><code class="language-json">
{
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "type" : {
        "identifier": "Büro",
        "name": "Räume mit reiner Büronutzung",
        "description": null
    },
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_post_room-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_room-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 15,
    "created": "2021-01-06 20:42:10",
    "updated": "2021-01-06 20:42:10",
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "building_id": 5,
    "room_type_id": 1
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-room_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Raums mit der Referenz <code>{id}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#rooms_put_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="rooms_put_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="rooms_put_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>building_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>room_type_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>type</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#rooms_put_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="rooms_put_optional_type"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="rooms_put_optional_type"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_room_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_room_id-docs-tab-scheme" data-toggle="tab" href="#api_put_room_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_room_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_room_id-docs-tab-response" data-toggle="tab" href="#api_put_room_id-docs-tab-response-content" role="tab" aria-controls="api_put_room_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_room_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_put_room_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_room_id-docs-tab-scheme">
                                <pre><code class="language-json">
{
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "room_type_id" : 2,
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_room_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_room_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 22:23:44",
    "updated": "2021-01-06 23:07:33",
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "room_type_id" : 2,
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-room_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/room/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Löscht den Raum mit der Referenz <code>{id}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Antwort</dt>
                            <dd class="col-sm-10">
                                <pre><code class="language-json">
    {
        "status" : "room deleted"
    }
                                </code></pre>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="compartments">
                    <h2>{{ __('Stellplätze') }}</h2>
                    <p>Folgende Endpunkte sind verfügbar:</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-compartment"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/compartment</span>
                        </a>
                        <a href="#endpoint-get-api-v1-compartment_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/compartment_list_complete</span>
                        </a>
                        <a href="#endpoint-get-compartment_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/compartment/{id}</span>
                        </a>
                        <a href="#endpoint-post-compartment"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/compartment</span>
                        </a>
                        <a href="#endpoint-put-compartment_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/compartment/{id}</span>
                        </a>
                        <a href="#endpoint-delete-compartment_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/compartment/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-compartment">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller {{ __('Stellplätze') }} der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_compartment-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_compartment-docs-tab-scheme" data-toggle="tab" href="#api_get_compartment-docs-tab-scheme-content" role="tab" aria-controls="api_get_compartment-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_compartment-docs-tab-response" data-toggle="tab" href="#api_get_compartment-docs-tab-response-content" role="tab" aria-controls="api_get_compartment-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_compartment-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_compartment-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_compartment-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_compartment-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_compartment-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-06 12:26:19",
        "updated": "2021-01-06 12:26:19",
        "identifier": "rm-142",
        "uid": "3e0b5fb1-423f-383e-b040-9f93d0c47c9d",
        "name": "ipsum",
        "description": "Optio et mollitia tempore consequatur. Magnam debitis doloremque voluptatem pariatur omnis. Alias ut beatae enim aperiam laborum pariatur. Quod voluptate et quis omnis voluptatem et dolorum. Cumque est eum ducimus nemo dolores eos. Nesciunt ut fuga quia et sed assumenda.",
        "building_id": 2,
        "compartment_type_id": 3
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-api-v1-compartment_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Stellplätze der testWare inklusive Stellplatztyp, Details de Raums und Anzhal der Objekte des Stellplatz im Zusatzfeld <code>objects</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_compartment_list_complete-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_compartment_list_complete-docs-tab-scheme" data-toggle="tab" href="#api_get_compartment_list_complete-docs-tab-scheme-content" role="tab" aria-controls="api_get_compartment_list_complete-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_compartment_list_complete-docs-tab-response" data-toggle="tab" href="#api_get_compartment_list_complete-docs-tab-response-content" role="tab" aria-controls="api_get_compartment_list_complete-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_compartment_list_complete-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_compartment_list_complete-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_compartment_list_complete-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_compartment_list_complete-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_compartment_list_complete-docs-tab-response">
                                <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2021-01-05 10:44:20",
        "updated": "2021-01-05 10:44:20",
        "identifier": "rm-117",
        "uid": "1e0cfa36-e485-36c7-8f22-21c83884a442",
        "name": "quis",
        "description": "Amet minus dolorum at reprehenderit velit iste...",
        "type": {
            "identifier": "Material"
        },
        "building": {
            "identifier": "geb-7715",
            "uid": "11a26323-672d-3ebf-92c0-349d1c397f6a",
            "name": "fugit-qui",
            "description": "Et magnam atque quidem ratione qui voluptates..."
        },
        "compartment_objects": {
            "compartments": 7,
            "equipment": 240
        }
    },
    {...}
]
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-compartment_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem {{ __('Stellplatz') }} mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_compartment_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_compartment_id-docs-tab-scheme" data-toggle="tab" href="#api_get_compartment_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_compartment_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_compartment_id-docs-tab-response" data-toggle="tab" href="#api_get_compartment_id-docs-tab-response-content" role="tab" aria-controls="api_get_compartment_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_compartment_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_compartment_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_compartment_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_compartment_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_compartment_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-05 10:44:20",
    "updated": "2021-01-05 10:44:20",
    "identifier": "rm-117",
    "uid": "1e0cfa36-e485-36c7-8f22-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "building_id": 2,
    "compartment_type_id": 3
}
                            </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-compartment">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Erstellt einen Stellplatz.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#compartments_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="compartments_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="compartments_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>building_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>compartment_type_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>type</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#compartments_post_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="compartments_post_optional_type"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="compartments_post_optional_type"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_compartment-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_compartment-docs-tab-scheme" data-toggle="tab" href="#api_post_compartment-docs-tab-scheme-content" role="tab" aria-controls="api_post_compartment-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_compartment-docs-tab-response" data-toggle="tab" href="#api_post_compartment-docs-tab-response-content" role="tab" aria-controls="api_post_compartment-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_compartment-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_compartment-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_compartment-docs-tab-scheme">
                                        <pre><code class="language-json">
{
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "type" : {
        "identifier": "Büro",
        "name": "Räume mit reiner Büronutzung",
        "description": null
    },
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_post_compartment-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_compartment-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 15,
    "created": "2021-01-06 20:42:10",
    "updated": "2021-01-06 20:42:10",
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "building_id": 5,
    "compartment_type_id": 1
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-compartment_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Stellplatzes mit der Referenz <code>{id}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                <p>Erforderliche Felder</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#compartments_put_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="compartments_put_optionals"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="compartments_put_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>uid</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>building_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>compartment_type_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>type</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.identifier</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#compartments_put_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="compartments_put_optional_type"
                                >Optionale Felder
                                </a>
                                <div class="collapse"
                                     id="compartments_put_optional_type"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>type.description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">JSON</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_compartment_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_compartment_id-docs-tab-scheme" data-toggle="tab" href="#api_put_compartment_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_compartment_id-docs-tab-tab1-content" aria-selected="true">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_compartment_id-docs-tab-response" data-toggle="tab" href="#api_put_compartment_id-docs-tab-response-content" role="tab" aria-controls="api_put_compartment_id-docs-tab-tab2-content" aria-selected="false">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_compartment_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_put_compartment_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_compartment_id-docs-tab-scheme">
                                <pre><code class="language-json">
{
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "compartment_type_id" : 2,
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_compartment_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_compartment_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 22:23:44",
    "updated": "2021-01-06 23:07:33",
    "identifier": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "compartment_type_id" : 2,
    "building_id": 5
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-compartment_id">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/compartment/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Variable</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Aufgabe</dt>
                            <dd class="col-sm-10">
                                Löscht den Stellplatz mit der Referenz <code>{id}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Methode</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Felder</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Antwort</dt>
                            <dd class="col-sm-10">
                                <pre><code class="language-json">
    {
        "status" : "compartment deleted"
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
