@extends('layout.layout-admin')

@section('pagetitle')
    {{ __('Systemstatus') }} &triangleright; {{ __('Systemeinstellungen') }}@endsection

@section('mainSection')
    {{ __('Systemstatus') }}
@endsection

@section('menu')
    @include('menus._menuAdmin')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">{{ __('Übersicht Systemstatus') }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs mainNavTab"
                         id="nav-tab"
                         role="tablist"
                    >

                        <button class="nav-link active"
                                id="nav-objects-tab"
                                data-toggle="tab"
                                data-target="#nav-objects"
                                type="button"
                                role="tab"
                                aria-controls="nav-objects"
                                aria-selected="true"
                        >
                            @if (
                                ($objects['incomplete_equipment'] > 0 && $objects['equipment'] > 0) ||
                                    ($objects['incomplete_requirement'] > 0 && $objects['requirements'] > 0) ||
                                    $objects['equipment_qualified_user'] === 0 ||
                                    $objects['product_qualified_user'] === 0 ||
                                    $objects['regulations'] === 0 ||
                                    $objects['requirements'] === 0 ||
                                    $objects['requirements_items'] === 0 ||
                                    $objects['products'] === 0 ||
                                    ($objects['control_products'] === 0 && $objects['storages'] === 0))
                                <span class="text-warning">{{ __('Objekte') }}</span>
                        </button>
                        @else
                        {{ __('Objekte') }}
                        @endif
                        <button class="nav-link"
                                id="nav-dblinks-tab"
                                data-toggle="tab"
                                data-target="#nav-dblinks"
                                type="button"
                                role="tab"
                                aria-controls="nav-dblinks"
                                aria-selected="false"
                        >
                            <span class="{{ $dbstatus['totalBrokenLinks'] > 0 ||
                                $dbstatus['brokenProducts'] > 0 ||
                                $dbstatus['brokenProductRequiremnets'] > 0 ||
                                $dbstatus['orphanRequirementItems'] > 0 ||
                                $dbstatus['duplicate_uuids']['hasDuplicateIds'] ||
                                $dbstatus['missingEquipmentUuids'] > 0
                                    ? 'text-danger'
                                    : 'text-success' }}"
                            >{{ __('Datenbank') }}</span>
                        </button>
                    </div>
                </nav>
                <div class="tab-content pt-3"
                     id="nav-tabContent"
                >
                    <div class="tab-pane fade show active"
                         id="nav-objects"
                         role="tabpanel"
                         aria-labelledby="nav-objects-tab"
                    >
                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="h5">{{ __('memStandorte') }}</h2>
                                @if ($objects['storages'] > 0)
                                    <x-system-status-msg counter="{{ $objects['storages'] }}"
                                                         link="{{ route('lexplorer') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Standorte/Abstellplätze sind erstellt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('location.create') }}"
                                                         type="danger"
                                                         msg="{{ __('Keine Standorte gefunden') }}"
                                    />
                                @endif
                                <h2 class="h5">{{ __('Verordnungen') }}</h2>
                                @if ($objects['regulations'] > 0)
                                    <x-system-status-msg counter="{{ $objects['regulations'] }}"
                                                         link="{{ route('verordnung.main') }}"
                                                         msg="{{ __('Sehr gut! Verordnungen sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('verordnung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Verordnungen gefunden') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Anforderungen') }}</h2>
                                @if ($objects['requirements'] > 0)
                                    <x-system-status-msg counter="{{ $objects['requirements'] }}"
                                                         link="{{ route('anforderung.index') }}"
                                                         msg="{{ __('Sehr gut! Anforderungen sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('anforderung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Anforderungen gefunden') }}"
                                    />
                                @endif

                                @if ($objects['incomplete_requirement'] > 0 && $objects['requirements'] > 0)
                                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                                    <x-system-status-msg link="{{ route('anforderung.index') }}"
                                                         msg="{{ $objects['incomplete_requirement'] }} {{ __('Anforderungen
                                                                                                                                         haben keine Kontrollvorgänge') }}"
                                                         type="warning"
                                    />
                                @elseif($objects['incomplete_requirement'] === 0 && $objects['requirements'] > 0)
                                    <h2 class="h5">{{ __('Unvollständige Anforderungen') }}</h2>
                                    <x-system-status-msg counter="0"
                                                         link="{{ route('anforderung.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Alle Anforderungen sind vollständig') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Kontrollvorgänge') }}</h2>
                                @if ($objects['requirements_items'] > 0)
                                    <x-system-status-msg counter="{{ $objects['requirements_items'] }}"
                                                         link="{{ route('anforderungcontrolitem.index') }}"
                                                         msg="{{ __('Sehr gut! Kontrollvorgänge sind angelegt') }}"
                                                         type="pass"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('anforderung.create') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Anforderungen gefunden') }}"
                                    />
                                @endif

                            </div>
                            <div class="col-md-4">
                                <h2 class="h5">{{ __('Produkte') }}</h2>
                                @if ($objects['products'] > 0)
                                    <x-system-status-msg counter="{{ $objects['products'] }}"
                                                         link="{{ route('produktMain') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Produkte sind erstellt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.create') }}"
                                                         type="danger"
                                                         msg="{{ __('Keine Produkte gefunden') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Prüfprodukte') }}</h2>
                                @if ($objects['control_products'] > 0)
                                    <x-system-status-msg counter="{{ $objects['control_products'] }}"
                                                         link="{{ route('produktMain') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Prüfprodukte sind definiert') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Produkte als Prüfmittel definiert') }}"
                                    />
                                @endif

                                <h2 class="h5">{{ __('Produkte') }}
                                    <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                </h2>
                                @if ($objects['product_qualified_user'] > 0)
                                    <x-system-status-msg counter="{{ $objects['product_qualified_user'] }}"
                                                         link="{{ route('produkt.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Benutzer sind befähigt!') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('produkt.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine befähigten Benutzer gefunden') }}"
                                    />
                                @endif
                            </div>
                            <div class="col-md-4">

                                @if ($objects['equipment'] > 0)
                                    <h2 class="h5">{{ __('Geräte') }}</h2>
                                    <x-system-status-msg counter="{{ $objects['equipment'] }}"
                                                         type="pass"
                                                         link="{{ route('equipMain') }}"
                                                         msg="{{ __('Sehr gut! Es sind Geräte angelegt') }}"
                                    />
                                    <h2 class="h5">{{ __('Geräte ohne Prüfungen') }}</h2>
                                    @if ($objects['incomplete_equipment'] > 0)
                                        <x-system-status-msg link="{{ route('equipMain') }}"
                                                             type="warning"
                                                             msg="{{ __('Es existieren Geräte ohne Prüfungen') }}"
                                        />
                                    @else
                                        <x-system-status-msg counter="{{ $objects['incomplete_equipment'] }}"
                                                             type="pass"
                                                             link="{{ route('equipMain') }}"
                                                             msg="{{ __('Sehr gut! Alle Geräte haben mindestens eine Prüfungen') }}"
                                        />
                                    @endif
                                @endif
                                @if ($objects['products'] > 0 && $objects['equipment'] === 0)
                                    <h2 class="h5">{{ __('Geräte') }}</h2>
                                    <x-system-status-msg link="{{ route('equipment.maker') }}"
                                                         type="info"
                                                         msg="{{ __('Es sind noch keine Geräte angelegt worden') }}"
                                                         labelBtn="{{ __('anlegen') }}"
                                    />
                                @endif
                                <h2 class="h5">{{ __('Prüfgeräte') }}</h2>
                                @if ($objects['control_equipment'] > 0)
                                    <x-system-status-msg counter="{{ $objects['control_equipment'] }}"
                                                         type="pass"
                                                         link="{{ route('equipMain') }}"
                                                         msg="{{ __('Sehr gut! Prüfgeräte sind angelegt') }}"
                                    />
                                @else
                                    <x-system-status-msg link="{{ route('equipment.index') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine Prüfgeräte definiert') }}"
                                    />
                                @endif

                                @if ($objects['foundExpiredControlEquipment'])
                                    <x-system-status-msg type="warning"
                                                         link="{{ route('equipment.controlequipment') }}"
                                                         msg="{{ __('Es sind Prüfgeräte mit ungültigem Prüfstatus vorhanden') }}"
                                    />
                                @else
                                    <x-system-status-msg type="pass"
                                                         link="{{ route('equipment.controlequipment') }}"
                                                         msg="{{ __('Sehr gut! Alle Prüfgeräte sind geprüft') }}"
                                    />
                                @endif

                                @if ($objects['equipment_qualified_user'] > 0 && $objects['equipment'] > 0)
                                    <h2 class="h5">{{ __('Geräte') }}
                                        <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                    </h2>
                                    <x-system-status-msg counter="{{ $objects['equipment_qualified_user'] }}"
                                                         link="{{ route('equipment.index') }}"
                                                         type="pass"
                                                         msg="{{ __('Sehr gut! Benutzer sind befähigt!') }}"
                                    />
                                @elseif($objects['equipment_qualified_user'] === 0 && $objects['equipment'] > 0)
                                    <h2 class="h5">{{ __('Geräte') }}
                                        <i class="fas fa-angle-right"></i> {{ __('Befähigte Benutzer') }}
                                    </h2>
                                    <x-system-status-msg link="{{ route('equipMain') }}"
                                                         type="warning"
                                                         msg="{{ __('Keine befähigten Benutzer gefunden') }}"
                                    />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="nav-dblinks"
                         role="tabpanel"
                         aria-labelledby="nav-dblinks-tab"
                    >
                        <div class="row">
                            <div class="{{ $dbstatus['totalBrokenLinks'] > 0 ||
                                $dbstatus['brokenProductRequiremnets'] > 0 ||
                                $dbstatus['orphanRequirementItems'] > 0
                                    ? 'col-md-8'
                                    : 'col-md-6' }}"
                            >

                                @if ($dbstatus['brokenProductRequiremnets'] > 0)
                                    <p class="lead text-danger">
                                        {{ __('Es existieren Produktanforderungen die eine gelöschte Anfoderung referenzieren!') }}
                                    </p>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Erstellt</th>
                                            <th>Anforderung</th>
                                            <th>Produkt</th>
                                            <th>Aktion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dbstatus['brokenProductRequiremnetItems'] as $productItem)
                                            <tr>
                                                <td>{{ $productItem->created_at }}</td>
                                                <td>
                                                    @if ($productItem->Anforderung)
                                                        {{ $productItem->Anforderung->an_name }}
                                                    @else
                                                        <select class="custom-select custom-select-sm setRequirement"
                                                                data-controlid="{{ $productItem->id }}"
                                                                aria-label="{{ __('Anforderung auswählen') }}"
                                                        >
                                                            <option value="0">neu zuordnen</option>
                                                            @foreach ($requirementList as $requirement)
                                                                <option value="{{ $requirement->id }}">
                                                                    {{ $requirement->an_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($productItem->Produkt)
                                                        {{ $productItem->Produkt->prod_name }}
                                                        {{ $productItem->Produkt->prod_nummer }}
                                                    @else
                                                        <select class="custom-select custom-select-sm setEquipment"
                                                                data-controlid="{{ $productItem->id }}"
                                                                aria-label="{{ __('Gerät auswählen') }}"
                                                        >
                                                            <option value="0">neu zuordnen</option>
                                                            @foreach ($productList as $product)
                                                                <option value="{{ $product->id }}">
                                                                    {{ $product->prod_name . ' - ' . $product->prod_nummer }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    <section class="d-flex">
                                                        <form action="{{ route('control.fixbroken', $productItem) }}"
                                                              method="POST"
                                                        >
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="text"
                                                                   name="anforderung_id"
                                                                   id="setRequirement{{ $productItem->id }}"
                                                                   value="@if ($productItem->Anforderung) {{ $productItem->Anforderung->id }} @endif"
                                                            >
                                                            <input type="text"
                                                                   name="produkt_id"
                                                                   id="setProduct{{ $productItem->id }}"
                                                                   value="@if ($productItem->Produkt) {{ $productItem->Produkt->id }} @endif"
                                                            >
                                                            <button class="btn btn-sm btn-outline-primary mr-1"
                                                                    id="btnUpdateControlItem{{ $productItem->id }}"
                                                                    disabled
                                                            >
                                                                <i class="fa fa-save"></i>
                                                            </button>
                                                        </form>
                                                        @if ($isSysAdmin)
                                                            <form action="{{ route('deleteProduktAnfordrung') }}"
                                                                  method="POST"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="text"
                                                                       name="id"
                                                                       id="id{{ $productItem->id }}"
                                                                       value="{{ $productItem->id }}"
                                                                >
                                                                <button class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </section>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Keine verwaisten Produktanforderungen') }}</h4>
                                        <p>{{ __('Es wurde keine Produkte mit gelöschten / unbekannten Anforderungen gefunden.') }}
                                        </p>
                                    </div>
                                @endif
                                @if ($dbstatus['totalBrokenLinks'] > 0)
                                    <h2 class="h4">{{ __('Verwaiste Prüfungen') }}
                                        <span class="badge badge-info small">{{ $dbstatus['totalBrokenLinks'] }} </span>
                                    </h2>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Erstellt</th>
                                            <th>Fällig</th>
                                            <th>Anforderung</th>
                                            <th>Gerät</th>
                                            <th>Aktion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dbstatus['brokenControlItems'] as $controlItem)
                                            <tr>
                                                <td>{{ $controlItem->created_at }}</td>
                                                <td>{{ $controlItem->qe_control_date_due }}</td>
                                                <td>
                                                    @if ($controlItem->Anforderung)
                                                        {{ $controlItem->Anforderung->an_name }}
                                                    @else
                                                        <select class="custom-select custom-select-sm setRequirement"
                                                                data-controlid="{{ $controlItem->id }}"
                                                                aria-label="{{ __('Anforderung auswählen') }}"
                                                        >
                                                            <option value="0">neu zuordnen</option>
                                                            @foreach ($requirementList as $requirement)
                                                                <option value="{{ $requirement->id }}">
                                                                    {{ $requirement->an_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($controlItem->Equipment)
                                                        {{ $controlItem->Equipment->eq_name }}
                                                        {{ $controlItem->Equipment->eq_inventar_nr }}
                                                    @else
                                                        <select class="custom-select custom-select-sm setEquipment"
                                                                data-controlid="{{ $controlItem->id }}"
                                                                aria-label="{{ __('Gerät auswählen') }}"
                                                        >
                                                            <option value="0">neu zuordnen</option>
                                                            @foreach ($equipmentList as $equipment)
                                                                <option value="{{ $equipment->id }}">
                                                                    {{ $equipment->eq_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    <section class="d-flex">
                                                        <form action="{{ route('control.fixbroken',$controlItem) }}"
                                                              method="POST"
                                                        >
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="control_equipment_id"
                                                                   id="control_equipment_id_{{ $controlItem->id }}"
                                                                   value="{{ $controlItem->id }}"
                                                            >
                                                            <input type="hidden"
                                                                   name="anforderung_id"
                                                                   id="setRequirement{{ $controlItem->id }}"
                                                                   value="@if ($controlItem->Anforderung) {{ $controlItem->Anforderung->id }} @endif"
                                                            >
                                                            <input type="hidden"
                                                                   name="equipment_id"
                                                                   id="setEquipment{{ $controlItem->id }}"
                                                                   value="@if ($controlItem->Equipment) {{ $controlItem->Equipment->id }} @endif"
                                                            >
                                                            <button class="btn btn-sm btn-outline-primary mr-1"
                                                                    id="btnUpdateControlItem{{ $controlItem->id }}"
                                                                    disabled
                                                            >
                                                                <i class="fa fa-save"></i>
                                                            </button>
                                                        </form>
                                                        @if ($isSysAdmin)
                                                            <form action="{{ route('control.destroy', $controlItem) }}"
                                                                  method="POST"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden"
                                                                       name="id"
                                                                       id="id"
                                                                       value="{{ $controlItem->id }}"
                                                                >
                                                                <button class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </section>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Keine verwaisen Prüfungen') }}</h4>
                                        <p>{{ __('Es konten keine verwaisten Prüfungen gefunden werden.') }}</p>
                                    </div>
                                @endif
                                @if ($dbstatus['orphanRequirementItems'] > 0)
                                    <h2 class="h4">{{ __('Verwaiste Prüfschritte') }}
                                        <span class="badge badge-info small">{{ $dbstatus['orphanRequirementItems'] }}
                                        </span>
                                    </h2>

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Erstellt</th>
                                            <th>{{ __('Anforderung') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Kürzel') }}</th>
                                            <th>{{ __('Aktion') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dbstatus['orphanRequirementItemList'] as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->created_at }}
                                                </td>
                                                <td>
                                                    <select class="custom-select custom-select-sm setRequirement"
                                                            data-controlid="{{ $item->id }}"
                                                            aria-label="{{ __('Anforderung auswählen') }}"
                                                    >
                                                        <option value="0">neu zuordnen</option>
                                                        @foreach ($requirementList as $requirement)
                                                            <option value="{{ $requirement->id }}">
                                                                {{ $requirement->an_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </td>
                                                <td>
                                                    {{ $item->aci_name }}
                                                </td>
                                                <td>
                                                    {{ $item->aci_label }}
                                                </td>
                                                <td>
                                                    <section class="d-flex">
                                                        <form action="{{ route('anforderungcontrolitem.fixbroken', $item) }}"
                                                              method="POST"
                                                        >
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden"
                                                                   name="anforderung_id"
                                                                   id="setRequirement{{ $item->id }}"
                                                                   value="@if ($item->Anforderung) {{ $item->Anforderung->id }} @endif"
                                                            >
                                                            <button class="btn btn-sm btn-outline-primary mr-1"
                                                                    id="btnUpdateControlItem{{ $item->id }}"
                                                                    disabled
                                                            >
                                                                <i class="fa fa-save"></i>
                                                            </button>
                                                        </form>
                                                        @if ($isSysAdmin)
                                                            <form action="{{ route('anforderungcontrolitem.destroy', $item) }}"
                                                                  method="POST"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </section>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Keine verwaisen Prüfschritte') }}</h4>
                                        <p>{{ __('Es konten keine verwaisten Prüfschritte gefunden werden.') }}</p>
                                    </div>
                                @endif

                            </div>
                            <div class="{{ $dbstatus['totalBrokenLinks'] > 0 ||
                                $dbstatus['brokenProductRequiremnets'] > 0 ||
                                $dbstatus['orphanRequirementItems'] > 0
                                    ? 'col-md-4'
                                    : 'col-md-6' }}"
                            >
                                @if ($dbstatus['brokenProducts'] > 0)
                                    @if ($dbstatus['brokenProducts'] > 1)
                                        <p class="lead text-danger">Es sind {{ $dbstatus['brokenProducts'] }} Produkte
                                            ohne UUID gefunden worden!</p>
                                    @else
                                        <p class="lead text-danger">Es ist ein Produkt ohne UUID gefunden worden!</p>
                                    @endif
                                    <a href="{{ route('products.setuuids') }}"
                                       class="btn btn-outline-primary"
                                    >beheben
                                    </a>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Keine Produkte ohne UUID') }}</h4>
                                        <p>{{ __('Es wurde keine Produkte ohne UUID gefunden.') }}</p>
                                    </div>
                                @endif

                                @if ($dbstatus['missingEquipmentUuids'] > 0)
                                    <form action="{{ route('equipment.syncuid') }}"
                                          method="post"
                                          class="card p-2 mb-2"
                                    >
                                        @csrf
                                        <button class="btn btn-lg btn-outline-primary">
                                            <i class="fa fa-sync"></i> Geräte-UID syncronisieren
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Geräte UID ohne Fehler') }}</h4>
                                        <p>{{ __('Alle Geräte-UID sind syncronisiert.') }}</p>
                                    </div>
                                @endif

                                @if ($dbstatus['duplicate_uuids']['hasDuplicateIds'])
                                    <form id="frmSetUIDToEquipment"
                                          action="{{ route('equipment.fixuid') }}"
                                          method="POST"
                                    >
                                        @csrf
                                        <p class="lead text-danger">Diese Geräte haben eine identische UID!</p>
                                        <p>{{ __('Bitte angeben welches Geräte seine UID behalten soll.') }}</p>
                                        @foreach ($dbstatus['duplicate_uuids']['duplicateEquipmentUidList'] as $uidEquipmentList)
                                            @if (!$uidEquipmentList->contains(null))
                                                <section class="card p-2 mb-2">
                                                    <p>{{ __('Identische UID ') }}
                                                        <span><strong>{{ $uidEquipmentList->first()->eq_uid }}</strong></span>
                                                    </p>
                                                    @foreach ($uidEquipmentList as $equipment)
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio"
                                                                   id="keepThisUid{{ $equipment->id }}"
                                                                   name="keepThisUid[{{ $equipment->eq_uid }}]"
                                                                   class="custom-control-input"
                                                                   value="{{ $equipment->id }}"
                                                            >
                                                            <label class="custom-control-label"
                                                                   for="keepThisUid{{ $equipment->id }}"
                                                            >
                                                                <span class="d-block">{{ $equipment->eq_name }}</span>
                                                                <span class="small text-mute">
                                                                    {{ $equipment->eq_inventar_nr }}
                                                                </span> <span class="small text-mute ml-2">
                                                                    {{ $equipment->created_at->diffForHumans() }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </section>
                                            @endif
                                        @endforeach

                                        <button class="btn btn-small">
                                            {{ __('UIds neu vergeben') }}
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-success"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">{{ __('Keine Geräte mit doppelter UUID') }}</h4>
                                        <p>{{ __('Es wurde keine Geräte mit UUID gefunden.') }}</p>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        $('.setRequirement').change(function () {
            const controlId = $(this).data('controlid');
            $('#setRequirement' + controlId).val($(this).val());
            $('#btnUpdateControlItem' + controlId).prop('disabled', $(this).val() === '0');
        });

        $('.setEquipment').change(function () {
            const controlId = $(this).data('controlid');
            $('#setEquipment' + controlId).val($(this).val());
            $('#btnUpdateControlItem' + controlId).prop('disabled', $(this).val() === '0');
        });
    </script>
@endsection
