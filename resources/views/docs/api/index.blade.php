@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
        <li class="duik-content-nav__item">
            <a href="#api-start">Kurze Einführung</a>
        </li>
        <li class="duik-content-nav__item">
            <a href="#api-endpoint">Endpunkte</a>
        </li>
        <li class="duik-content-nav__item">
            <a href="#api-json">JSON Daten</a>
        </li>
        <li class="duik-content-nav__item">
            <a href="#api-script-js">Beispiel Code</a>
        </li>
        <li class="duik-content-nav__item">
            <a href="#api-token-make">API Token erzeugen</a>
        </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('API')}} V1</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Dezember</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <h2 id="api-start">Kurze Einführung</h2>
                <p>testWare bietet neben der Weboberfläche auch eine sogenannte REST-API. Die Abkürzung <code>API</code> steht für
                    <code>Application Program Interface</code> und beschreibt, eine Schnittstelle zu einem Programm. Diese Schnittstelle ermöglicht die REST Kommunikation mit der Datenbank der testWare ohne einen Browser.</p>

                <p>Im Gegensatz zu der Weboberfläche, welche eine einmalige Authentifizierung eines Benutzers erfordert, muss die Authentifizierung mit jedem Aufruf erfolgen. Die API der testware verwendet hierzu eine 80 Zeichen lange Kette von Zahlen und Buchstaben, die auch <code>Token</code> genannt wird. Dieser Token kann für jeden registrierten Benutzer der testware in der Account-Oberfläche generiert werden.</p>
                <p>Für einen Zugriff muss dieser als <code>Bearer</code> im Request angegeben werden. Im Beispiel unten wird ein Zugriff auf die API mit <code>jQuery</code> hergestellt, um einen neuen Betrieb mit Adresse anzulegen.</p>
                <h2 id="api-endpoint">Endpunkte</h2>
                <p>Im Gegensatz zur Darstellung der testware im Browser, besitzt die API keine Navigation, welche man über Links erreichen kann. Die API benutzt hierzu sogenannte Endpunkte.</p>
                <p>Diese Endpunkte bestehen aus der Kombination einer Webadresse und einer Übertragungsart (engl. <code>method</code>). Die Webadresse stellt sich aus der Domäne z.B.  <span class="badge badge-dark">testware.io</span>, einem sogenannten Präfix und dem Namen zusammen. Die aktuelle Version der testware API ist V1, das entsprechende Präfix lautet <span class="badge badge-dark">api/v1/</span>  und der Name z.B. <span class="badge badge-dark">locations</span>. Die Webadresse lautet demnach <span class="badge badge-dark">testware.io/api/v1/locations</span>. </p>
                <p>Die Übertragungsart bezieht sich auf die verschiedene http Request Arten beispielsweise
                    <code>GET</code>,
                <code>POST</code> oder
            <code>DELETE</code>. </p>
                <h3 class="h5" id="api-rest">Was ist REST?</h3>
                <p><strong>REST</strong> steht für <strong>RE</strong>presentational <strong>S</strong>tate <strong>T</strong>ransfer. Dies beschreibt einen Architekturansatz, wie verteilte Systeme miteinander kommunizieren können. REST selbst ist dabei allerdings weder Protokoll noch Standard. Als „RESTful“ charakterisierte Implementierungen der Architektur bedienen sich allerdings standardisierter Verfahren, wie HTTP/S, URI, JSON oder XML.</p>
                <p>Die unterstützten HTTP-Methoden lauten: </p>
                <ul>
                    <li><code>GET</code> - fordert Daten vom Server an</li>
                    <li><code>POST</code> - übermittelt Daten an den Server</li>
                    <li><code>PUT/PATCH</code> - ändern bestehende Daten auf dem Server</li>
                    <li><code>DELETE</code> - löscht bestehende Daten auf dem Server</li>
                </ul>
                <p>Eine Auflistung aller Endpunkte der aktuellen Version inklusive der JSON Struktur finden Sie im Menüpunkt <a href="{{ route('docs.api.endpoints') }}">{{ __('Endpunkte') }}</a>.</p>

                <h2 id="api-json">JSON Daten</h2>
                <p>Die Daten, welche durch die API zwischen der Datenbank und der Anwendung ausgetauscht werden, sind im weit verbreiteten JSON Format gehalten. JSON ermöglicht, verschachtelte Werte in Textform darzustellen. Dieses vereinfacht die Übertragung komplexerer Datenstrukturen über das Internet.</p>
                <p>JSON ist im einfachsten Fall ein <code>Schlüssel : Wert</code>  (engl. <strong>key : value</strong>)  Paar, welches mit einem <code>:</code> getrennt und mit <code>{}</code> Klammern umschlossen wird. Mehrere Paare werden mit einem Komma getrennt. </p>

<pre><code class="language-json">{
    "key-1" : "value",
    "key-2" : 231.0
}</code></pre>

                <p>Als Werte können praktisch alle Arten von Daten darstellen, wie Texte, Zahlen (Kommazahlen mit <code>.</code> statt einem <code>,</code> oder auch weitere Schlüssel:Wert Paare.</p>

<pre><code class="language-json">{
    "key" : {
        "subkey" : "value",
        "subkey2" : 231.2
    }
}</code></pre>

                <p>Eine einfache Abfrage der Datenbank per jQuery zur Auflistung aller Betriebe in der Datenbank mittels:</p>

<pre><code class="language-js">var settings = {
  "url": "testware.test/api/v1/location",
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Accept": "application/json",
    "Authorization": "Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx",
    "Content-Type": "application/json"
  }
};

$.ajax(settings).done(function (response) {
  console.log(response);
});</code></pre>

                <p>Die Antwort der API packt die Daten in ein <code>data</code> Objekt (erkennbar duch die Einfassung der Schlüssel: Wert Paare mit <code>{}</code> Klammern.</p>

<pre><code class="language-json">{
    "id": 1,
    "name": "Werk Bruchsal",
    "adresse": {
        "strasse": "Christiane-Brandt-Platz",
        "nr": "67",
        "plz": "63550",
        "ort": "Bruchsal"
    }
}</code></pre>

                <p>Eine Sammlung von Datensätzen wird mit <code>[]</code> Klammern umfasst. Die einzelnen Datensäte mit <code>,</code> getrennt.</p>
<pre><code class="language-json">[
    {
        "id": 1,
        "name": "Werk Bruchsal",
        "adresse": {
            "strasse": "Christiane-Brandt-Platz",
            "nr": "67",
            "plz": "63550",
            "ort": "Bruchsal"
        }
    },
    {
        "id": 2,
        "name": "Werk Brechtersfeld",
        "adresse": {
            "strasse": "Malbachplatz",
            "nr": "1",
            "plz": "08152",
            "ort": "Brechtersfeld"
        }
    },
    {...}
]</code></pre>
                <div class="duik-callout duik-callout-info mb-5">
                    <h4 class="h5">Hinweis</h4>
                    <p class="mb-0">Die obige Beschreibung ist für einen schnellen Einstieg einfach gehalten. Eine komplette Beschreibung des JSON Formates finden Sie auf der offiziellen Seite <a href="https://www.json.org/json-de.html" target="_blank">https://www.json.org/json-de.html</a>.</p>
                </div>
                <h2 id="api-script-js">Codebeispiel für API Zugriff</h2>
                <p>Als Beispiel soll ein neuer Betrieb mit einer dazugehörigen Adresse angelegt werden. Die JSON Daten, welche zur API mit der auf den Endpunkt <code>testware.test/api/v1/location</code> mit der <code>POST</code> Methode gesendet werden sollen lauten:</p>

<pre><code class="language-json">{
    "bezeichner":"kleve021M",
    "name":"Mein neuer Betrieb",
    "adresse":{
        "name_kurz":"klv021",
        "strasse":"Klever Berg",
        "nr":21,
        "plz":"47533",
        "ort":"Kleve"
    }
}</code></pre>

                <p>Der API Zugriff mit <code>jQuery</code> könnte mit folgendem Code ausgeführt werden:</p>
                <ul class="nav nav-bordered" id="docs-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="docs-tab-jQuery" data-toggle="tab" href="#docs-tab-jQuery-content" role="tab" aria-controls="docs-tab-jQuery-content" aria-selected="true">JavaScript</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab-curl" data-toggle="tab" href="#docs-tab-curl-content" role="tab" aria-controls="docs-tab-curl-content" aria-selected="false">php cURL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab-python" data-toggle="tab" href="#docs-tab-python-content" role="tab" aria-controls="docs-tab-python-content" aria-selected="false">Python</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab-dart" data-toggle="tab" href="#docs-tab-dart-content" role="tab" aria-controls="docs-tab-dart-content" aria-selected="false">Dart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="docs-tab-java" data-toggle="tab" href="#docs-tab-java-content" role="tab" aria-controls="docs-tab-java-content" aria-selected="false">Java</a>
                    </li>

                </ul>
                <div class="tab-content" id="docs-tabContent">
                    <div class="tab-pane bg-light fade p-3 show active" id="docs-tab-jQuery-content" role="tabpanel" aria-labelledby="docs-tab-jQuery">

<pre><code class="language-js">var data = JSON.stringify({"bezeichner":"kleve021M","name":"Mein neuer Betrieb","adresse":{"name_kurz":"klv021","strasse":"Klever Berg","nr":21,"plz":"47533","ort":"Kleve"}});

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function() {
  if(this.readyState === 4) {
    console.log(this.responseText);
  }
});

xhr.open("POST", "testware.test/api/v1/location");
xhr.setRequestHeader("Accept", "application/json");
xhr.setRequestHeader("Authorization", "Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx");
xhr.setRequestHeader("Content-Type", "application/json");

xhr.send(data);</code></pre>

                    </div>
                    <div class="tab-pane bg-light fade p-3" id="docs-tab-curl-content" role="tabpanel" aria-labelledby="docs-tab-curl">

<pre><code class="language-php">$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'testware.test/api/v1/location',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "bezeichner" : "kleve021M",
    "name" : "Mein neuer Betrieb",
    "adresse":{
        "name_kurz" : "klv021",
        "strasse" : "Klever Berg",
        "nr":21,
        "plz":"47533",
        "ort":"Kleve"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;</code></pre>

                    </div>
                    <div class="tab-pane bg-light fade p-3 show" id="docs-tab-python-content" role="tabpanel" aria-labelledby="docs-tab-python">

<pre><code class="language-python">import http.client

conn = http.client.HTTPSConnection("testware.test")
payload = "{\r\n    \"bezeichner\" : \"kleve021M\",\r\n    \"name\" : \"Mein neuer Betrieb\",\r\n    \"adresse\":{\r\n        \"name_kurz\" : \"klv021\",\r\n        \"strasse\" : \"Klever Berg\",\r\n        \"nr\":21,\r\n        \"plz\":\"47533\",\r\n        \"ort\":\"Kleve\"\r\n    }\r\n}"
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx',
  'Content-Type': 'application/json'
}
conn.request("POST", "/api/v1/location", payload, headers)
res = conn.getresponse()
data = res.read()
print(data.decode("utf-8"))</code></pre>

                    </div>
                    <div class="tab-pane bg-light fade p-3 show" id="docs-tab-dart-content" role="tabpanel" aria-labelledby="docs-tab-dart">

<pre><code class="language-dart">var headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx',
  'Content-Type': 'application/json'
};
var request = http.Request('POST', Uri.parse('testware.test/api/v1/location'));
request.body = '''{\r\n    "bezeichner" : "kleve021M",\r\n    "name" : "Mein neuer Betrieb",\r\n    "adresse":{\r\n        "name_kurz" : "klv021",\r\n        "strasse" : "Klever Berg",\r\n        "nr":21,\r\n        "plz":"47533",\r\n        "ort":"Kleve"\r\n    }\r\n}''';
request.headers.addAll(headers);

http.StreamedResponse response = await request.send();

if (response.statusCode == 200) {
  print(await response.stream.bytesToString());
}
else {
  print(response.reasonPhrase);
}</code></pre>

                    </div>
                    <div class="tab-pane bg-light fade p-3 show" id="docs-tab-java-content" role="tabpanel" aria-labelledby="docs-tab-java">

<pre><code class="language-java">OkHttpClient client = new OkHttpClient().newBuilder()
  .build();
MediaType mediaType = MediaType.parse("application/json");
RequestBody body = RequestBody.create(mediaType, "{\r\n    \"bezeichner\" : \"kleve021M\",\r\n    \"name\" : \"Mein neuer Betrieb\",\r\n    \"adresse\":{\r\n        \"name_kurz\" : \"klv021\",\r\n        \"strasse\" : \"Klever Berg\",\r\n        \"nr\":21,\r\n        \"plz\":\"47533\",\r\n        \"ort\":\"Kleve\"\r\n    }\r\n}");
Request request = new Request.Builder()
  .url("testware.test/api/v1/location")
  .method("POST", body)
  .addHeader("Accept", "application/json")
  .addHeader("Authorization", "Bearer C1VF6Lx5sWeqC6nlVihwS5GuujkflFg9qSK2WhQkXrSgLbRAPtinAJQfhGViywcz80VDO7akePXOhcWx")
  .addHeader("Content-Type", "application/json")
  .build();
Response response = client.newCall(request).execute();</code></pre>

                    </div>
                </div>

                <h2 id="api-token-make">API Token herstellen</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p>Sie können einen API-Token für Ihr Benutzerkonto einfach in der eigenen Kontoübersicht herstellen. Hierzu melden Sie sich in der testWare an. Anschließend klicken auf Ihren Benutzernamen in der oberen rechten Ecke. Aus dem Menü wählen Sie den Eintrag
                            <span class="badge badge-dark">Mein Konto <i class="fas fa-user"></i></span> aus. </p>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('img/docu/api_token_step1.png') }}"
                             alt="{{ __('Öffnen der Benutzerseite') }}"
                             class="img-fluid img-thumbnail"
                        >
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <p>In der Kontoübersicht finden Sie den Abschnitt
                            <strong>Token für API-Zugang</strong>. Wenn Sie noch keinen Token erstellt haben, wird ein Schalter
                            <span class="badge badge-dark">Token für API erzeugen</span> gezeigt. Mit einem Klick auf diesem Schalter wird der Token erstellt und dem Konto zugeordnet.</p>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('img/docu/api_make_token.png') }}"
                             alt="{{ __('API Token erstellen') }}"
                             class="img-fluid img-thumbnail"
                        >
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <p>Den Token können Sie aus dem Textfeld herauskopieren und für ihre jeweilige Anwendung verwenden.</p>
                        <p>Sollte es erforderlich sein, den Token neu ausstellen zu lassen, können Sie dies mit einem Klick auf den Schalter <span class="badge badge-dark"><i class="fas fa-redo-alt"></i></span> erreichen.</p>
                        <div class="duik-callout duik-callout-warning mb-5">
                            <h4 class="h5">Wichtiger Hinweis!</h4>
                            <p class="mb-0">Bitte beachten Sie, dass mit der Ausstellung eines neuen Tokens alle Zugriffe auf die testWare API mit dem neuen Token erfolgen müssen. Zugriffe mit dem alten Token werden abgewiesen. Der alte Token ist nicht mehr reproduzierbar.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('img/docu/api_show_token.png') }}"
                             alt="{{ __('Anzeigen des API Token') }}"
                             class="img-fluid img-thumbnail"
                        >
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
