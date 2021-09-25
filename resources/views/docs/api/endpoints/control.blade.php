@extends('layout.layout-documentation')

@section('pagetitle')
{{ __('Prüfungen') }} &triangleright; {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    {{--    <li class="duik-content-nav__item">
            <a href="#testing">{{__('Standorte')}}</a>
        </li>--}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('Prüfungen')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Dezember</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <section id="testing">
                    <p>Folgende Endpunkte sind verfügbar:</p>
                    <div class="list-group mb-6">
                        <a href="#endpoint-get-api-v1-test"
                           class="list-group-item list-group-item-action js-anchor-link"
                        >
                            <span class="mr-5 badge badge-dark-soft">GET</span> <span>/api/v1/test</span>
                        </a>
                    </div>
                    <article id="endpoint-get-api-v1-test">
                        <dl class="row">
                            <dt class="col-sm-2">Endpunkt</dt>
                            <dd class="col-sm-10">
                                <code>/api/v1/test</code>
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
                                <ul class="nav nav-bordered" id="api_get_test-docs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="api_get_test-docs-tab-scheme" data-toggle="tab" href="#api_get_test-docs-tab-scheme-content" role="tab" aria-controls="api_get_test-docs-tab-tab1-content" aria-selected="false">Senden</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="api_get_test-docs-tab-response" data-toggle="tab" href="#api_get_test-docs-tab-response-content" role="tab" aria-controls="api_get_test-docs-tab-tab2-content" aria-selected="true">Antwort</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="api_get_test-docs-tabContent">
                                    <div class="tab-pane bg-light fade p-3" id="api_get_test-docs-tab-scheme-content" role="tabpanel" aria-labelledby="api_get_test-docs-tab-scheme">
                                        -
                                    </div>
                                    <div class="tab-pane bg-light fade p-3 show active" id="api_get_test-docs-tab-response-content" role="tabpanel" aria-labelledby="api_get_test-docs-tab-response">
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
                </section>
            </div>
        </div>
    </div>
@endsection
