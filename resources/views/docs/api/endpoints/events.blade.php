@extends('layout.layout-documentation')

@section('pagetitle')
    {{ __('Verordnungen') }} &triangleright; {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#locations">{{__('Standorte')}}</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Verordnungen')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Dezember</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <section id="locations">
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
            </div>
        </div>
    </div>
@endsection
