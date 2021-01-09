@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#definitions">{{__('Definitionen')}}</a>
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
                        <p>Auf den folgenden Seiten finden Sie alle Endpunkte der testware API. Zur leichteren Verwendung finden hier eine Auflistung der verwendeten Nomenklatur nebst einer kurzen Erklärung</p>
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
            </div>
        </div>
    </div>
@endsection
