@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    Gerät {{ $equipment->eq_inventar_nr }} bearbeiten &triangleright; Geräte @ bitpack GmbH
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('actionMenuItems')
    <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bars"></i> Gerät </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('equipment.edit',['equipment'=>$equipment]) }}">
                Gerät bearbeitem <i class="ml-2 far fa-edit"></i>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#" data-toggle="modal" data-target="#modalAddParameter">
                Daten-Blatt Drucken <i class="ml-2 fas fa-print"></i>
            </a>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
                QR-Code Drucken <i class="ml-2 fas fa-qrcode"></i>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('produkt.show',['produkt'=>$equipment->produkt]) }}">
                Produkt bearbeitem <i class="ml-2 far fa-edit"></i>
            </a>

        </ul>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="h4">Gerät <span class="badge badge-primary"></span> bearbeiten</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="stammdaten-tab" data-toggle="tab" href="#stammdaten" role="tab" aria-controls="stammdaten" aria-selected="true">
                            Stammdaten
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="anforderungen-tab" data-toggle="tab" href="#anforderungen" role="tab" aria-controls="anforderungen" aria-selected="false">
                            Anforderungen </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="dokumente-tab" data-toggle="tab" href="#dokumente" role="tab" aria-controls="dokumente" aria-selected="false">
                            Dokumente
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false">
                            Logs
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="stammdaten" role="tabpanel" aria-labelledby="stammdaten-tab">
                        <div class="row">
                            <div class="col-md-7 mb-3">
<h2 class="h4">Übesicht / Stammdaten</h2>
                                <x-staticfield id="Bezeichnung" label="Bezeichnung:" value="{{ $equipment->produkt->prod_name_lang }}"/>
                                <x-staticfield id="Standort" label="Standort:" value="{{ App\Standort::find($equipment->standort_id)->std_kurzel }}"/>
                                <x-staticfield id="eq_inventar_nr" label="Inventarnummer:" value="{{ $equipment->eq_inventar_nr }}"/>
                                <x-staticfield id="eq_ibm" label="Inbetriebnahme am:" value="{{ $equipment->eq_ibm }}"/>
                                <x-staticfield id="eq_serien_nr" label="Seriennummer:" value="{{ $equipment->eq_serien_nr ?? '-' }}"/>
                                <label for="firma">Hersteller:</label>
                                <input type="text" id="firma" class="form-control-plaintext"
                                       value="@foreach ($equipment->produkt->firma as $firma) {{ $firma->fa_name_lang }} @endforeach">
<button class="btn btn-primary btn-lg mt-3">Prüfung/Wartung erfassen</button>

                            </div>
                            <div class="col-md-5 pl-3 mb-3">
                                <h2 class="h4">Gerätestatus</h2>

                                <span class=" fas mb-3   fa-4x fa-border {{ $equipment->EquipmentState->estat_icon }} text-{{ $equipment->EquipmentState->estat_color }}"></span>
                                <h2 class="h4 mt-5">@if (App\ProduktDoc::where('document_type_id',1)->count() >1 )Anleitungen @else Anleitung @endif </h2>
                                @forelse(App\ProduktDoc::where('document_type_id',1)->get() as $bda)

                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->proddoc_name_kurz }}</span><br>
                                            <span class="lead">{{ $bda->proddoc_name_lang }}</span><br>
                                            {{ number_format(\Illuminate\Support\Facades\Storage::size($bda->proddoc_name_pfad)/1028,1) }}kB
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-primary"><span class="fas fa-download"></span></button>
                                        </div>

                                    </div>

                                    @empty
                                    <span class="text-muted text-center small">keine Anleitungen hinterlegt</span>
                                @endforelse

                                <h2 class="h4 mt-5">Prüfungen </h2>
                                @forelse(App\ControlDoc::all() as $bda)

                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->proddoc_name_kurz }}</span><br>
                                            <span class="lead">{{ $bda->proddoc_name_lang }}</span><br>
                                            {{ number_format(\Illuminate\Support\Facades\Storage::size($bda->proddoc_name_pfad)/1028,1) }}kB
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-primary"><span class="fas fa-download"></span></button>
                                        </div>

                                    </div>

                                @empty
                                    <span class="text-muted text-center small">keine Prüfberichte hinterlegt</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10"></div>
                        </div>
                    </div>

                    <div class="tab-pane fade p-2" id="anforderungen" role="tabpanel" aria-labelledby="anforderungen-tab">

                        @php
                            $Anforderung = App\Anforderung::all();
                        @endphp
                        @forelse (\App\ProduktAnforderung::where('produkt_id',$equipment->produkt->id)->get() as $produktAnforderung)
                            @if ($produktAnforderung->anforderung_id!=0)
                                <div class="card p-2 mb-2">
                                    <dl class="row lead">
                                        <dt class="col-md-3">Verordnung</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">Anforderung</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">Bezeichnung</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">Intervall</dt>
                                        <dd class="col-md-9">
                                            {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                            {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_name }}
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">Beschreibung</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">
                                            {{ (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->count()>1) ? 'Vorgänge' : 'Vorgang' }}
                                        </dt>
                                        <dd class="col-md-9">
                                            <ul class="list-group">
                                                @foreach (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->get() as $aci)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $aci->aci_name_lang }}
                                                        <a href="#" class="btn-outline-primary btn btn-sm">jetzt prüfen</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted small">Bislang sind keine Anforderungen verknüpft!</p>
                        @endforelse

                    </div>

                    <div class="tab-pane fade p-2" id="anforderungen" role="tabpanel" aria-labelledby="prodPruefungen-tab">
                    </div>

                    <div class="tab-pane fade p-2" id="dokumente" role="tabpanel" aria-labelledby="dokumente-tab">


                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h4">Geräte-Dokumente</h3>

                            </div>
                            <div class="col-md-6">
                                <h3 class="h4">Produkt-Dokumente</h3>
                                @if (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->count()>0)
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <th>Datei</th>
                                        <th>Typ</th>
                                        <th style="text-align: right;">Größe kB</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->get() as $produktDoc)
                                            <tr>
                                                <td>{{ $produktDoc->proddoc_name_lang }}</td>
                                                <td>{{ $produktDoc->DocumentType->doctyp_name_kurz }}</td>
                                                <td style="text-align: right;">{{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}</td>
                                                <td>
                                                    <form action="{{ route('downloadProduktDokuFile') }}#prodDoku" method="get" id="downloadProdDoku_{{ $produktDoc->id }}">
                                                        @csrf
                                                        <input type="hidden"
                                                               name="id"
                                                               id="download_produktdoc_id_{{ $produktDoc->id }}"
                                                               value="{{ $produktDoc->id }}"
                                                        >
                                                    </form>
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();">
                                                        <span class="fas fa-download"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="small text-muted">Keine Dateien zum Produkt gefunden!</p>
                                @endif
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade p-2" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h5">Historie</h3>
                                @foreach (App\EquipmentHistory::where('equipment_id',$equipment->id)->latest()->get() as $equipmentHistorie)
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ $equipmentHistorie->created_at }}</dt>
                                        <dd class="col-sm-8">{{ $equipmentHistorie->eqh_eintrag_text }}</dd>
                                    </dl>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5">Logs</h3>
                                <table class="table">
                                <thead>
                                <tr>
                                    <th>Zeit</th>
                                    <th style="text-align: right;">Ist</th>
                                    <th style="text-align: right;">Soll</th>
                                    <th style="text-align: center;">pass</th>
                                </tr>
                                </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

@endsection
