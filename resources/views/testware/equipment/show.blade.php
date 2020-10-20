@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Gerät')}} {{ $equipment->eq_inventar_nr }} bearbeiten &triangleright; {{__('Geräte')}} @ bitpack GmbH
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('actionMenuItems')
    <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navTargetAppAktionItems" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bars"></i> {{__('Gerät')}} </a>
        <ul class="dropdown-menu" aria-labelledby="navTargetAppAktionItems">
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('equipment.edit',['equipment'=>$equipment]) }}">
                {{__('Gerät bearbeiten')}} <i class="ml-2 far fa-edit"></i>
            </a>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#" data-toggle="modal" data-target="#modalAddEquipDoc">
                {{__('Datei hinzufügen')}} <i class="ml-2 fas fa-upload"></i>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('makePDFEquipmentDataSheet',$equipment) }}" download>
                {{__('Datenblatt Drucken')}} <i class="ml-2 fas fa-print"></i>
            </a>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('makePDFEquipmentLabel',$equipment) }}" download>
                {{__('QR-Code Drucken')}} <i class="ml-2 fas fa-qrcode"></i>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('produkt.show',['produkt'=>$equipment->produkt]) }}">
                {{__('Produkt bearbeiten')}} <i class="ml-2 far fa-edit"></i>
            </a>

        </ul>
    </li>
@endsection

@section('modals')
    <div class="modal fade" id="modalAddEquipDoc" tabindex="-1" aria-labelledby="modalAddEquipDocLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('equipDoku.store') }}#dokumente" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddEquipDocLabel">{{__('Dokument an Gerät anhängen')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="equipment_id" id="equipment_id_doku" value="{{ $equipment->id }}">

                        <x-selectfield id="document_type_id" label="{{__('Dokument Typ')}}">
                            @foreach (App\DocumentType::all() as $ad)
                                <option value="{{ $ad->id }}">{{ $ad->doctyp_name_kurz }}</option>
                            @endforeach
                        </x-selectfield>

                        <x-textfield id="eqdoc_name_kurz" label="{{__('Bezeichnung')}}" />

                        <x-textarea id="eqdoc_name_text" label="{{__('Datei Informationen')}}" />


                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" id="equipDokumentFile" name="equipDokumentFile"
                                       data-browse="Datei"
                                       class="custom-file-input"
                                       accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                       required
                                >
                                <label class="custom-file-label" for="equipDokumentFile">{{__('Datei wählen')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Dokument hochladen')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalStartControl" tabindex="-1" aria-labelledby="modalStartControlLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalStartControlLabel">{{__('Prüfung/Wartung starten')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Folgende Prüfungen/Wartungen sind für das Gerät vorgesegen. Bitte wählen Sie das entspechende aus.') }}</p>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Prüfung</th>
                            <th>Fällig</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse (App\ControlEquipment::where('equipment_id',$equipment->id)->orderBy('qe_control_date_due')->get() as $controlItem)
                          <tr>
                              <td>{{ $controlItem->Anforderung->an_name_lang }}</td>
                              <td>{!!  $controlItem->checkDueDate($controlItem) !!} </td>
                              <td><a href="{{ route('control.create',['controlItem' => $controlItem]) }}" class="btn btn-sm btn-outline-primary">
                                      Prüfung starten</a></td>
                          </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <x-notifyer>Keine Prüfungen hinterlegt.</x-notifyer>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <h1 class="h3">{{ __('Geräteübersicht')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs mainNavTab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="stammdaten-tab" data-toggle="tab" href="#stammdaten" role="tab" aria-controls="stammdaten" aria-selected="true"> {{ __('Stammdaten')}}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="anforderungen-tab" data-toggle="tab" href="#anforderungen" role="tab" aria-controls="anforderungen" aria-selected="false"> {{ __('Anforderungen')}} </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="dokumente-tab" data-toggle="tab" href="#dokumente" role="tab" aria-controls="dokumente" aria-selected="false"> {{ __('Dokumente')}}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false"> {{ __('Logs')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="stammdaten" role="tabpanel" aria-labelledby="stammdaten-tab">
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <h2 class="h4">{{ __('Übersicht / Stammdaten')}}</h2>
                                <x-staticfield id="Bezeichnung" label="{{__('Bezeichnung')}}:" value="{{ $equipment->produkt->prod_name_lang }}"/>
                                <x-staticfield id="Standort" label="{{__('Standort')}}:" value="{{ App\Standort::find($equipment->standort_id)->std_kurzel }}"/>
                                <x-staticfield id="eq_inventar_nr" label="{{__('Inventarnummer')}}:" value="{{ $equipment->eq_inventar_nr }}"/>
                                <x-staticfield id="eq_ibm" label="{{__('Inbetriebnahme am')}}:" value="{{ $equipment->eq_ibm }}"/>
                                <x-staticfield id="eq_serien_nr" label="{{__('Seriennummer')}}:" value="{{ $equipment->eq_serien_nr ?? '-' }}"/>
                                <label for="firma">{{__('Hersteller')}}:</label>
                                <input type="text" id="firma" class="form-control-plaintext"
                                       value="@foreach ($equipment->produkt->firma as $firma) {{ $firma->fa_name_lang }} @endforeach">
                                <button
                                    class="btn btn-primary btn-lg mt-3"
                                    data-toggle="modal" data-target="#modalStartControl"
                                >{{__('Prüfung/Wartung erfassen')}}</button>

                            </div>
                            <div class="col-md-5 pl-3 mb-3">
                                @if ($equipment->produkt->ControlProdukt)
                                    <h2 class="h4 mb-2">{{__('Prüfmittel - Gerätestatus')}}</h2>
                                @else
                                    <h2 class="h4 mb-2">{{__('Gerätestatus')}}</h2>
                                @endif


                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class=" fas  fa-4x fa-border {{ $equipment->EquipmentState->estat_icon }} text-{{ $equipment->EquipmentState->estat_color }}"></span>
                                    <span class="lead mr-3">{{ $equipment->EquipmentState->estat_name_lang }}</span>
                                </div>



                                <h2 class="h4 mt-5">@if (App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->count() >1 ){{__('Anleitungen')}} @else {{__('Anleitung')}} @endif </h2>
                                @forelse(App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->get() as $bda)

                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->proddoc_name_kurz }}</span><br>
                                            <span class="lead">{{ $bda->proddoc_name_lang }}</span><br>
                                            {{ number_format(\Illuminate\Support\Facades\Storage::size($bda->proddoc_name_pfad)/1028,1) }}kB
                                        </div>
                                        <div>
                                            <form action="{{ route('downloadProduktDokuFile') }}#dokumente" method="get" id="downloadBDA_{{ $bda->id }}">
                                                @csrf
                                                <input type="hidden"
                                                       name="id"
                                                       id="bda_{{ $bda->id }}"
                                                       value="{{ $bda->id }}"
                                                >
                                            </form>
                                            <button
                                                class="btn btn-lg btn-outline-primary"
                                                onclick="event.preventDefault(); document.getElementById('downloadBDA_{{ $bda->id }}').submit();">
                                                <span class="fas fa-download"></span>
                                            </button>
                                        </div>

                                    </div>

                                @empty
                                    <span class="text-muted text-center small">{{__('keine Anleitungen hinterlegt')}}</span>
                                @endforelse

                                <h2 class="h4 mt-5">{{__('Prüfungen')}} </h2>
                                @forelse(App\ControlDoc::all() as $bda)

                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->proddoc_name_kurz }}</span><br>
                                            <span class="lead">{{ $bda->proddoc_name_lang }}</span><br>
                                            {{ number_format(\Illuminate\Support\Facades\Storage::size($bda->proddoc_name_pfad)/1028,1) }}kB
                                        </div>
                                        <div>
                                            <form action="{{ route('downloadProduktDokuFile') }}#prodDoku" method="get" id="downloadBDA_{{ $bda->id }}">
                                                @csrf
                                                <input type="hidden"
                                                       name="id"
                                                       id="bda_{{ $bda->id }}"
                                                       value="{{ $bda->id }}"
                                                >
                                            </form>
                                            <button
                                                class="btn btn-lg btn-outline-primary"
                                                onclick="event.preventDefault(); document.getElementById('downloadBDA').submit();">
                                                <span class="fas fa-download"></span>
                                            </button>
                                        </div>

                                    </div>
                                @empty
                                    <x-notifyer>{{__('keine Prüfberichte hinterlegt')}}</x-notifyer>
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
                                        <dt class="col-md-3">{{ __('Verordnung')}}</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_name_kurz }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">{{__('Anforderung')}}</dt>
                                        <dd class="col-md-9 d-flex justify-content-between align-items-center">
                                            {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_kurz }}
                                            <a href="#" class="btn-primary btn btn-sm">jetzt prüfen</a>
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">{{ __('Bezeichnung')}}</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_lang }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">{{ __('Intervall')}}</dt>
                                        <dd class="col-md-9">
                                            {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                            {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_name }}
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">{{ __('Beschreibung')}}</dt>
                                        <dd class="col-md-9">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text }}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-md-3">
                                            {{ (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->count()>1) ? __('Vorgänge') : __('Vorgang') }}
                                        </dt>
                                        <dd class="col-md-9">
                                            <ul class="list-group">
                                                @foreach (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->get() as $aci)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $aci->aci_name_lang }}

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted small">{{ __('Bislang sind keine Anforderungen verknüpft')}}!</p>
                        @endforelse

                    </div>

                    <div class="tab-pane fade p-2" id="anforderungen" role="tabpanel" aria-labelledby="prodPruefungen-tab">
                    </div>

                    <div class="tab-pane fade p-2" id="dokumente" role="tabpanel" aria-labelledby="dokumente-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h4">{{__('Geräte')}}</h3>
                                @if (\App\EquipmentDoc::where('equipment_id',$equipment->id)->count()>0)
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <th>{{ __('Datei')}}</th>
                                        <th>{{ __('Typ')}}</th>
                                        <th style="text-align: right;">{{ __('Größe')}} kB</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach (\App\EquipmentDoc::where('equipment_id',$equipment->id)->get() as $equipDoc)
                                            <tr>
                                                <td>{{ $equipDoc->eqdoc_name_lang }}</td>
                                                <td>{{ $equipDoc->DocumentType->doctyp_name_kurz }}</td>
                                                <td style="text-align: right;">{{ $equipDoc->getSize($equipDoc->eqdoc_name_pfad) }}</td>
                                                <td>
                                                    <form action="{{ route('downloadProduktDokuFile') }}#prodDoku"
                                                          method="get" id="downloadProdDoku_{{ $equipDoc->id }}">
                                                        @csrf
                                                        <input type="hidden"
                                                               name="id"
                                                               id="download_produktdoc_id_{{ $equipDoc->id }}"
                                                               value="{{ $equipDoc->id }}"
                                                        >
                                                    </form>
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $equipDoc->id }}').submit();">
                                                        <span class="fas fa-download"></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <x-deletebutton action="{{ route('equipDoku.destroy',$equipDoc->id) }}#dokumente" id="{{ $equipDoc->id }}" />
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <x-notifyer>{{__('Keine Dateien zum Gerät gefunden')}}!</x-notifyer>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <h3 class="h4">{{__('Produkt')}}</h3>
                                @if (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->count()>0)
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <th>{{ __('Datei')}}</th>
                                        <th>{{ __('Typ')}}</th>
                                        <th style="text-align: right;">{{ __('Größe')}} kB</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->get() as $produktDoc)
                                            <tr>
                                                <td>{{ $produktDoc->proddoc_name_lang }}</td>
                                                <td>{{ $produktDoc->DocumentType->doctyp_name_kurz }}</td>
                                                <td style="text-align: right;">{{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}</td>
                                                <td>
                                                    <form action="{{ route('downloadProduktDokuFile') }}#prodDoku"
                                                          method="get" id="downloadProdDoku_{{ $produktDoc->id }}">
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
                                    <x-notifyer>{{__('Keine Dateien zum Produkt gefunden')}}!</x-notifyer>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade p-2" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h5">{{__('Historie')}}</h3>
                                @foreach (App\EquipmentHistory::where('equipment_id',$equipment->id)->latest()->get() as $equipmentHistorie)
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ $equipmentHistorie->created_at }}</dt>
                                        <dd class="col-sm-8">{{ $equipmentHistorie->eqh_eintrag_text }}</dd>
                                    </dl>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5">{{__('Logs')}}</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Zeit')}}</th>
                                        <th style="text-align: right;">{{__('Ist')}}</th>
                                        <th style="text-align: right;">{{__('Soll')}}</th>
                                        <th style="text-align: center;">{{__('pass')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @error('eqdoc_name_kurz')
    <script>
        $('#modalAddEquipDoc').modal('show');
    </script>
    @enderror
@endsection
