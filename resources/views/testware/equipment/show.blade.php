@extends('layout.layout-admin')

@section('mainSection', __('Gerät'))

@section('pagetitle')
    {{__('Gerät bearbeiten')}} {{ $equipment->eq_inventar_nr }} &triangleright; {{__('Geräte')}}@endsection

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
            <a class="dropdown-item"
               href="{{ route('equipment.edit',$equipment) }}"
            >
                <i class="ml-2 far fa-edit mr-2 fa-fw"></i>
                {{__('Gerät bearbeiten')}}
            </a>
            <a class="dropdown-item"
               href="#"
               data-toggle="modal"
               data-target="#modalAddEquipDoc"
            >
                <i class="ml-2 fas fa-upload mr-2 fa-fw"></i>
                {{__('Datei hinzufügen')}}
            </a>
            <a class="dropdown-item"
               href="#"
               data-toggle="modal"
               data-target="#modalStartManualControl"
            >
                <i class="ml-2 fas fa-stethoscope mr-2 fa-fw"></i>
                {{__('Prüfung manuell erfassen')}}
            </a>
            <a class="dropdown-item"
               href="#"
               data-toggle="modal"
               data-target="#modalAddEquipFuncTest"
            >
                <i class="ml-2 fas fa-stethoscope mr-2 fa-fw"></i>
                {{__('Funktionstest erfassen')}}
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item"
               href="{{ route('makePDFEquipmentDataSheet',$equipment->id) }}"
               download
            >
                <i class="ml-2 fas fa-print mr-2 fa-fw"></i>
                {{__('Datenblatt drucken')}}
            </a>
            @if(\App\EquipmentLabel::select('id')->count() >0 )
            <a class="dropdown-item"
               href="{{ route('makePDFEquipmentLabel',$equipment->id) }}"
               target="_blank"
            >
                <i class="ml-2 fas fa-qrcode mr-2 fa-fw"></i>
                {{__('QR-Code drucken')}}
            </a>
                @else
                <a class="dropdown-item disabled"
                   title="{{ __('Es sind keine Labels vorhanden.') }}"
                >
                    <i class="ml-2 fas fa-qrcode mr-2 fa-fw"></i>
                    {{__('QR-Code drucken')}}
                </a>
            @endif
            <div class="dropdown-divider"></div>
            <a class="dropdown-item"
               href="{{ route('produkt.show',['produkt'=>$equipment->produkt]) }}"
            >
                <i class="ml-2 far fa-edit mr-2 fa-fw"></i>
                {{__('Produkt bearbeiten')}}
            </a>

        </ul>
    </li>
@endsection

@section('modals')
    @if($newFileList)

        <div class="modal show"
             id="syncNewFiles"
             tabindex="-1"
             aria-labelledby="syncNewFilesLabel"
             aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="syncNewFilesLabel"
                        >{{  __(':num neue Datei(en) gefunden',['num'=>count($newFileList)]) }}</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('equipdoc.add')}}"
                          method="POST"
                    >
                        @csrf
                        <div class="modal-body">
                            <p>{{ __('In dem Verzeichnis wurden neue Dateien gefunden, welche nicht in der Datenbank erfasst wurden. Bitte aussuchen, was mit ihnen geschehen soll.') }}</p>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('Dateiname') }}</th>
                                    <th>{{ __('Aktion') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($newFileList as $key => $listItem)
                                    <tr>
                                        <td>
                                            {{ $listItem }}
                                            <input type="hidden"
                                                   name="equipment_id[]"
                                                   id="equipment_id_{{$key}}"
                                                   value="{{ $equipment->id }}"
                                            >
                                            <input type="hidden"
                                                   name="filename[]"
                                                   id="filename{{$key}}"
                                                   value="{{ $listItem }}"
                                            >
                                            <input type="hidden"
                                                   name="filepath[]"
                                                   id="filepath{{$key}}"
                                                   value="{{ \App\Http\Services\Equipment\EquipmentDocumentService::getEquipmentPathName($equipment) }}"
                                            >
                                        </td>
                                        <td>
                                            {!! (new \App\Http\Services\Equipment\EquipmentDocumentService)->makeDocumentTypeSelector($key) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                            >Abbruch
                            </button>
                            <button type="submit"
                                    class="btn btn-primary"
                            >Aufgaben durchführen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif


    <x-modal-add-note objectname="{{ $equipment->eq_inventar_nr }}"
                      uid="{{ $equipment->eq_uid }}"
    />

    <div class="modal fade"
         id="modalAddEquipDoc"
         tabindex="-1"
         aria-labelledby="modalAddEquipDocLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('equipDoku.store') }}#documents"
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

                        <x-textarea id="eqdoc_description"
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
                    <p>{{ __('Folgende Prüfungen/Wartungen sind für das Gerät vorgesehen. Bitte wählen Sie die auszuführende Prüfung aus.') }}</p>

                    <table class="table table-responsive-md">
                        <thead>
                        <tr>
                            <th>{{__('Prüfung')}}</th>
                            <th>{{__('Fällig')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($upcomingControlList as $controlItem)
                            @if(!$controlItem->is_initial_test)
                                <tr style="vertical-align: middle;">
                                    <td>{{ $controlItem->an_name ?? 'nicht definiert' }}</td>
                                    <td>{!!  $controlItem->checkDueDate($controlItem) !!} </td>
                                    <td class="">
                                        @if($controlItem->checkControlRequirementsMet()['success'])
                                            @if($loggedInUserIsQualified)
                                                <a href="{{ route('control.create', ['test_id' =>  $controlItem->id]) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                > {{__('Prüfung starten')}}
                                                </a>
                                            @else
                                                <x-notifyer>
                                                    {{ __('Sie sind für dieses Gerät noch nicht als befähigt eingetragen!') }}
                                                </x-notifyer>
                                            @endif
                                        @else
                                            {!! $controlItem->checkControlRequirementsMet()['html'] !!}
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
                ></div>
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
                <form action="{{ route('EquipmentQualifiedUser.store') }}#requirements"
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
                                        @if(! $user->isQualified($equipment->id))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
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
            <form action="{{ route('EquipmentInstruction.store') }}#requirements"
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
                                    @foreach(App\Profile::select('id','ma_name','ma_vorname')->get() as $trainee)
                                        @if(! $trainee->isInstructed($equipment->id))
                                            <option value="{{ $trainee->id }}">{{ $trainee->ma_vorname . ' '. $trainee->ma_name }}</option>
                                        @endif
                                    @endforeach
                                </x-selectfield>
                            </div>
                            <div class="col-md-6">
                                <x-selectfield id="equipment_instruction_instructor_profile_id"
                                               label="{{__('Interne Unterweisung durch')}}"
                                               required
                                >
                                    <option value="0">{{ __('bitte auswählen') }}</option>
                                    @foreach(App\EquipmentQualifiedUser::where('equipment_id',$equipment->id)->with('user')->get() as $qualifiedUser)
                                        <option value="{{ $qualifiedUser->user->id }}">{{ $qualifiedUser->user->name }}</option>
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


    <div class="modal fade"
         id="modalStartManualControl"
         tabindex="-1"
         aria-labelledby="modalStartManualControlLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <form action="{{ route('control.manual') }}"
                  method="get"
                  enctype="multipart/form-data"
                  id="frmAddManualControl"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalStartManualControlLabel"
                        >{{__('Prüfung manuell erfassen')}}</h5>
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
                               name="equipment"
                               id="AddManualControl_equipment_id"
                               value="{{ $equipment->eq_uid }}"
                        >

                        <x-selectfield id="requirement"
                                       label="{{ __('Prüfung auswählen') }}"
                        >
                            @foreach(\App\Anforderung::select('id','an_name')->get() as $requirement)
                                <option value="{{ $requirement->id }}">{{ $requirement->an_name }}</option>
                            @endforeach
                        </x-selectfield>

                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                                id="btnAddEquipmentControlTest"
                                class="btn btn-primary"
                        >{{ __('Prüfung starten') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade"
         id="modalAddEquipFuncTest"
         tabindex="-1"
         aria-labelledby="modalAddEquipFuncTestLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <form action="{{ route('addEquipmentFunctionControl') }}"
                  method="post"
                  enctype="multipart/form-data"
                  id="frmAddEquipmentFunctionTest"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modalAddEquipFuncTestLabel"
                        >{{__('Funktionsprüfung erfassen')}}</h5>
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
                               id="AddEquipFuncTest_equipment_id"
                               value="{{ $equipment->id }}"
                        >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group btn-group-toggle mb-3"
                                     data-toggle="buttons"
                                >
                                    <label class="btn btn-outline-success active">
                                        <input type="radio"
                                               id="controlEquipmentPassed"
                                               name="function_control_pass"
                                               value="1"
                                               class="function_control_pass"
                                        > {{__('Bestanden')}}
                                    </label>
                                    <label class="btn btn-outline-danger">
                                        <input type="radio"
                                               id="controlEquipmentNotPassed"
                                               name="function_control_pass"
                                               value="0"
                                               class="function_control_pass"
                                               checked
                                        > {{__('NICHT Bestanden')}}
                                    </label>
                                </div>
                                <x-datepicker id="AddEquipFuncTest_controlled_at"
                                              name="controlled_at"
                                              label="{{__('Die Prüfung erfolgte am')}}"
                                              required
                                              value="{{ date('Y-m-d') }}"
                                />
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-selectfield id="function_control_firma"
                                                       label="{{__('durch Firma')}}"
                                        >
                                            <option value="void">{{__('Bitte wählen')}}</option>
                                            @foreach(\App\Firma::all() as $firma)
                                                <option value="{{ $firma->id }}">{{ $firma->fa_name }}</option>
                                            @endforeach
                                        </x-selectfield>
                                    </div>
                                    <div class="col-md-6">
                                        <x-selectfield id="function_control_profil"
                                                       label="{{__('durch befähigte Person')}}"
                                        >
                                            <option value="void">{{__('Bitte wählen')}}</option>
                                            @foreach(\App\User::all() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-selectfield>
                                    </div>
                                </div>
                                <x-textarea id="AddEquipFuncTest_function_control_text"
                                            name="function_control_text"
                                            label="{{__('Bemerkungen zur Prüfung')}}"
                                />
                            </div>
                            <div class="col-md-6">
                                <h2 class="h5">{{__('Bericht')}}</h2>
                                <x-selectfield id="AddEquipFuncTest_document_type_id"
                                               name="document_type_id"
                                               class="document_type_id"
                                               data-target="#frmAddEquipmentFunctionTest_eqdoc_label"
                                               label="{{__('Dokument Typ')}}"
                                               required
                                >
                                    @foreach (App\DocumentType::all() as $ad)
                                        <option value="{{ $ad->id }}"
                                                @if( $ad->id===2  ?? old('document_type_id')==$ad->id)
                                                    selected
                                                @endif
                                        >{{ $ad->doctyp_label }}</option>
                                    @endforeach
                                </x-selectfield>

                                <x-textfield id="AddEquipFuncTest_eqdoc_label"
                                             name="eqdoc_label"
                                             label="{{__('Bezeichnung')}}"
                                             value="{{ __('Bericht Funktionsprüfung ').date('Y-m-d') }}"
                                />

                                <x-textarea name="eqdoc_description"
                                            id="AddEquipFuncTest_eqdoc_description"
                                            label="{{__('Datei Informationen')}}"
                                />

                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file"
                                               id="AddEquipFuncTest_equipDokumentFile"
                                               name="equipDokumentFile"
                                               data-browse="{{__('Datei')}}"
                                               class="custom-file-input"
                                               accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                        >
                                        <label class="custom-file-label"
                                               for="equipDokumentFile"
                                        >{{__('Datei wählen')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                id="^"
                                class="btn btn-primary"
                        >{{ __('Funktionsprüfung erfassen') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-modals.form_modal methode="DELETE"
                         modalRoute="{{ route('equipment.destroy',$equipment) }}"
                         modalId="modalDeleteThisEuipment"
                         modalType="danger"
                         title="{{ __('Vorsicht') }}"
                         btnSubmit="{{ __('Gerät löschen') }}"
    >
        <p class="lead">{{__('Das Löschen des Gerätes kann nicht rückgängig gemacht werden.')}}</p>
    </x-modals.form_modal>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row mb-2 d-md-flex d-none">
            <div class="col">
                <h1 class="h4">{{ __('Geräteübersicht')}}</h1>
            </div>
            <div class="col">
                <div class="text-muted small text-right">
                    {{ __('Gerät') }}-UUID:<br>{{ $equipment->eq_uid }}
                </div>
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
                           id="base_data-tab"
                           data-toggle="tab"
                           href="#base_data"
                           role="tab"
                           aria-controls="base_data"
                           aria-selected="true"
                        > {{ __('Stammdaten')}}
                        </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="requirements-tab"
                           data-toggle="tab"
                           href="#requirements"
                           role="tab"
                           aria-controls="requirements"
                           aria-selected="false"
                        > {{ __('Anforderungen')}} </a>
                    </li>
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="documents-tab"
                           data-toggle="tab"
                           href="#documents"
                           role="tab"
                           aria-controls="documents"
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
                    <li class="nav-item"
                        role="presentation"
                    >
                        <a class="nav-link"
                           id="notes-tab"
                           data-toggle="tab"
                           href="#notes"
                           role="tab"
                           aria-controls="notes"
                           aria-selected="false"
                        > {{ __('Notizen')}}
                        </a>
                    </li>
                </ul>

                <div class="tab-content"
                     id="myTabContent"
                >
                    <div class="tab-pane fade show active p-2"
                         id="base_data"
                         role="tabpanel"
                         aria-labelledby="base_data-tab"
                    >
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <h2 class="h4">{{ __('Übersicht / Stammdaten')}}</h2>
                                <x-staticfield id="Bezeichnung"
                                               label="{{__('Bezeichnung')}}:"
                                               value="{{ $equipment->eq_name ?? $equipment->produkt->prod_name }}"
                                />
                                @php
                                    if (App\Storage::find($equipment->storage_id)) {
                                        $value = App\Storage::find($equipment->storage_id)->getStoragePath();
                                    } else {
                                        $value = __('nicht zugeordnet');
                                    }
                                @endphp
                                <x-staticfield id="Storage"
                                               label="{{__('Aufstellplatz / Standort')}}:"
                                               value="{{ $value }}"
                                />
                                <x-staticfield id="eq_inventar_nr"
                                               label="{{__('Inventarnummer')}}:"
                                               value="{!!  $equipment->eq_inventar_nr !!}"
                                />
                                <x-staticfield id="installed_at"
                                               label="{{__('Inbetriebnahme am')}}:"
                                               value="{!!  $equipment->installed_at !!}"
                                />
                                <x-staticfield id="eq_serien_nr"
                                               label="{{__('Seriennummer')}}:"
                                               value="{!!  $equipment->eq_serien_nr ?? '-' !!}"
                                />
                                <x-staticfield id="firma"
                                               label="{{__('Hersteller')}}:"
                                               value="{{ $companyString??'' }}"
                                />
                            </div>
                            <div class="col-md-5 pl-3 mb-3">
                                @if ($equipment->produkt->ControlProdukt)
                                    <h2 class="h4 mb-2">{{__('Prüfmittel - Gerätestatus')}}</h2>
                                @else
                                    <h2 class="h4 mb-2">{{__('Gerätestatus')}}</h2>
                                @endif
                                <div class="align-items-center justify-content-between mb-3 d-none d-md-flex">
                                    <span class=" fas fa-4x fa-border {{ $equipment->EquipmentState->estat_icon }} text-{{ $equipment->EquipmentState->estat_color }}"></span>
                                    <span class="lead mx-3">{{ $equipment->EquipmentState->estat_name }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3 d-md-none">
                                    <span class=" fas fa-2x fa-border {{ $equipment->EquipmentState->estat_icon }} text-{{ $equipment->EquipmentState->estat_color }}"></span>
                                    <span class="lead mx-3">{{ $equipment->EquipmentState->estat_name }}</span>
                                </div>

                                <h2 class="h4 mt-5">@if (App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->count() >1 )
                                        {{__('Anleitungen')}}
                                    @else
                                        {{__('Anleitung')}}
                                    @endif </h2>
                                @forelse(App\ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->get() as $bda)
                                    @if(Storage::disk('local')->exists($bda->proddoc_name_pfad))
                                        <x-filecard downloadroute="{{ route('downloadProduktDokuFile') }}"
                                                    name="{{ $bda->proddoc_name }}"
                                                    label="{{ $bda->proddoc_label }}"
                                                    path="{{ $bda->proddoc_name_pfad }}"
                                                    id="{{ $bda->id }}"
                                        />
                                    @endif
                                @empty
                                    <span class="text-muted text-center small">{{__('keine Anleitungen hinterlegt')}}</span>
                                @endforelse
                                {{--     <h2 class="h4 mt-5">{{__('Funktionstest')}}</h2>
                                     @forelse(App\EquipmentDoc::where('equipment_id',$equipment->id)->where('document_type_id',2)->get() as $bda)
                                         @if(Storage::disk('local')->exists($bda->eqdoc_name_pfad))
                                             <x-filecard downloadroute="{{ route('downloadEquipmentDokuFile') }}"
                                                         name="{{ $bda->eqdoc_name }}"
                                                         label="{{ $bda->eqdoc_label }}"
                                                         path="{{ $bda->eqdoc_name_pfad }}"
                                                         id="{{ $bda->id }}"
                                             />
                                         @endif
                                     @empty
                                         <p class="text-muted text-center small">{{__('keine Dokumente zur Funtionsprüfung gefunden!')}}</p>
                                         <button class="btn btn-lg btn-warning btn-block"
                                                 data-toggle="modal"
                                                 data-target="#modalAddEquipFuncTest"
                                         >
                                             <i class="ml-2 fas fa-stethoscope mr-2 fa-fw"></i>
                                             {{__('Funktionstest erfassen')}}
                                         </button>

                                     @endforelse--}}
                                <h2 class="h4 mt-5">{{__('Prüfungen')}} </h2>
                                @if($loggedInUserIsQualified && $upcomingControlList->count()>0)
                                    <button class="btn btn-primary btn-lg btn-block mb-3"
                                            data-toggle="modal"
                                            data-target="#modalStartControl"
                                    >{{__('Prüfung erfassen')}}
                                    </button>
                                @endif

                                @if($upcomingControlList->count()>0 && ! $loggedInUserIsQualified)
                                    <h3 class="h6">{{ __('Anstehende Prüfungen') }}</h3>
                                    <div class="alert alert-info small alert-dismissible fade show"
                                         role="alert"
                                    >
                                        {{ __('Sie sind nicht als befähigte Person für dieses Gerät eingetragen und dürfen daher keine Prüfung ausführen.') }}
                                        <button type="button"
                                                class="close"
                                                data-dismiss="alert"
                                                aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <table class="table table-sm small">
                                        <thead>
                                        <tr class="thead-light">
                                            <th>{{ __('Prüfung') }}</th>
                                            <th>{{ __('Fällig bis') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($upcomingControlList as $item)
                                            <tr>
                                                <td>{{ $item->an_name }}</td>
                                                <td>{{ $item->qe_control_date_due }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif

                                @if($upcomingControlList->count() === 0)
                                    <div class="alert alert-info alert-dismissible fade show"
                                         role="alert"
                                    >
                                        <p class="lead">{{ __('Keine anstehende Prüfung gefunden.') }}</p>
                                        <p>{!! __('Option 1: Im hinterlegten <a href=":link" target="_blank" class="alert-link">Produkt</a> eine Anforderung anlegen. Dadurch werden entsprechende Prüftermine erstellt.', ['link'=> route('produkt.show',$equipment->produkt)]) !!}</p>
                                        <p>{!! __('Option 2: Eine <a href="#" data-toggle="modal" data-target="#modalStartManualControl" class="alert-link">manuelle Prüfung</a> starten') !!}</p>

                                        <button type="button"
                                                class="close"
                                                data-dismiss="alert"
                                                aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                    @if($onetimeControlList->count()>0)
                                        <h3 class="h6">{{ __('Einmalige Prüfungen') }}</h3>
                                        @foreach($onetimeControlList as $control_equipment_item)
                                            <a href="{{ route('control.manual',['equipment'=> $equipment->eq_uid,'requirement'=>$control_equipment_item->anforderungs_id ]) }}" class="btn btn-outline-primary btn-block" >
                                                {{$control_equipment_item->an_name}}
                                            </a>
                                        @endforeach
                                    @endif

                                @if($recentControlList->count()>0)
                                    <h3 class="h6 mt-3">{{ __('Durchgeführte Prüfungen') }}</h3>
                                    @forelse($recentControlList as $control_equipment_item)
                                        @if (\App\ControlEvent::where('control_equipment_id',$control_equipment_item->id)->count()>0)
                                            <x-equipment_control_card :cei="$control_equipment_item"
                                                                      :is-sys-admin="Auth::user()->isSysAdmin()"
                                            />
                                        @endif
                                    @empty
                                        <x-notifyer>{{__('keine Prüfberichte hinterlegt')}}</x-notifyer>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="requirements"
                         role="tabpanel"
                         aria-labelledby="requirements-tab"
                    >
                        <div class="row">
                            <div class="col-md-7">
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
                                <table class="table table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Qualifiziert am') }}</th>
                                        <th>{{ __('durch') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach (\App\EquipmentQualifiedUser::where('equipment_id',$equipment->id)->get() as $equipmentUser)
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
                                                        <span class="d-none d-lg-inline mr-2">{{ __('Löschen') }}</span>
                                                        <span class="far fa-trash-alt"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                <table class="table table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Unterwiesen am')}}</th>
                                        <th>{{__('gez.')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($instructedPersonList as $instructedUser)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $instructedUser->profile->ma_name }}</td>
                                            <td style="vertical-align: middle;">{{ $instructedUser->equipment_instruction_date }}</td>
                                            <td>
                                                <img src="{{ $instructedUser->equipment_instruction_trainee_signature }}"
                                                     class="img-fluid"
                                                     style="max-height: 40px"
                                                     alt="unterschrift"
                                                >
                                            </td>
                                            <td style="vertical-align: middle; text-align:right; padding:0">
                                                <form action="{{ route('EquipmentInstruction.destroy',$instructedUser) }}#requirements"
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
                                                        <span class="d-none d-lg-inline">{{__('Löschen')}}</span>
                                                        <span class="far fa-trash-alt ml-2"
                                                        ></span>
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
                            <div class="col-md-5">
                                <h3 class="h5">{{__('Anforderungen')}}</h3>


                                @forelse ($requirementList as $produktAnforderung)

                                    <x-requirement_box :requirement="$produktAnforderung->Anforderung"
                                                       isProduct="false"
                                                       :produktAnforderungId="$produktAnforderung->id"

                                    />

                                @empty
                                    <p class="text-muted small">{{ __('Bislang sind keine Anforderungen verknüpft')}}
                                        !</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-2"
                         id="documents"
                         role="tabpanel"
                         aria-labelledby="documents-tab"
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
                                        @if (count($euqipmentDocumentList)>0)
                                            <table class="table table-responsive-md table-striped">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}}</th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @foreach ($euqipmentDocumentList as $equipDoc)
                                                    @if(Storage::disk('local')->exists($equipDoc->eqdoc_name_pfad))
                                                        <tr>
                                                            <td>
                                                                <form action="{{ route('downloadEquipmentDokuFile') }}#documents"
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
                                                                <a href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('downloadEquipmentDoku_{{ $equipDoc->id }}').submit();"
                                                                >
                                                                    <span class="d-md-none">{{ str_limit($equipDoc->eqdoc_label,20) }}</span>
                                                                    <span class="d-none d-md-inline">{{ $equipDoc->eqdoc_label }}</span>
                                                                </a>
                                                            </td>
                                                            <td class="d-none d-md-table-cell">{{ $equipDoc->DocumentType->doctyp_label }}</td>
                                                            <td style="text-align: right;">
                                                                {{ $equipDoc->getSize($equipDoc->eqdoc_name_pfad) }}
                                                            </td>
                                                            <td>
                                                                <x-deletebutton action="{{ route('equipDoku.destroy',$equipDoc->id) }}"
                                                                                tabtarget="documents"
                                                                                prefix="EquipmentDoku"
                                                                                id="{{ $equipDoc->id }}"
                                                                />
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                        @if (count($functionDocumentList)>0)
                                            <table class="table table-responsive-md table-striped">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}}</th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @foreach ($functionDocumentList as $equipFunctionDoc)
                                                    @if(Storage::disk('local')->exists($equipFunctionDoc->eqdoc_name_pfad))
                                                        <tr>
                                                            <td>
                                                                <form action="{{ route('downloadEquipmentDokuFile') }}#documents"
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
                                                                <a href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('downloadEquipmentFunction_{{ $equipFunctionDoc->id }}').submit();"
                                                                >
                                                                    <span class="d-md-none">{{ str_limit($equipDoc->eqdoc_label,20) }}</span>
                                                                    <span class="d-none d-md-inline">{{ $equipDoc->eqdoc_label }}</span>
                                                                </a>
                                                            </td>
                                                            <td class="d-none d-md-table-cell"> {{ $equipFunctionDoc->DocumentType->doctyp_label }}</td>
                                                            <td style="text-align: right;">
                                                                {{ $equipFunctionDoc->getSize($equipFunctionDoc->eqdoc_name_pfad) }}
                                                            </td>
                                                            <td>
                                                                <x-deletebutton action="{{ route('equipDoku.destroy',$equipFunctionDoc->id) }}#documents"
                                                                                tabtarget="documents"
                                                                                prefix="EquipmentFunction"
                                                                                id="{{ $equipFunctionDoc->id }}"
                                                                />
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                            <table class="table table-responsive-md table-striped">
                                                <thead>
                                                <th>{{ __('Datei')}}</th>
                                                <th class="d-none d-md-table-cell">{{ __('Typ')}}</th>
                                                <th style="text-align: right;">{{ __('Größe')}} kB</th>

                                                </thead>
                                                <tbody>
                                                @foreach (\App\ProduktDoc::where('produkt_id',$equipment->produkt_id)->get() as $produktDoc)
                                                    @if(Storage::disk('local')->exists($produktDoc->proddoc_name_pfad))
                                                        <tr>
                                                            <td>
                                                                <form action="{{ route('downloadProduktDokuFile') }}#documents"
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
                                                                <a href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('downloadProdDoku_{{ $produktDoc->id }}').submit();"
                                                                >
                                                                    <span class="d-md-none">{{ str_limit($produktDoc->proddoc_label,20) }}</span>
                                                                    <span class="d-none d-md-inline">{{ $produktDoc->proddoc_label }}</span>
                                                                </a>
                                                            </td>
                                                            <td class="d-none d-md-table-cell">
                                                                {{ $produktDoc->DocumentType->doctyp_label }}
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ $produktDoc->getSize($produktDoc->proddoc_name_pfad) }}
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                    <x-equip-history-card :logEntry="$equipmentHistorie"/>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5">{{__('Logs')}}</h3>
                                <table class="table table-responsive-md">
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

                                        @if($controlItem->AnforderungControlItem)
                                            @if($controlItem->AnforderungControlItem->aci_vaule_soll)
                                                <tr>
                                                    <td>
                                                        {{ $controlItem->created_at->diffForHumans() }}
                                                    </td>
                                                    <td style="text-align: right;">

                                                        {{$controlItem->AnforderungControlItem->aci_vaule_soll}}

                                                    </td>
                                                    <td>
                                                        {{$controlItem->AnforderungControlItem->aci_value_si}}
                                                    </td>
                                                    <td style="text-align: right; "
                                                        @if ($controlItem->AnforderungControlItem->aci_vaule_soll)
                                                            class="{{ $controlItem->control_item_pass ? 'bg-success text-white' : 'bg-danger text-white' }}"
                                                            @endif

                                                    >
                                                        {{ $controlItem->control_item_read }}
                                                    </td>
                                                    <td style="text-align: center; ">
                                                        {!! $controlItem->control_item_pass ? '<span class="fas fa-check text-success"></span>' : '<span class="fas fa-times text-danger"></span>' !!}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
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
                            <x-equip_event_card :equipmentEvent="$equipmentEvent"
                                                :loop="$loop"
                            />
                        @empty
                            <x-notifyer>{{__('Keine Meldungen zum Gerät gefunden!')}}</x-notifyer>
                        @endforelse
                    </div>
                    <x-tab-note uid="{{ $equipment->eq_uid }}"/>
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

    @if($newFileList)
        <script>
            $('#syncNewFiles').modal('show');
        </script>
    @endif

    <script>

        function checkFunctionControl() {
            const function_control_profil = $('#function_control_profil');
            const function_control_firma = $('#function_control_firma');
            const function_control_file = $('#AddEquipFuncTest_equipDokumentFile');

            let chekResult = false;

            if (function_control_firma.val() === 'void' && function_control_profil.val() === 'void') {
                function_control_profil.addClass('is-invalid');
                function_control_firma.addClass('is-invalid');
            }

            if (function_control_firma.val() !== 'void' || function_control_profil.val() !== 'void') {
                function_control_profil.removeClass('is-invalid');
                function_control_firma.removeClass('is-invalid');
                chekResult = true;
            }

            if (function_control_file.val() === '') {
                function_control_file.addClass('is-invalid');
                chekResult = false;
            }

            return chekResult;

        }

        $("function_control_profil").change(function () {
            checkFunctionControl();
            $('#function_control_firma').val('void');
        });

        $("function_control_firma").change(function () {
            checkFunctionControl();
            $('#function_control_profil').val('void');
        });

        $('.function_control_pass').click(function () {
            const nd = $('#equipment_state_id');
            const eqdoc_label = $('#eqdoc_label');
            const equipDokumentFile = $('#AddEquipFuncTest_equipDokumentFile');

            if ($('#controlEquipmentNotPassed').prop('checked')) {
                nd.val(4);
                $('#equipment_state_id > option').eq(0).attr('disabled', 'disabled');
            } else {
                $('#equipment_state_id > option').eq(0).attr('disabled', false);
                nd.val(1)
            }

            if (eqdoc_label.val() !== '' && equipDokumentFile.val() !== '') {
                $('#btnAddEquipmentFunctionTest').attr('disabled', false);
            }

        });

        $('#btnAddEquipmentFunctionTest').click(function () {
            if (checkFunctionControl()) $('#frmAddEquipmentFunctionTest').submit();
        });

        $('#eqdoc_label').val(
            $('#document_type_id :selected').text() + ' ' + $('#Bezeichnung').val()
        );

        $('#document_type_id').change(() => {
            $($(this).data('target')).val(
                $('#document_type_id :selected').text() + ' ' + $(this).val()
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
            });

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
