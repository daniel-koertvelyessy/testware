@extends('layout.layout-documentation')

@section('pagetitle')
    {{ __('Produkte') }} &triangleright; {{__('Dokumentation')}} @ testWare
@endsection

@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#products">{{__('Produkte')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#product_parameter">{{__('Parameter für Produkte')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#product_category">{{__('Kategorien')}}</a>
    </li>
    <li class="duik-content-nav__item">
        <a href="#product_category_parameter">{{__('Parameter für Kategorie')}}</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Produkte')}}</h1>
                <small class="text-muted">{{__('Stand')}} {{__('stand-api-docs')}}</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <section id="products">
                    <h2>{{ __('Produkte') }}</h2>
                    <p>{{__('Folgende Endpunkte sind verfügbar:')}}</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-product"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product</span>
                        </a>
                        <a href="#endpoint-get-api-v1-product_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_list_complete</span>
                        </a>
                        <a href="#endpoint-get-product_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product/{product_number}</span>
                        </a>
                        <a href="#endpoint-post-product"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/product</span>
                        </a>
                        <a href="#endpoint-put-product_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/product/{product_number}</span>
                        </a>
                        <a href="#endpoint-delete-product_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/product/{product_number}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-product">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Abrufen aller {{ __('Produkte') }} der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product-docs-tab-scheme" data-toggle="tab" href="#api_get_product-docs-tab-scheme-content" role="tab" aria-controls="api_get_product-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product-docs-tab-response" data-toggle="tab" href="#api_get_product-docs-tab-response-content" role="tab" aria-controls="api_get_product-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product-docs-tab-response">
<pre><code class="language-json">[
    {
        "id": 1,
        "created": "1970-01-09 08:55:06",
        "updated": "1970-01-12 20:23:20",
        "label": "pr.BaVQ2QkR",
        "name": "nesciunt-magnam-rerum-ipsum-a",
        "description": null,
        "part_number": "920173545",
        "status_active": true,
        "category_id": 1,
        "product_state_id": 2
    },
    {...}
]</code></pre>

                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-api-v1-product_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                {!! __('Abrufen aller :model der testWare mit Zusatzfeld <code>objects</code> inklusive', ['model'=> __('Produkte')])!!}
                                <ul>
                                    <li>{{__('Produktkategorie')}}</li>
                                    <li>{{__('Details der verknüpften Anfoderungen')}}</li>
                                    <li>{{__('Anzahl der abgeleiteten Geräten')}}</li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_list_complete-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_list_complete-docs-tab-scheme" data-toggle="tab" href="#api_get_product_list_complete-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_list_complete-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_list_complete-docs-tab-response" data-toggle="tab" href="#api_get_product_list_complete-docs-tab-response-content" role="tab" aria-controls="api_get_product_list_complete-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_list_complete-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_list_complete-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_list_complete-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_list_complete-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_list_complete-docs-tab-response">
<pre><code class="language-json">[
    {
        "id": 1,
        "created": "2015-01-10 12:48:26",
        "updated": "2018-01-08 05:13:14",
        "label": "pr.KTCx6QHk",
        "name": "et-sit-saepe-suscipit",
        "description": null,
        "part_number": "920975014",
        "status_active": true,
        "parameter": [
            {
                "label": "Firmware",
                "name": "Firmware Stand",
                "value": "08-2000"
            }
        ],
        "category": {
            "label": "ohne",
            "name": "Keine Zuordnung",
            "number": "-",
            "description": null
        },
        "product_state": {
            "label": "gesperrt",
            "name": "Produkt ist gesperrt und darf nicht verwendet werden"
        },
        "object": {
            "requirements": [
                {
                    "id": 1,
                    "type": "Einstufung VDE Schutzklasse 1"
                },
                {
                    "id": 4,
                    "type": "Einstufung VDE Schutzklasse Leitungen"
                },
                {
                    "id": 10,
                    "type": "Kalibrierung Prüfmittel"
                }
            ],
            "equipment": 28
        }
    },
    {...}
]</code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-get-product_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product/{product_number}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>product_number</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                {{__('Ruft die Daten zum einem :model mit der ',['model', __('Produkt')])}} <code>product_number</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_id-docs-tab-scheme" data-toggle="tab" href="#api_get_product_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_id-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_id-docs-tab-response" data-toggle="tab" href="#api_get_product_id-docs-tab-response-content" role="tab" aria-controls="api_get_product_id-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_id-docs-tab-response">
<pre><code class="language-json">{
    "id": 1,
    "created": "1970-01-10 12:48:26",
    "updated": "1970-01-08 05:13:14",
    "label": "pr.KTCx6QHk",
    "name": "et-sit-saepe-suscipit",
    "description": null,
    "part_number": "920975014",
    "status_active": true,
    "category_id": 1,
    "product_state_id": 2
}</code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-post-product">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Erstellt ein Produkt.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>prod_nummer</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>status_active</code>
                                        <span>
                                            <span class="badge badge-dark-soft">DEFAULT</span>
                                            <code>1</code>
                                        </span>
                                        <span class="badge badge-dark-soft">BOOLEAN</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#products_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="products_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="products_optionals"
                                >
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>name</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>description</code> <span class="badge badge-dark-soft">STRING</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <code>room_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>category_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>category</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>product_state_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>product_state</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">{!! __('Wird das Objekt <code>:object</code> verwendet, sind folgende Felder erforderlich',['object', 'category'])!!}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#products_post_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="products_post_optional_type"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="products_post_optional_type"
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_product-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_product-docs-tab-scheme" data-toggle="tab" href="#api_post_product-docs-tab-scheme-content" role="tab" aria-controls="api_post_product-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_product-docs-tab-response" data-toggle="tab" href="#api_post_product-docs-tab-response-content" role="tab" aria-controls="api_post_product-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_product-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_product-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_product-docs-tab-scheme">
<pre><code class="language-json">{
    "label": "sp.2118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "W.1.2.3.a.12",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "type" : {
        "label": "Fach-DIN-3",
        "name": "Lagerfach für Kästen DIN-3",
        "description": null
    },
    "room_id": 5
}</code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_post_product-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_product-docs-tab-response">
<pre><code class="language-json">{
    "id": 49,
    "created": "2021-01-07 18:09:37",
    "updated": "2021-01-07 18:09:37",
    "label": "sp.2118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "W.1.2.3.a.12",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "product_type_id": 4,
    "room_id": 5
}</code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-put-product_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product/{product_number}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>product_number</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                {{__('Aktualisiert die Daten eines Produktes mit der Referenz')}} <code>{product_number}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#products_put_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="products_put_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="products_put_optionals"
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
                                            <code>room_id</code> <span class="badge badge-dark-soft">INTEGER</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <p><code>product_type_id</code> <span class="badge badge-dark-soft">INTEGER</span></p>
                                            <p>oder</p>
                                            <p><code>type</code> <span class="badge badge-dark-soft">OBJECT</span></p>
                                        </li>
                                    </ul>
                                </div>
                                <p class="mt-3">{!! __('Wird das Objekt <code>type</code> verwendet, sind folgende Felder erforderlich')!!}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>type.label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#products_put_optional_type"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="products_put_optional_type"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="products_put_optional_type"
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_product_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_product_id-docs-tab-scheme" data-toggle="tab" href="#api_put_product_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_product_id-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_product_id-docs-tab-response" data-toggle="tab" href="#api_put_product_id-docs-tab-response-content" role="tab" aria-controls="api_put_product_id-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_product_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_product_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_product_id-docs-tab-scheme">
<pre><code class="language-json">{
    "label": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "product_type_id" : 2,
    "building_id": 5
}</code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_product_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_product_id-docs-tab-response">
<pre><code class="language-json">{
    "id": 1,
    "created": "2021-01-06 22:23:44",
    "updated": "2021-01-06 23:07:33",
    "label": "rm-118",
    "uid": "1e0cfa36-e485-36c7-8f26-21c83884a442",
    "name": "quis",
    "description": "Amet minus dolorum at reprehenderit velit iste laudantium...",
    "product_type_id" : 2,
    "building_id": 5
}</code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                    <div class="dropdown-divider my-5"></div>
                    <article id="endpoint-delete-product_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product/{product_number}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>product_number</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                {{__('Löscht das :model mit der Referenz',['model'=> __('Produkt')])}} <code>{product_number}</code>.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Antwort')}}</dt>
                            <dd class="col-sm-10">
<pre><code class="language-json">{
    "status" : "product deleted"
}</code></pre>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="product_parameter">
                    <h2>{{ __('Parameter für Produkte') }}</h2>
                    <p>{{__('Folgende Endpunkte sind verfügbar:')}}</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-product_parameter"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_parameter</span>
                        </a>
                        <a href="#endpoint-get-product_parameter_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_parameter_list_complete</span>
                        </a>
                        <a href="#endpoint-get-product_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_parameter/{id}</span>
                        </a>
                        <a href="#endpoint-post-product_parameter"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/product_parameter</span>
                        </a>
                        <a href="#endpoint-put-product_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/product_parameter/{id}</span>
                        </a>
                        <a href="#endpoint-delete-product_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/product_parameter/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-product_parameter">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Betriebe in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_parameter-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_parameter-docs-tab-scheme" data-toggle="tab" href="#api_get_product_parameter-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_parameter-docs-tab-tab1-content" aria-selected="false">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_parameter-docs-tab-response" data-toggle="tab" href="#api_get_product_parameter-docs-tab-response-content" role="tab" aria-controls="api_get_product_parameter-docs-tab-tab2-content" aria-selected="true">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_parameter-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_parameter-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_parameter-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_parameter-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_parameter-docs-tab-response">
                                    <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
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
                    <article id="endpoint-get-product_parameter_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
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
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_parameter_full_list-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_parameter_full_list-docs-tab-scheme" data-toggle="tab" href="#api_get_product_parameter_full_list-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_parameter_full_list-docs-tab-tab1-content" aria-selected="false">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_parameter_full_list-docs-tab-response" data-toggle="tab" href="#api_get_product_parameter_full_list-docs-tab-response-content" role="tab" aria-controls="api_get_product_parameter_full_list-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_parameter_full_list-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_parameter_full_list-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_parameter_full_list-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_parameter_full_list-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_parameter_full_list-docs-tab-response">
                            <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
        "description": "Hauptsitz der Firma Testfirma GmbH",
        "address": {
            "type": {
                "name": "Heimadress",
                "description": "Standard Adresse"
            },
            "label": "Gmb5423212",
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
        "product_parameter_objects": {
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
                    <article id="endpoint-get-product_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem Betrieb mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_get_product_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_parameter_id-docs-tab-tab1-content" aria-selected="false">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_parameter_id-docs-tab-response" data-toggle="tab" href="#api_get_product_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_get_product_parameter_id-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_parameter_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_parameter_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "created": "2020-12-29 11:30:16",
    "updated": "2021-01-03 19:10:04",
    "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
    "name": "HQbln153",
    "label": "bln153",
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
                    <article id="endpoint-post-product_parameter">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Erstellt einen Betrieb. Optional mit dazugehöriger Adresse und Leitung.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_parameters_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_parameters_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_parameters_optionals"
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
                                        <code>address.label</code> <span class="badge badge-dark-soft">STRING</span>
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
                                >{{__('Optionale Felder')}}
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
                                >{{__('Optionale Felder')}}
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_product_parameter-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_product_parameter-docs-tab-scheme" data-toggle="tab" href="#api_post_product_parameter-docs-tab-scheme-content" role="tab" aria-controls="api_post_product_parameter-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_product_parameter-docs-tab-response" data-toggle="tab" href="#api_post_product_parameter-docs-tab-response-content" role="tab" aria-controls="api_post_product_parameter-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_product_parameter-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_product_parameter-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_product_parameter-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "name": "Loc-bln153",
    "label": "bln153",
    "description": "Nihil aut qui nostrum ...",
    "address": {
        "street": "Christiane-Brandt-Platz",
        "no": "67",
        "zip": "63550",
        "city": "Bruchsal",
        "address_type": {
            "name" : "Hausadresse"
        },
        "label": "Gmb5423212",
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
                                    <div class="tab-pane bg-light fade p-3" id="api_post_product_parameter-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_product_parameter-docs-tab-response">
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
                    <article id="endpoint-put-product_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_parameters_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_parameters_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_parameters_optionals"
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_product_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_product_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_put_product_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_product_parameter_id-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_product_parameter_id-docs-tab-response" data-toggle="tab" href="#api_put_product_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_put_product_parameter_id-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_product_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_product_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_product_parameter_id-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "label": "bln251",
    "uid": "9f1cf9d5-370b-3413-a51c-c97c2308fe2b",
    "name": "quam-officiis-eligendi-veritatis",
    "description": "Minima maxime omnis cupiditate quas...",
    "address_id": 2,
    "employee_id": 4
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_product_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_product_parameter_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 12:26:19",
    "updated": "2021-01-06 18:41:57",
    "label": "bln251",
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
                    <article id="endpoint-delete-product_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_delete_product_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_delete_product_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_delete_product_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_delete_product_parameter_id-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_delete_product_parameter_id-docs-tab-response" data-toggle="tab" href="#api_delete_product_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_delete_product_parameter_id-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_delete_product_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_delete_product_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_delete_product_parameter_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_delete_product_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_delete_product_parameter_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "status" : "product_parameter deleted"
}
                                </code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="product_category">
                    <h2>{{ __('Kategorien') }}</h2>
                    <p>{{__('Folgende Endpunkte sind verfügbar:')}}</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-product_category"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category</span>
                        </a>
                        <a href="#endpoint-get-product_category_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category_list_complete</span>
                        </a>
                        <a href="#endpoint-get-product_category_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category/{id}</span>
                        </a>
                        <a href="#endpoint-post-product_category"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/product_category</span>
                        </a>
                        <a href="#endpoint-put-product_category_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/product_category/{id}</span>
                        </a>
                        <a href="#endpoint-delete-product_category_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/product_category/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-product_category">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Betriebe in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category-docs-tab-tab1-content" aria-selected="false">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category-docs-tab-response" data-toggle="tab" href="#api_get_product_category-docs-tab-response-content" role="tab" aria-controls="api_get_product_category-docs-tab-tab2-content" aria-selected="true">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category-docs-tab-response">
                                    <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
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
                    <article id="endpoint-get-product_category_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
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
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category_full_list-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category_full_list-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category_full_list-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category_full_list-docs-tab-tab1-content" aria-selected="false">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category_full_list-docs-tab-response" data-toggle="tab" href="#api_get_product_category_full_list-docs-tab-response-content" role="tab" aria-controls="api_get_product_category_full_list-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category_full_list-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category_full_list-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category_full_list-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category_full_list-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category_full_list-docs-tab-response">
                            <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
        "description": "Hauptsitz der Firma Testfirma GmbH",
        "address": {
            "type": {
                "name": "Heimadress",
                "description": "Standard Adresse"
            },
            "label": "Gmb5423212",
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
        "product_category_objects": {
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
                    <article id="endpoint-get-product_category_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem Betrieb mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category_id-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category_id-docs-tab-tab1-content" aria-selected="false">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category_id-docs-tab-response" data-toggle="tab" href="#api_get_product_category_id-docs-tab-response-content" role="tab" aria-controls="api_get_product_category_id-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "created": "2020-12-29 11:30:16",
    "updated": "2021-01-03 19:10:04",
    "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
    "name": "HQbln153",
    "label": "bln153",
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
                    <article id="endpoint-post-product_category">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Erstellt einen Betrieb. Optional mit dazugehöriger Adresse und Leitung.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_categorys_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_categorys_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_categorys_optionals"
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
                                        <code>address.label</code> <span class="badge badge-dark-soft">STRING</span>
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
                                >{{__('Optionale Felder')}}
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
                                >{{__('Optionale Felder')}}
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_product_category-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_product_category-docs-tab-scheme" data-toggle="tab" href="#api_post_product_category-docs-tab-scheme-content" role="tab" aria-controls="api_post_product_category-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_product_category-docs-tab-response" data-toggle="tab" href="#api_post_product_category-docs-tab-response-content" role="tab" aria-controls="api_post_product_category-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_product_category-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_product_category-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_product_category-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "name": "Loc-bln153",
    "label": "bln153",
    "description": "Nihil aut qui nostrum ...",
    "address": {
        "street": "Christiane-Brandt-Platz",
        "no": "67",
        "zip": "63550",
        "city": "Bruchsal",
        "address_type": {
            "name" : "Hausadresse"
        },
        "label": "Gmb5423212",
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
                                    <div class="tab-pane bg-light fade p-3" id="api_post_product_category-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_product_category-docs-tab-response">
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
                    <article id="endpoint-put-product_category_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_categorys_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_categorys_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_categorys_optionals"
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_product_category_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_product_category_id-docs-tab-scheme" data-toggle="tab" href="#api_put_product_category_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_product_category_id-docs-tab-tab1-content" aria-selected="true">{{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_product_category_id-docs-tab-response" data-toggle="tab" href="#api_put_product_category_id-docs-tab-response-content" role="tab" aria-controls="api_put_product_category_id-docs-tab-tab2-content" aria-selected="false">{{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_product_category_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_product_category_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_product_category_id-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "label": "bln251",
    "uid": "9f1cf9d5-370b-3413-a51c-c97c2308fe2b",
    "name": "quam-officiis-eligendi-veritatis",
    "description": "Minima maxime omnis cupiditate quas...",
    "address_id": 2,
    "employee_id": 4
}
                                </code></pre>
                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_product_category_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_product_category_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 12:26:19",
    "updated": "2021-01-06 18:41:57",
    "label": "bln251",
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
                    <article id="endpoint-delete-product_category_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_delete_product_category_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_delete_product_category_id-docs-tab-scheme" data-toggle="tab" href="#api_delete_product_category_id-docs-tab-scheme-content" role="tab" aria-controls="api_delete_product_category_id-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_delete_product_category_id-docs-tab-response" data-toggle="tab" href="#api_delete_product_category_id-docs-tab-response-content" role="tab" aria-controls="api_delete_product_category_id-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_delete_product_category_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_delete_product_category_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_delete_product_category_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_delete_product_category_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_delete_product_category_id-docs-tab-response">
<pre><code class="language-json">{
    "status" : "product_category deleted"
}</code></pre>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </article>
                </section>
                <section id="product_category_parameter">
                    <h2>{{ __('Parameter für Kategorien') }}</h2>
                    <p>{{__('Folgende Endpunkte sind verfügbar:')}}</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-product_category_parameter"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category_parameter</span>
                        </a>
                        <a href="#endpoint-get-product_category_parameter_list_complete"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category_parameter_list_complete</span>
                        </a>
                        <a href="#endpoint-get-product_category_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/product_category_parameter/{id}</span>
                        </a>
                        <a href="#endpoint-post-product_category_parameter"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">POST</span> <span>/api/v1/product_category_parameter</span>
                        </a>
                        <a href="#endpoint-put-product_category_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">PUT</span> <span>/api/v1/product_category_parameter/{id}</span>
                        </a>
                        <a href="#endpoint-delete-product_category_parameter_id"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">DELETE</span> <span>/api/v1/product_category_parameter/{id}</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-product_category_parameter">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Abrufen aller Betriebe in der testWare
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category_parameter-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category_parameter-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category_parameter-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category_parameter-docs-tab-tab1-content" aria-selected="false">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category_parameter-docs-tab-response" data-toggle="tab" href="#api_get_product_category_parameter-docs-tab-response-content" role="tab" aria-controls="api_get_product_category_parameter-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category_parameter-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category_parameter-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category_parameter-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter-docs-tab-response">
                                    <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
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
                    <article id="endpoint-get-product_category_parameter_list_complete">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter_list_complete</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
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
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category_parameter_full_list-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category_parameter_full_list-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category_parameter_full_list-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category_parameter_full_list-docs-tab-tab1-content" aria-selected="false">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category_parameter_full_list-docs-tab-response" data-toggle="tab" href="#api_get_product_category_parameter_full_list-docs-tab-response-content" role="tab" aria-controls="api_get_product_category_parameter_full_list-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category_parameter_full_list-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category_parameter_full_list-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter_full_list-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category_parameter_full_list-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter_full_list-docs-tab-response">
                            <pre><code class="language-json">
[
    {
        "id": 1,
        "created": "2020-12-29 11:30:16",
        "updated": "2021-01-03 19:10:04",
        "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
        "name": "HQbln153",
        "label": "bln153",
        "description": "Hauptsitz der Firma Testfirma GmbH",
        "address": {
            "type": {
                "name": "Heimadress",
                "description": "Standard Adresse"
            },
            "label": "Gmb5423212",
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
        "product_category_parameter_objects": {
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
                    <article id="endpoint-get-product_category_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Ruft die Daten zum einem Betrieb mit der <code>id</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>GET</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_get_product_category_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_product_category_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_get_product_category_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_get_product_category_parameter_id-docs-tab-tab1-content" aria-selected="false">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_product_category_parameter_id-docs-tab-response" data-toggle="tab" href="#api_get_product_category_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_get_product_category_parameter_id-docs-tab-tab2-content" aria-selected="true">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_product_category_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_product_category_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_product_category_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_product_category_parameter_id-docs-tab-response">
                            <pre><code class="language-json">
{
    "created": "2020-12-29 11:30:16",
    "updated": "2021-01-03 19:10:04",
    "uid": "784f64bc-735a-3d2f-8a06-fcf3d47621f3",
    "name": "HQbln153",
    "label": "bln153",
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
                    <article id="endpoint-post-product_category_parameter">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Erstellt einen Betrieb. Optional mit dazugehöriger Adresse und Leitung.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>POST</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_category_parameters_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_category_parameters_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_category_parameters_optionals"
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
                                        <code>address.label</code> <span class="badge badge-dark-soft">STRING</span>
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
                                >{{__('Optionale Felder')}}
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
                                >{{__('Optionale Felder')}}
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_post_product_category_parameter-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_post_product_category_parameter-docs-tab-scheme" data-toggle="tab" href="#api_post_product_category_parameter-docs-tab-scheme-content" role="tab" aria-controls="api_post_product_category_parameter-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_post_product_category_parameter-docs-tab-response" data-toggle="tab" href="#api_post_product_category_parameter-docs-tab-response-content" role="tab" aria-controls="api_post_product_category_parameter-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_post_product_category_parameter-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_post_product_category_parameter-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_post_product_category_parameter-docs-tab-scheme">
                                       <pre><code class="language-json">
{
    "name": "Loc-bln153",
    "label": "bln153",
    "description": "Nihil aut qui nostrum ...",
    "address": {
        "street": "Christiane-Brandt-Platz",
        "no": "67",
        "zip": "63550",
        "city": "Bruchsal",
        "address_type": {
            "name" : "Hausadresse"
        },
        "label": "Gmb5423212",
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
                                    <div class="tab-pane bg-light fade p-3" id="api_post_product_category_parameter-docs-tab-response-content" role="tabpanel" aria-labelledby="api_post_product_category_parameter-docs-tab-response">
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
                    <article id="endpoint-put-product_category_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Aktualisiert die Daten eines Betriebes.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>PUT</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                <p>{{__('Erforderliche Felder')}}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <code>label</code> <span class="badge badge-dark-soft">STRING</span>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark-soft btn-pill"
                                   data-toggle="collapse"
                                   href="#product_category_parameters_optionals"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="product_category_parameters_optionals"
                                >{{__('Optionale Felder')}}
                                </a>
                                <div class="collapse"
                                     id="product_category_parameters_optionals"
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
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_put_product_category_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_put_product_category_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_put_product_category_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_put_product_category_parameter_id-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_put_product_category_parameter_id-docs-tab-response" data-toggle="tab" href="#api_put_product_category_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_put_product_category_parameter_id-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_put_product_category_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_put_product_category_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_put_product_category_parameter_id-docs-tab-scheme">

<pre><code class="language-json">{
    "label": "bln251",
    "uid": "9f1cf9d5-370b-3413-a51c-c97c2308fe2b",
    "name": "quam-officiis-eligendi-veritatis",
    "description": "Minima maxime omnis cupiditate quas...",
    "address_id": 2,
    "employee_id": 4
}</code></pre>

                                    </div>
                                    <div class="tab-pane bg-light fade p-3" id="api_put_product_category_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_put_product_category_parameter_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "id": 1,
    "created": "2021-01-06 12:26:19",
    "updated": "2021-01-06 18:41:57",
    "label": "bln251",
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
                    <article id="endpoint-delete-product_category_parameter_id">
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Endpunkt')}}</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/product_category_parameter/{id}</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Variable')}}</dt>
                            <dd class="col-sm-10">
                                <code>id</code> <span class="ml-5 badge badge-dark-soft">INTEGER</span>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Aufgabe')}}</dt>
                            <dd class="col-sm-10">
                                Löscht den Betrieb.
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Methode')}}</dt>
                            <dd class="col-sm-10">
                                <code>DELETE</code>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('Felder')}}</dt>
                            <dd class="col-sm-10">
                                -
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">{{__('JSON')}}</dt>
                            <dd class="col-sm-10">
                                <ul class="nav nav-bordered" id="api_delete_product_category_parameter_id-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_delete_product_category_parameter_id-docs-tab-scheme" data-toggle="tab" href="#api_delete_product_category_parameter_id-docs-tab-scheme-content" role="tab" aria-controls="api_delete_product_category_parameter_id-docs-tab-tab1-content" aria-selected="true">
                                            {{__('Senden')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_delete_product_category_parameter_id-docs-tab-response" data-toggle="tab" href="#api_delete_product_category_parameter_id-docs-tab-response-content" role="tab" aria-controls="api_delete_product_category_parameter_id-docs-tab-tab2-content" aria-selected="false">
                                            {{__('Antwort')}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_delete_product_category_parameter_id-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_delete_product_category_parameter_id-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_delete_product_category_parameter_id-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_delete_product_category_parameter_id-docs-tab-response-content" role="tabpanel" aria-labelledby="api_delete_product_category_parameter_id-docs-tab-response">
                                <pre><code class="language-json">
{
    "status" : "product_category_parameter deleted"
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
