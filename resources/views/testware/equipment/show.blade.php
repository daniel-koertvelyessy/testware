@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Gerät')}} {{ $equipment->eq_inventar_nr }} bearbeiten &triangleright; {{__('Geräte')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('actionMenuItems')
    <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navTargetAppAktionItems"
           role="button"
           data-toggle="dropdown"
           aria-expanded="false"
        ><i class="fas fa-bars"></i> {{__('Gerät')}} </a>
        <ul class="dropdown-menu"
            aria-labelledby="navTargetAppAktionItems"
        >
            <a class="dropdown-item d-flex justify-content-between align-items-center"
               href="{{ route('equipment.edit',['equipment'=>$equipment]) }}"
            >
                {{__('Gerät bearbeiten')}} <i class="ml-2 far fa-edit"></i></a>
            <a class="dropdown-item d-flex justify-content-between align-items-center"
               href="#"
               data-toggle="modal"
               data-target="#modalAddEquipDoc"
            >
                {{__('Datei hinzufügen')}} <i class="ml-2 fas fa-upload"></i></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center"
               href="{{ route('makePDFEquipmentDataSheet',$equipment) }}"
               download
            >
                {{__('Datenblatt Drucken')}} <i class="ml-2 fas fa-print"></i></a>
            <a class="dropdown-item d-flex justify-content-between align-items-center"
               href="{{ route('makePDFEquipmentLabel',$equipment->id) }}"
               target="_blank"
            >
                {{__('QR-Code Drucken')}} <i class="ml-2 fas fa-qrcode"></i></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-between align-items-center"
               href="{{ route('produkt.show',['produkt'=>$equipment->produkt]) }}"
            >
                {{__('Produkt bearbeiten')}} <i class="ml-2 far fa-edit"></i></a>

        </ul>
    </li>
@endsection

@section('modals')
    <div class="modal fade"
         id="modalAddEquipDoc"
         tabindex="-1"
         aria-labelledby="modalAddEquipDocLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('equipDoku.store') }}#dokumente"
                      method="POST"
                      enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddEquipDocLabel"
                        >{{__('Dokument an Gerät anhängen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_doku"
                               value="{{ $equipment->id }}"
                        >

                        <x-selectfield id="document_type_id"
                                       label="{{__('Dokument Typ')}}"
                        >
                            @foreach (App\DocumentType::all() as $ad)
                                <option value="{{ $ad->id }}">{{ $ad->doctyp_label }}</option>
                            @endforeach
                        </x-selectfield>

                        <x-textfield id="eqdoc_label"
                                     label="{{__('Bezeichnung')}}"
                        />

                        <x-textarea id="eqdoc_name_text"
                                    label="{{__('Datei Informationen')}}"
                        />

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file"
                                       id="equipDokumentFile"
                                       name="equipDokumentFile"
                                       data-browse="Datei"
                                       class="custom-file-input"
                                       accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                       required
                                >
                                <label class="custom-file-label"
                                       for="equipDokumentFile"
                                >{{__('Datei wählen')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-dismiss="modal"
                        >{{__('Abbruch')}}</button>
                        <button class="btn btn-primary">{{__('Dokument hochladen')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="modalStartControl"
         tabindex="-1"
         aria-labelledby="modalStartControlLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalStartControlLabel"
                    >{{__('Prüfung/Wartung starten')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Folgende Prüfungen/Wartungen sind für das Gerät vorgesegen. Bitte wählen Sie das entspechende aus.') }}</p>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('Prüfung')}}</th>
                            <th>{{__('Fällig')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse (App\ControlEquipment::where('equipment_id',$equipment->id)->orderBy('qe_control_date_due')->get() as $controlItem)
                            <tr>
                                <td>{{ $controlItem->Anforderung->an_name }}</td>
                                <td>{!!  $controlItem->checkDueDate($controlItem) !!} </td>
                                <td>
                                    <a href="{{ route('testing.create',['test_id' => $controlItem]) }}"
                                       class="btn btn-sm btn-outline-primary"
                                    > {{__('Prüfung starten')}}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <x-notifyer>{{__('Keine Prüfungen hinterlegt')}}</x-notifyer>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="controlEventModal"
         tabindex="-1"
         aria-labelledby="controlEventModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="controlEventModalLabel"
                    >{{__('Prüfung')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"
                     id="controlEventModalBody"
                >
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                    >{{ __('Schließen') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="addQualifiedUser"
         tabindex="-1"
         aria-labelledby="addQualifiedUserLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"
                        id="addQualifiedUserLabel"
                    >{{__('Befähigte Person hinzufügen')}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('EquipmentQualifiedUser.store') }}"
                      method="post"
                >
                    <div class="modal-body">

                        @csrf
                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_qualified_user"
                               value="{{ $equipment->id }}"
                        >
                        <div class="row">
                            <div class="col-md-4">
                                <x-datepicker id="equipment_qualified_date"
                                              label="{{ __('Befähigung erhalten am') }}"
                                              value="{{ date('Y-m-d') }}"
                                />
                            </div>
                            <div class="col-md-8">
                                <x-selectfield id="equipment_qualified_firma"
                                               label="{{__('durch Firma / Institution')}}"
                                >
                                    @forelse($equipment->produkt->firma as $firma)
                                        <option value="{{ $firma->id }}">{{ $firma->fa_name }}</option>
                                    @empty
                                        @foreach(App\Firma::all() as $company)
                                            <option value="{{ $company->id }}">{{ $company->fa_name }}</option>
                                        @endforeach
                                    @endforelse
                                </x-selectfield>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <x-selectfield id="user_id"
                                               label="{{__('Mitarbeiter')}}"
                                >
                                    @foreach(App\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            {{__('Befähigte Person anlegen')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="addInstructedUser"
         tabindex="-1"
         aria-labelledby="addInstructedUserLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <form action="{{ route('EquipmentInstruction.store') }}"
                  method="post"
                  id="frmAddEquipmentInstruction"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="addInstructedUserLabel"
                        >{{__('Unterwiesene Person hinzufügen')}}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden"
                               name="equipment_id"
                               id="equipment_id_instructions_modal"
                               value="{{ $equipment->id }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <x-datepicker id="equipment_instruction_date"
                                              label="{{__('Unterweisung erfolgte am')}}"
                                              value="{{ date('Y-m-d') }}"
                                              required
                                />
                                <x-selectfield id="equipment_instruction_trainee_id"
                                               label="{{__('Unterwiesene Person')}}"
                                >
                                    @foreach(App\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                            <div class="col-md-6">
                                <x-selectfield id="equipment_instruction_instructor_profile_id"
                                               label="{{__('Interne Unterweisung durch')}}"
                                               required
                                >
                                    <option value="0">{{ __('bitte auswählen') }}</option>
                                    @foreach(App\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </x-selectfield>
                                <x-selectfield id="equipment_instruction_instructor_firma_id"
                                               label="{{__('Externe Unterweisung durch')}}"
                                >
                                    <option value="0">{{__('bitte auswählen')}}</option>
                                    @foreach($equipment->produkt->firma as $firma)
                                        <option value="{{ $firma->id }}">{{ $firma->fa_name }}</option>
                                    @endforeach
                                </x-selectfield>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label>{{__('Unterschrift Unterwiesener')}}</label>
                                    <div>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnClearCanvas"
                                                data-targetpad="trainee"
                                        >{{__('Neu')}}</button>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnSignZuruck"
                                                data-targetpad="trainee"
                                        >{{__('Zurück')}}</button>
                                    </div>
                                </div>
                                <input type="hidden"
                                       name="equipment_instruction_trainee_signature"
                                       id="equipment_instruction_trainee_signature"
                                >
                                <div class="wrapper">
                                    <canvas id="signatureField_equipment_instruction_trainee_signature"
                                            class="signature-pad"
                                    ></canvas>
                                </div>
                                <span class="small text-primary">{{ __('erforderliches Feld') }}</span>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label>{{__('Unterschrift Einweiser')}}</label>
                                    <div>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnClearCanvas"
                                                data-targetpad="instructor"
                                        >{{__('Neu')}}</button>
                                        <button type="button"
                                                class="btn btn-link btn-sm btnSignZuruck"
                                                data-targetpad="instructor"
                                        >{{__('Zurück')}}</button>
                                    </div>
                                </div>
                                <input type="hidden"
                                       name="equipment_instruction_instructor_signature"
                                       id="equipment_instruction_instructor_signature"
                                >
                                <div class="wrapper">
                                    <canvas id="signatureField_equipment_instruction_instructor_signature"
                                            class="signature-pad"
                                    ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">{{ __('Unterweisung erfassen') }}</button>
                    </div>
                </div>
            </form>
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
                <ul class="nav nav-tabs mainNavTab d-flex flex-column flex-md-row"
                    id="myTab"
                    role="tablist"
                >
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link active"
                           id="stammdaten-tab"
                           data-toggle="tab"
                           href="#stammdaten"
                           role="tab"
                           aria-controls="stammdaten"
                           aria-selected="true"
                        > {{ __('Stammdaten')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="anforderungen-tab"
                           data-toggle="tab"
                           href="#anforderungen"
                           role="tab"
                           aria-controls="anforderungen"
                           aria-selected="false"
                        > {{ __('Anforderungen')}} </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="dokumente-tab"
                           data-toggle="tab"
                           href="#dokumente"
                           role="tab"
                           aria-controls="dokumente"
                           aria-selected="false"
                        > {{ __('Dokumente')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="logs-tab"
                           data-toggle="tab"
                           href="#logs"
                           role="tab"
                           aria-controls="logs"
                           aria-selected="false"
                        > {{ __('Logs')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="events-tab"
                           data-toggle="tab"
                           href="#events"
                           role="tab"
                           aria-controls="events"
                           aria-selected="false"
                        > {{ __('Ereignisse')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active p-2"
                         id="stammdaten"
                         role="tabpanel"
                         aria-labelledby="stammdaten-tab"
                    >
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <h2 class="h4">{{ __('Übersicht / Stammdaten')}}</h2>
                                <x-staticfield id="Bezeichnung"
                                               label="{{__('Bezeichnung')}}:"
                                               value="{!! $equipment->produkt->prod_name !!}"
                                />
                                <x-staticfield id="Standort"
                                               label="{{__('Aufstellplatz / Standort')}}:"
                                               value="{!!  App\Standort::find($equipment->standort_id)->std_kurzel !!}"
                                />
                                <x-staticfield id="eq_inventar_nr"
                                               label="{{__('Inventarnummer')}}:"
                                               value="{!!  $equipment->eq_inventar_nr !!}"
                                />
                                <x-staticfield id="eq_ibm"
                                               label="{{__('Inbetriebnahme am')}}:"
                                               value="{!!  $equipment->eq_ibm !!}"
                                />
                                <x-staticfield id="eq_serien_nr"
                                               label="{{__('Seriennummer')}}:"
                                               value="{!!  $equipment->eq_serien_nr ?? '-' !!}"
                                />
                                <label for="firma">{{__('Hersteller')}}:</label>
                                <input type="text"
                                       id="firma"
                                       class="form-control-plaintext"
                                       value="@foreach ($equipment->produkt->firma as $firma) {!! $firma->fa_name !!} @endforeach"
                                >
                                <button
                                    class="btn btn-primary btn-lg mt-3"
                                    data-toggle="modal"
                                    data-target="#modalStartControl"
                                >{{__('Prüfung/Wartung erfassen')}}</button>
                            </div>
                            <div class="col-md-5 pl-3 mb-3">
                                @if ($equipment->produkt->ControlProdukt)
                                    <h2 class="h4 mb-2">{{__('Prüfmittel - Gerätestatus')}}</h2>
                                @else
                                    <h2 class="h4 mb-2">{{__('Gerätestatus')}}</h2>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class=" fas  fa-4x fa-border {{ $equipment->EquipmentState->estat_icon }} text-{{ $equipment->EquipmentState->estat_color }}"></span> <span class="lead mr-3">{{ $equipment->EquipmentState->estat_name }}</span>
                                </div>


                                <h2 class="h4 mt-5">@if (App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->count() >1 ){{__('Anleitungen')}} @else {{__('Anleitung')}} @endif </h2>
                                @forelse(App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->get() as $bda)

                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->proddoc_label }}</span><br> <span class="lead">{{ str_limit($bda->proddoc_name,30) }}</span><br> <span class="text-muted small">
                                                {{ App\helpers::fileSizeForHumans(\Illuminate\Support\Facades\Storage::size($bda->proddoc_name_pfad)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <form action="{{ route('downloadProduktDokuFile') }}#dokumente"
                                                  method="get"
                                                  id="downloadBDA_{{ $bda->id }}"
                                            >
                                                @csrf
                                                <input type="hidden"
                                                       name="id"
                                                       id="bda_{{ $bda->id }}"
                                                       value="{{ $bda->id }}"
                                                >
                                            </form>
                                            <button
                                                class="btn btn-lg btn-outline-primary"
                                                onclick="event.preventDefault(); document.getElementById('downloadBDA_{{ $bda->id }}').submit();"
                                            >
                                                <span class="fas fa-download"></span>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-muted text-center small">{{__('keine Anleitungen hinterlegt')}}</span>
                                @endforelse
                                <h2 class="h4 mt-5">Funtionstest</h2>
                                @forelse(App\EquipmentDoc::where('equipment_id',$equipment->id)->where('document_type_id',2)->get() as $bda)
                                    <div class="border rounded p-2 my-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small">{{ $bda->eqdoc_label }}</span><br> <span class="lead">{{ str_limit($bda->eqdoc_name,30) }}</span><br> <span class="text-muted small">
                                                {{ App\helpers::fileSizeForHumans(\Illuminate\Support\Facades\Storage::size($bda->eqdoc_name_pfad)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <form action="{{ route('downloadEquipmentDokuFile') }}#dokumente"
                                                  method="get"
                                                  id="downloadFuntionsTest_{{ $bda->id }}"
                                            >
                                                @csrf
                                                <input type="hidden"
                                                       name="id"
                                                       id="FuntionsTest_{{ $bda->id }}"
                                                       value="{{ $bda->id }}"
                                                >
                                            </form>
                                            <button
                                                class="btn btn-lg btn-outline-primary"
                                                onclick="event.preventDefault(); document.getElementById('downloadFuntionsTest_{{ $bda->id }}').submit();"
                                            >
                                                <span class="fas fa-download"></span>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-muted text-center small">{{__('keine Dokumente zur Funtionsprüfung gefunden!')}}</span>
                                @endforelse
                                <h2 class="h4 mt-5">{{__('Prüfungen')}} </h2>
                                @forelse(App\ControlEquipment::where('equipment_id',$equipment->id)->take(5)->latest()->onlyTrashed()->get() as $bda)
                                    @if (\App\ControlEvent::where('control_equipment_id',$bda->id)->count()>0)
                                        <div class="border rounded p-1 mb-1 d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-column">
                                            <span class="small text-muted pl-2">
                                                {{$bda->deleted_at->diffForHumans()}}
                                            </span> <span class="p-2">
                                                {{ str_limit($bda->Anforderung->an_name,20) }}
                                            </span>
                                            </div>
                                            <div class="pr-2">
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-primary btnOpenControlEventModal"
                                                        data-control-event-id="{{ \App\ControlEvent::where('control_equipment_id',$bda->id)->get()[0]->id  }}"
                                                ><i class="far fa-folder-open"></i></button>
                                                <a href="{{ route('makePDFEquipmentControlReport',\App\ControlEvent::where('control_equipment_id',$bda->id)->get()[0]->id ) }}"
                                                   download
                                                   class="btn btn-sm btn-outline-primary"
                                                   target="_blank"
                                                ><i class="far fa-file-pdf"></i></a>
                                            </div>
                                        </div>
                                    @endif


                                @empty
                                    <x-notifyer>{{__('keine Prüfberichte hinterlegt')}}</x-notifyer>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="anforderungen"
                         role="tabpanel"
                         aria-labelledby="anforderungen-tab"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <h3 class="h5">{{__('Befähigte Personen')}}</h3>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-toggle="modal"
                                            data-target="#addQualifiedUser"
                                    >
                                        {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                    </button>
                                </div>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Qualifiziert am') }}</th>
                                        <th>{{ __('durch') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse (\App\EquipmentQualifiedUser::all() as $equipmentUser)
                                        <tr>
                                            <td>{{ $equipmentUser->user->name }}</td>
                                            <td>{{ $equipmentUser->equipment_qualified_date }}</td>
                                            <td>{{ $equipmentUser->firma->fa_name ?? '-' }}</td>
                                            <td style="padding: 0; vertical-align: middle; text-align: right;">
                                                <form action="{{ route('EquipmentQualifiedUser.destroy',$equipmentUser) }}"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delete_Qualified_User_{{ $equipmentUser->id }}"
                                                           value="{{ $equipmentUser->id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <span class="d-none d-lg-inline mr-2">{{ __('Löschen') }}</span> <span class="far fa-trash-alt"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <p class="m-2">
                                                    <x-notifyer>{{__('Keine befähigte Personen gefunden')}}</x-notifyer>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="dropdown-divider my-4"></div>
                                <div class="d-flex justify-content-between">
                                    <h3 class="h5">{{__('Unterwiesene Personen')}}</h3>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-toggle="modal"
                                            data-target="#addInstructedUser"
                                    >
                                        {{ __('Person hinzufügen') }} <i class="fas fa-user-plus ml-2"></i>
                                    </button>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Unterwiesen am')}}</th>
                                        <th>{{__('gez.')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse (\App\EquipmentInstruction::all() as $instructedUser)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $instructedUser->user->name }}</td>
                                            <td style="vertical-align: middle;">{{ $instructedUser->equipment_instruction_date }}</td>
                                            <td>
                                                <img src="{{ $instructedUser->equipment_instruction_trainee_signature }}"
                                                     class="img-fluid"
                                                     style="max-height: 40px"
                                                     alt="unterschrift"
                                                >
                                            </td>
                                            <td style="vertical-align: middle; text-align:right; padding:0">
                                                <form action="{{ route('EquipmentInstruction.destroy',$instructedUser) }}#anforderungen"
                                                      method="post"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden"
                                                           name="id"
                                                           id="id_delete_EquipmentInstruction_{{ $instructedUser->id }}"
                                                           value="{{ $instructedUser->id }}"
                                                    >
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <span class="d-none d-lg-inline">{{__('Löschen')}}</span> <span class="far fa-trash-alt ml-2"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <x-notifyer>{{__('Keine unterwiesene Personen gefunden')}}</x-notifyer>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $Anforderung = App\Anforderung::all();
                                @endphp
                                @forelse (\App\ProduktAnforderung::where('produkt_id',$equipment->produkt->id)->get() as $produktAnforderung)
                                    @if ($produktAnforderung->anforderung_id!=0)
                                        <div class="card p-2 mb-2">
                                            <dl class="row lead">
                                                <dt class="col-md-5 col-lg-4">{{ __('Verordnung')}}</dt>
                                                <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->Verordnung->vo_label }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-md-5 col-lg-4">{{__('Anforderung')}}</dt>
                                                <dd class="col-md-7 col-lg-8 ">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_label }}
                                                </dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-md-5 col-lg-4">{{ __('Bezeichnung')}}</dt>
                                                <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-md-5 col-lg-4">{{ __('Intervall')}}</dt>
                                                <dd class="col-md-7 col-lg-8">
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->an_control_interval }}
                                                    {{ $Anforderung->find($produktAnforderung->anforderung_id)->ControlInterval->ci_label }}
                                                </dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-md-5 col-lg-4">{{ __('Beschreibung')}}</dt>
                                                <dd class="col-md-7 col-lg-8">{{ $Anforderung->find($produktAnforderung->anforderung_id)->an_name_text ?? '-' }}</dd>
                                            </dl>
                                            <dl class="row">
                                                <dt class="col-md-5 col-lg-4">
                                                    {{ (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->count()>1) ? __('Vorgänge') : __('Vorgang') }}
                                                </dt>
                                                <dd class="col-md-7 col-lg-8">
                                                    <ul class="list-group">
                                                        @forelse (App\AnforderungControlItem::where('anforderung_id',$produktAnforderung->anforderung_id)->get() as $aci)
                                                            <li class="list-group-item">
                                                                {{ $aci->aci_name }}
                                                            </li>
                                                        @empty
                                                            <li class="list-group-item">
                                                                <x-notifyer>{{__('Keine Daten gefunden!')}}</x-notifyer>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </dd>
                                            </dl>
                                        </div>
                                    @endif
                                @empty
                                    <p class="text-muted small">{{ __('Bislang sind keine Anforderungen verknüpft')}}!</p>
                                @endforelse
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade p-2"
                         id="dokumente"
                         role="tabpanel"
                         aria-labelledby="dokumente-tab"
                    >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills"
                                     id="v-pills-tab"
                                     role="tablist"
                                     aria-orientation="vertical"
                                >
                                    <a class="nav-link active"
                                       id="equipDocuEquipment-tab"
                                       data-toggle="pill"
                                       href="#equipDocuEquipment"
                                       role="tab"
                                       aria-controls="equipDocuEquipment"
                                       aria-selected="true"
                                    >{{__('Gerät')}}</a>
                                    <a class="nav-link"
                                       id="equipDocuFuntion-tab"
                                       data-toggle="pill"
                                       href="#equipDocuFuntion"
                                       role="tab"
                                       aria-controls="equipDocuFuntion"
                                       aria-selected="false"
                                    >{{ __('Funktionsprüfung') }}</a>
                                    <a class="nav-link"
                                       id="equipDocuProduct-tab"
                                       data-toggle="pill"
                                       href="#equipDocuProduct"
                                       role="tab"
                                       aria-controls="equipDocuProduct"
                                       aria-selected="false"
                                    >{{__('Produkt')}}</a>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content"
                                     id="v-pills-tabContent"
                                >
                                    <div class="tab-pane fade show active"
                                         id="equipDocuEquipment"
                                         role="tabpanel"
                                         aria-labelledby="equipDocuEquipment-tab"
                                    >
                                        @if (\App\EquipmentDoc::where('equipment_id',$equipment->id)->count()>0)
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}}</th>
                                                <th></th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @foreach (\App\EquipmentDoc::where('equipment_id',$equipment->id)->get() as $equipDoc)
                                                    <tr>
                                                        <td>
                                                            <span class="d-md-none">{{ str_limit($equipDoc->eqdoc_name,20) }}</span> <span class="d-none d-md-inline">{{ $equipDoc->eqdoc_name }}</span>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">{{ $equipDoc->DocumentType->doctyp_label }}</td>
                                                        <td style="text-align: right;">
                                                            {{ $equipDoc->getSize($equipDoc->eqdoc_name_pfad) }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('downloadEquipmentDokuFile') }}#dokumente"
                                                                  method="get"
                                                                  id="downloadEquipmentDoku_{{ $equipDoc->id }}"
                                                            >
                                                                @csrf
                                                                <input type="hidden"
                                                                       name="id"
                                                                       id="download_equipment_id_{{ $equipDoc->id }}"
                                                                       value="{{ $equipDoc->id }}"
                                                                >
                                                            </form>
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary"
                                                                onclick="event.preventDefault(); document.getElementById('downloadEquipmentDoku_{{ $equipDoc->id }}').submit();"
                                                            >
                                                                <span class="fas fa-download"></span>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <x-deletebutton action="{{ route('equipDoku.destroy',$equipDoc->id) }}"
                                                                            tabtarget="dokumente"
                                                                            prefix="EquipmentDoku"
                                                                            id="{{ $equipDoc->id }}"
                                                            />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <x-notifyer>{{__('Keine Dateien zum Gerät gefunden')}}!</x-notifyer>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade"
                                         id="equipDocuFuntion"
                                         role="tabpanel"
                                         aria-labelledby="equipDocuFuntion-tab"
                                    >
                                        @if (App\EquipmentDoc::where('equipment_id',$equipment->id)->where('document_type_id',2)->count()>0)
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}}</th>
                                                <th></th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @foreach (App\EquipmentDoc::where('equipment_id',$equipment->id)->where('document_type_id',2)->get() as $equipFunctionDoc)
                                                    <tr>
                                                        <td>
                                                            <span class="d-md-none">{{ str_limit($equipDoc->eqdoc_name,20) }}</span> <span class="d-none d-md-inline">{{ $equipDoc->eqdoc_name }}</span>
                                                        </td>
                                                        <td class="d-none d-md-table-cell"> {{ $equipFunctionDoc->DocumentType->doctyp_label }}</td>
                                                        <td style="text-align: right;">
                                                            {{ $equipFunctionDoc->getSize($equipFunctionDoc->eqdoc_name_pfad) }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('downloadEquipmentDokuFile') }}#dokumente"
                                                                  method="get"
                                                                  id="downloadEquipmentFunction_{{ $equipFunctionDoc->id }}"
                                                            >
                                                                @csrf
                                                                <input type="hidden"
                                                                       name="id"
                                                                       id="download_equipment_function_id_{{ $equipFunctionDoc->id }}"
                                                                       value="{{ $equipFunctionDoc->id }}"
                                                                >
                                                            </form>
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary"
                                                                onclick="event.preventDefault(); document.getElementById('downloadEquipmentFunction_{{ $equipFunctionDoc->id }}').submit();"
                                                            >
                                                                <span class="fas fa-download"></span>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <x-deletebutton action="{{ route('equipDoku.destroy',$equipFunctionDoc->id) }}#dokumente"
                                                                            tabtarget="dokumente"
                                                                            prefix="EquipmentFunction"
                                                                            id="{{ $equipFunctionDoc->id }}"
                                                            />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <x-notifyer>{{__('Keine Dateien zum Gerät gefunden')}}!</x-notifyer>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade"
                                         id="equipDocuProduct"
                                         role="tabpanel"
                                         aria-labelledby="equipDocuProduct-tab"
                                    >
                                        @if (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->count()>0)
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}} kB</th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @foreach (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->get() as $produktDoc)
                                                    <tr>
                                                        <td>
                                                            <span class="d-md-none">{{ str_limit($produktDoc->proddoc_name,20) }}</span> <span class="d-none d-md-inline">{{ $produktDoc->proddoc_name }}</span>

                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            {{ $produktDoc->DocumentType->doctyp_label }}
                                                        </td>
                                                        <td style="text-align: right;">
                                                            {{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('downloadProduktDokuFile') }}#dokumente"
                                                                  method="get"
                                                                  id="downloadProdDoku_{{ $produktDoc->id }}"
                                                            >
                                                                @csrf
                                                                <input type="hidden"
                                                                       name="id"
                                                                       id="download_produktdoc_id_{{ $produktDoc->id }}"
                                                                       value="{{ $produktDoc->id }}"
                                                                >
                                                            </form>
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary"
                                                                onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();"
                                                            >
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
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="logs"
                         role="tabpanel"
                         aria-labelledby="logs-tab"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h5">{{__('Historie')}}</h3>
                                @foreach (App\EquipmentHistory::where('equipment_id',$equipment->id)->take(10)->latest()->get() as $equipmentHistorie)
                                    <dl class="row">
                                        <dt class="col-md-4 col-lg-3">{{ $equipmentHistorie->created_at->DiffForhumans() }}</dt>
                                        <dd class="col-sm-8 col-lg-9">
                                            <strong>{{ $equipmentHistorie->eqh_eintrag_kurz }}</strong><br>
                                            {{ $equipmentHistorie->eqh_eintrag_text }}
                                        </dd>
                                    </dl>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5">{{__('Logs')}}</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Zeit')}}</th>
                                        <th colspan="2"
                                            style="text-align: center;"
                                        >{{__('Soll')}}</th>
                                        <th style="text-align: right;">{{__('Ist')}}</th>
                                        <th style="text-align: center;">{{__('pass')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse (\App\ControlEventItem::with('AnforderungControlItem')->where('equipment_id',$equipment->id)->get() as $controlItem)
                                        <tr>
                                            <td>
                                                {{ $controlItem->created_at->diffForHumans() }}
                                            </td>
                                            <td style="text-align: right;">

                                                {{$controlItem->AnforderungControlItem[0]->aci_vaule_soll}}

                                            </td>
                                            <td>
                                                {{$controlItem->AnforderungControlItem[0]->aci_value_si}}
                                            </td>
                                            <td style="text-align: right; "
                                                @if ($controlItem->AnforderungControlItem[0]->aci_vaule_soll)
                                                class="{{ $controlItem->control_item_pass ? 'bg-success text-white' : 'bg-danger text-white' }}"
                                                @endif

                                            >
                                                {{ $controlItem->control_item_read }}
                                            </td>
                                            <td style="text-align: center; ">
                                                {!! $controlItem->control_item_pass ? '<span class="fas fa-check text-success"></span>' : '<span class="fas fa-times text-danger"></span>' !!}
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="events"
                         role="tabpanel"
                         aria-labelledby="events-tab"
                    >
                        @forelse (App\EquipmentEvent::where('equipment_id',$equipment->id)->withTrashed()->take(10)->latest()->get() as $equipmentEvent)
                            <dl class="row">
                                <dt class="col-sm-4">
                                    <strong>{{__('eröffnet')}}:</strong> {{ $equipmentEvent->created_at->DiffForhumans() }}
                                    <br><strong>{{__('geschlossen')}}:</strong>
                                    @if ($equipmentEvent->deleted_at)
                                        {{ $equipmentEvent->deleted_at->DiffForhumans() }}
                                    @else
                                        -
                                    @endif
                                    <br>
                                    @if ($equipmentEvent->deleted_at)
                                        <form action="{{ route('event.restore') }}"
                                              method="post"
                                        >
                                            @csrf
                                            <input type="hidden"
                                                   name="id"
                                                   id="id_equipment_event_{{ $equipmentEvent->id }}"
                                                   value="{{ $equipmentEvent->id }}"
                                            >
                                            <button class="btn btn-sm btn-outline-primary mt-2">{{__('wiederherstellen')}}</button>
                                        </form>
                                    @else
                                        <a href="{{ route('event.show',$equipmentEvent) }}"
                                           class="btn btn-sm btn-outline-primary mt-2"
                                        >{{__('öffnen')}}
                                        </a>
                                    @endif

                                </dt>
                                <dd class="col-sm-8">
                                    <span class="lead">{{ __('Meldung:') }}</span><br>
                                    {{ $equipmentEvent->equipment_event_text??__('keine Information übermittelt') }}
                                </dd>
                            </dl>
                            @if (!$loop->last)
                                <div class="dropdown-divider my-2"></div>
                            @endif

                        @empty
                            <x-notifyer>{{__('Keine Meldungen zum Gerät gefunden!')}}</x-notifyer>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/signatures.js') }}"></script>
    @error('eqdoc_label')
    <script>
        $('#modalAddEquipDoc').modal('show');
    </script>
    @enderror

    <script>

        $('#eqdoc_label').val(
            $('#document_type_id :selected').text() + ' ' + $('#Bezeichnung').val()
        );

        $('#document_type_id').change(()=>{
            $('#eqdoc_label').val(
                $('#document_type_id :selected').text() + ' ' + $('#Bezeichnung').val()
            );
        });

        $('#frmAddEquipmentInstruction').submit(function (e) {
            e.preventDefault();
            if (
                $('#equipment_instruction_instructor_profile_id :selected ').val() === '0' &&
                $('#equipment_instruction_instructor_firma_id :selected ').val() === '0'
            ) {
                $('#equipment_instruction_instructor_profile_id').addClass('is-invalid');
                $('#equipment_instruction_instructor_firma_id').addClass('is-invalid');
            } else {
                this.submit();
            }
        });

        $('.btnOpenControlEventModal').click(function () {
            const id = $(this).data('control-event-id');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{ route('getControlEventDataSheet') }}",
                data: {id},
                success: function (res) {
                    $('#controlEventModalBody').html(res.html);
                    $('#controlEventModal').modal('show');

                }
            });
        });

        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);

            // This part causes the canvas to be cleared
            trainee_pad_id.width = trainee_pad_id.offsetWidth * ratio;
            trainee_pad_id.height = trainee_pad_id.offsetHeight * ratio;
            trainee_pad_id.getContext("2d").scale(ratio, ratio);

            // This part causes the canvas to be cleared
            instructor_pad_id.width = instructor_pad_id.offsetWidth * ratio;
            instructor_pad_id.height = instructor_pad_id.offsetHeight * ratio;
            instructor_pad_id.getContext("2d").scale(ratio, ratio);

            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            signaturePadTrainee.clear();
            signaturePadInstructor.clear();
        }

        let trainee_pad_id = document.getElementById('signatureField_equipment_instruction_trainee_signature'),
            signaturePadTrainee = new SignaturePad(trainee_pad_id, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)',
                onEnd: function () {
                    $('#equipment_instruction_trainee_signature').val(this.toDataURL());
                }
            }),
            instructor_pad_id = document.getElementById('signatureField_equipment_instruction_instructor_signature'),
            signaturePadInstructor = new SignaturePad(instructor_pad_id, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)',
                onEnd: function () {
                    $('#equipment_instruction_instructor_signature').val(this.toDataURL());
                }
            })
        ;

        $('#addInstructedUser').on('shown.bs.modal', function () {
            resizeCanvas();
        });

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;


        $('.btnClearCanvas').click(function () {
            ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.clear() : signaturePadInstructor.clear();
        });
        $('.btnSignZuruck').click(function () {
            let data = ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.toData() : signaturePadInstructor.toData();
            if (data) {
                data.pop(); // remove the last dot or line\n'+
                ($(this).data('targetpad') === 'trainee') ? signaturePadTrainee.fromData(data) : signaturePadInstructor.fromData(data);
            }
        });
    </script>
@endsection
