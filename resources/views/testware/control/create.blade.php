@extends('layout.layout-admin')

@section('mainSection')
    {{ ( ! $is_external) ?  __('Interne Prüfung erfassen'):__('Externe Prüfung erfassen') }}
@endsection

@section('pagetitle')
    {{ ( ! $is_external) ?  __('Interne Prüfung erfassen') :__('Externe Prüfung erfassen')}} &triangleright; testWare
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal fade "
         tabindex="-1"
         role="dialog"
         aria-labelledby="signaturModalLabel"
         aria-hidden="true"
         id="signatureModal"
    >
        <div class="modal-dialog modal-xl"
             role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="signaturModalLabel"
                    >{{__('Unterschrift')}}
                        <span id="sigHead"></span>
                    </h5>
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
                           name="signatureType"
                           id="signatureType"
                    >
                    <div class="wrapper">
                        <canvas id="signatureField"
                                class="signature-pad"
                        ></canvas>

                    </div>
                    <label for="signaturName"
                           class="sr-only"
                    >{{__('Name des Unterschreibenden')}}</label>
                    <input type="text"
                           name="signaturName"
                           id="signaturName"
                           placeholder="{{__('Name des Unterschreibenden')}}"
                           class="form-control"
                    >
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-warning btn-sm"
                            id="btnClearCanvas"
                    >{{__('Neu')}}</button>
                    <button type="button"
                            class="btn btn-outline-primary btn-sm"
                            id="btnSignZuruck"
                    >{{__('Zurück')}}</button>
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            id="btnStoreSignature"
                    >{{__('speichern')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id="noticeOfFailedItems"
         tabindex="-1"
         aria-labelledby="noticeOfFailedItemsLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content border-warning">
                <div class="modal-header list-group-item-warning">
                    <h5 class="modal-title"
                        id="noticeOfFailedItemsLabel"
                    >{{ __('Achtung')}}!</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">{!! __('Es ist mindestens ein Prüfschritt mit <strong class="text-danger">nicht bestanden</strong> markiert!') !!}</p>
                    <p>{{ __('Bitte kontrollieren und wiederholen Sie gegebenenfalls den jeweils beanstandeten Prüfschritt.')}}</p>
                    <p>{!! ('Sie können diese Prüfung als <strong>bestanden</strong> abschließen, wenn die Leitung die Entscheidung entsprechend begründet und die Prüfung entsprechend signiert.') !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-warning"
                            data-dismiss="modal"
                    >{{ __('Hinweis schließen') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <form action="{{ route('control.store') }}"
          method="post"
          id="frmAddControlEvent"
          enctype="multipart/form-data"
    >
        <div class="container">
            <div class="row mb-4 d-none d-md-block">
                <div class="col">
                    <h1 class="h3">{{ ( ! $is_external) ? __('Interne Prüfung erfassen'): __('Externe Prüfung
                    erfassen')  }}</h1>


                </div>
            </div>
            <nav>
                <div class="nav nav-tabs"
                     id="nav-tab"
                     role="tablist"
                >
                    <a class="nav-link active"
                       id="controlHead-tab"
                       data-toggle="tab"
                       href="#controlHead"
                       role="tab"
                       aria-controls="controlHead"
                       aria-selected="true"
                    >{{__('Kopfdaten')}}</a>
                    @if (! $is_external)
                        @if($control_equipment_required)
                            <a class="nav-link"
                               id="controlEquipment-tab"
                               data-toggle="tab"
                               href="#controlEquipment"
                               role="tab"
                               aria-controls="controlEquipment"
                               aria-selected="false"
                            >{{ __('Prüfmittel') }}</a>
                        @endif
                        <a class="nav-link "
                           id="controlSteps-tab"
                           data-toggle="tab"
                           href="#controlSteps"
                           role="tab"
                           aria-controls="controlSteps"
                           aria-selected="false"
                        >{{ __('Prüfschritte') }}</a>
                    @endif
                    <a class="nav-link"
                       id="controlDone-tab"
                       data-toggle="tab"
                       href="#controlDone"
                       role="tab"
                       aria-controls="controlDone"
                       aria-selected="false"
                    >{{ __('Abschluss') }}</a>
                </div>
            </nav>
            <div class="tab-content pt-3"
                 id="nav-tabContent"
            >
                @csrf
                <div class="tab-pane fade show active"
                     id="controlHead"
                     role="tabpanel"
                     aria-labelledby="controlHead-tab"
                >
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-10">

                                    <x-selectfield id="user_id"
                                                   label="{{ __('Prüfer')  }}"
                                    >

                                        @foreach($qualified_user_list as $qualified_user)
                                            <option value="{{ $qualified_user['id'] }}">
                                                {{ $qualified_user['name'] }}
                                            </option>

                                        @endforeach
                                    </x-selectfield>

                                    <input type="hidden"
                                           name="equipment_id"
                                           id="equipment_id"
                                           value="{{ $test->equipment_id }}"
                                    >
                                    <input type="hidden"
                                           name="control_equipment_id"
                                           id="control_equipment_id"
                                           value="{{ $test->id }}"
                                    >
                                </div>
                                <div class="col-md-2">
                                    <x-datepicker id="control_event_date"
                                                  label="{{__('Datum der Prüfung')}}"
                                                  value="{{ date('Y-m-d') }}"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <h2 class="h5">{{__('Prüfling')}} </h2>
                            <x-staticfield label="{{ __('Name') }}"
                                           id="eq_name"
                                           value="{{ $equipment->eq_name }}"
                            />
                            <div class="row">
                                <div class="col-md-6">
                                    <x-staticfield label="{{ __('Seriennummer') }}"
                                                   id="eq_serien_nr"
                                                   value="{{ $equipment->eq_serien_nr }}"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <x-staticfield label="{{ __('Inventarnummer') }}"
                                                   id="eq_inventar_nr"
                                                   value="{{ $equipment->eq_inventar_nr }}"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <h2 class="h5">{{ __('Anforderung') }} / {{__('Prüfaufgabe')}} </h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3 flex justify-content-between">
                            <p class="lead p-3 border d-flex justify-content-between align-items-center">
                                <span>{{ $test->Anforderung->an_name }}</span>
                                <a href="{{ route('anforderung.show',$test->Anforderung) }}"
                                   class="btn btn-sm"
                                   target="_blank"
                                >{{__('Öffnen')}} <i class="fa fa-external-link-square-alt"></i></a>
                            </p>

                        </div>
                    </div>
                    <div class="mt-5 border-top pt-2">
                        <a href="{{ route('equipment.show',$equipment) }}"
                           class="btn btn-sm btn-outline-secondary"
                        >{{ __('Abbruch') }}</a>
                        @if (! $is_external)
                            @if($control_equipment_required)
                                <button type="button"
                                        class="btn btn-sm btn-primary bentNextTab"
                                        data-showtab="#controlEquipment-tab"
                                >{{__('weiter')}}</button>
                            @else
                                <button type="button"
                                        class="btn btn-sm btn-primary bentNextTab"
                                        data-showtab="#controlSteps-tab"
                                >{{__('weiter')}}</button>
                            @endif
                        @else
                            <button type="button"
                                    class="btn btn-sm btn-primary bentNextTab"
                                    data-showtab="#controlDone-tab"
                            >{{__('weiter')}}</button>

                        @endif


                    </div>

                </div>

                @if($control_equipment_required && ! $is_external)
                    <div class="tab-pane fade"
                         id="controlEquipment"
                         role="tabpanel"
                         aria-labelledby="controlEquipment-tab"
                    >
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h2 class="h5">{{__('Verwendete Prüfmittel')}}</h2>

                                <x-selectgroup id="set_control_equipment"
                                               label="{{__('Prüfmittel wählen')}}"
                                               btnL="{{__('hinzufügen')}}"
                                               class="btnAddControlEquipmentToList"
                                >

                                    @forelse ($equipmentControlList as $controlEquipment)
                                        @if( \App\Http\Services\Equipment\EquipmentEventService::checkControlDueDateIsExpired($controlEquipment))
                                            <option value="{{ $controlEquipment->id }}"
                                                    @if($controlEquipmentAvaliable)
                                                        class="disabled"
                                                    disabled
                                                    @endif
                                            >{{ $controlEquipment->eq_name }} => {{__('Prüfung überfällig!')}}
                                            </option>

                                        @else
                                            <option value="{{ $controlEquipment->id }}">
                                                {{ $controlEquipment->eq_name  }}
                                            </option>
                                        @endif
                                    @empty
                                        <option value="void"
                                                selected
                                                disabled
                                        >{{__('Keine Prüfmittel gefunden')}}
                                        </option>
                                    @endforelse

                                </x-selectgroup>
                                <span class="text-danger small hidden"
                                      id="notice_expired_item"
                                >{{ __('Das Geräte ist hat keine, oder keine gültige Prüfungen absolviert und kann nicht ausgewählt werden.') }}</span>

                                @if(!$controlEquipmentAvaliable)
                                    <div class="alert alert-danger mt-5"
                                         role="alert"
                                    >
                                        <h4 class="alert-heading">Achtung!</h4>
                                        <p>Es sind keine Prüfgeräte verfügbar, welche einen gültigen Prüfstatus
                                            besitzen. Sollte die Prüfung trotzdem durchgeführt werden, ist die
                                            Zustimmung der Leitung mit entsprechender Begründung benötigt.</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group"
                                    id="ControlEquipmentToList"
                                >
                                    <li class="controlEquipmentListInitialItem list-group-item list-group-item-warning d-flex justify-content-between align-items-center"
                                        id="control_equipment_item_${equip_id}"
                                    >
                                        <span>{{__('Keine Prüfmittel ausgewählt')}}</span>
                                        <span class="fas fa-exclamation ml-2"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-5 border-top pt-2">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary bentBackTab"
                                    data-showtab="#controlHead-tab"
                            >{{__('zurück')}}</button>
                            <button type="button"
                                    class="btn btn-sm btn-primary bentNextTab btnCheckPMListMal was ganz anderes: "
                                    data-showtab="#controlSteps-tab"
                                    id="btn-controlSteps-tab"
                            >{{__('weiter')}}</button>
                        </div>
                    </div>
                @endif
                @if (!$is_external)
                    <div class="tab-pane fade"
                         id="controlSteps"
                         role="tabpanel"
                         aria-labelledby="controlSteps-tab"
                    >
                        <x-controlStepList :requirement="$test->Anforderung"/>
                        <div class="mt-5 border-top pt-2">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary bentBackTab"
                                    data-showtab="#controlEquipment-tab"
                            >{{__('zurück')}}</button>
                            <button type="button"
                                    class="btn btn-sm btn-primary bentNextTab"
                                    data-showtab="#controlDone-tab"
                            >{{__('weiter')}}</button>
                        </div>
                    </div>
                @endif
                <div class="tab-pane fade"
                     id="controlDone"
                     role="tabpanel"
                     aria-labelledby="controlDone-tab"
                >
                    <div class="row">
                        <div class="col">
                            <h2 class="h4">{{__('Dateien')}}</h2>
                            <p>{{__('Fügen Sie eine Datei zur Prüfung an.')}}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-textfield id="eqdoc_label"
                                                 label="{{__('Kürzel')}}"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <x-selectfield id="document_type_id"
                                                   label="{{__('Dokument Typ')}}"
                                    >
                                        @foreach (App\DocumentType::all() as $ad)
                                            <option value="{{ $ad->id }}">{{ $ad->doctyp_label }}</option>
                                        @endforeach
                                    </x-selectfield>
                                </div>
                            </div>

                            <div class="custom-file mb-2">
                                <input type="file"
                                       id="controlDokumentFile"
                                       name="controlDokumentFile"
                                       data-browse="{{__('Datei')}}"
                                       class="custom-file-input"
                                       accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                                       @if (! $is_external)
                                           required
                                        @endif
                                >
                                <label class="custom-file-label"
                                       for="prodDokumentFile"
                                >{{__('Datei wählen')}}</label>
                            </div>


                            @if (! $is_external)

                                <h2 class="h4">{{__('Unterschriften')}}</h2>
                                <p>{!! __('Signieren Sie die erfolgte Prüfung. Sollte eine Signierung einer Führungskraft erforderlich sein, kann diese im Feld <code>Unterschrift Leitung</code> erfolgen.') !!}</p>
                                <div class="card-group">
                                    <div class="card">
                                        <div class="card-header">
                                            <button type="button"
                                                    class="btn btn-outline-primary btnAddSiganture"
                                                    data-toggle="modal"
                                                    data-target="#signatureModal"
                                                    data-sig="pruef"
                                            ><i class="fas fa-signature"></i> {{__('Unterschrift Prüfer')}}</button>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ $current_user->signature??'' }}"
                                                 class="{{ $current_user->signature ? '':'d-none' }} img-fluid"
                                                 alt="Unterschriftbild Prüfer"
                                                 id="imgSignaturePruefer"
                                                 style="height:200px"
                                            >
                                            <input type="hidden"
                                                   name="control_event_controller_signature"
                                                   id="control_event_controller_signature"
                                                   value="{{ $current_user->signature??'' }}"
                                            >
                                            <label for="control_event_controller_name"
                                                   class="sr-only"
                                            >{{__('Name Prüfer')}}</label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="control_event_controller_name"
                                                   id="control_event_controller_name"
                                                   required
                                                   placeholder="{{__('Name Prüfer')}}"
                                                   value="{{ $current_user->fullname()  }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <button type="button"
                                                    class="btn btn-outline-primary btnAddSiganture"
                                                    data-toggle="modal"
                                                    data-target="#signatureModal"
                                                    data-sig="leit"
                                            ><i class="fas fa-signature"></i> {{__('Unterschrift Leitung')}}</button>
                                            @if(!$controlEquipmentAvaliable)
                                                <span class="text-danger lead ml-3">{{ __('erforderlich') }}</span>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <img src=""
                                                 class="d-none img-fluid"
                                                 alt="Unterschriftbild Prüfer"
                                                 id="imgSignatureLeitung"
                                                 style="height:200px"
                                            >
                                            <input type="hidden"
                                                   name="control_event_supervisor_signature"
                                                   id="control_event_supervisor_signature"
                                                   @if(!$controlEquipmentAvaliable)
                                                       required
                                                    @endif
                                            >
                                            <label for="control_event_supervisor_name"
                                                   class="sr-only"
                                            >{{__('Name Leitung')}}</label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="control_event_supervisor_name"
                                                   id="control_event_supervisor_name"
                                                   placeholder="{{__('Name Leitung')}}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-textfield id="control_event_controller_name"
                                                     required
                                                     label="{{ __('Prüfer Name') }}"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <x-textfield id="control_event_supervisor_name"
                                                     label="{{ __('Leitung Name') }}"
                                        />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col">
                            <h2 class="h4">{{__('Abschluss')}}</h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="lead">{{__('Basieren auf den Ergebnissen hat das Gerät die Prüfung')}}
                                        : </p>
                                    <div class="btn-group btn-group-toggle mt-md-4"
                                         data-toggle="buttons"
                                    >
                                        <label class="btn btn-lg btn-outline-success active">
                                            <input type="radio"
                                                   id="controlEquipmentPassed"
                                                   name="control_event_pass"
                                                   value="1"
                                            > {{__('Bestanden')}}
                                        </label>
                                        <label class="btn btn-lg btn-outline-danger">
                                            <input type="radio"
                                                   id="controlEquipmentNotPassed"
                                                   name="control_event_pass"
                                                   value="0"
                                            > {{__('Nicht bestanden')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="lead">{{__('Nächste Prüfung des Gerätes')}}</p>
                                    <x-datepicker id="control_event_next_due_date"
                                                  label="{{__('Fällig bis')}}"
                                                  value="{{
                                now()->
                                add(
                                    $test->Anforderung->an_control_interval,
                                    mb_strtolower($test->Anforderung->ControlInterval->ci_delta)
                                    )
                                ->toDateString()
                                }}"
                                    />
                                    <p class="lead">{{__('Erinnerung setzen')}}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-rnumberfield id="qe_control_date_warn"
                                                         label="{{ __('Anzahl') }}"
                                                         value="{{ $test->Anforderung->an_date_warn }}"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <x-selectfield id="control_interval_id"
                                                           label="{{ __('Zeit') }}"
                                            >
                                                @foreach(\App\ControlInterval::all() as $CIitem)
                                                    <option
                                                            value="{{ $CIitem->id }}" {{ $test->Anforderung->warn_interval_id === $CIitem->id ? ' selected ' : '' }}>{{ $CIitem->ci_name }}</option>
                                                @endforeach
                                            </x-selectfield>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!$controlEquipmentAvaliable)
                                <x-textarea id="control_event_text"
                                            label="{{__('Bemerkungen zur Prüfung')}}"
                                            required
                                />

                            @else
                                <x-textarea id="control_event_text"
                                            label="{{__('Bemerkungen zur Prüfung')}}"
                                />

                            @endif


                        </div>
                    </div>
                    <button id="btnSubmitControlEvent"
                            type="button"
                            class="btn btn-lg btn-primary"
                    >
                        {{__('Prüfung erfassen')}} <i class="fas fa-download ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/signatures.js') }}"></script>
    <script>
        function setcontrolEquipmentPassButton() {
            if (checkControlItemsPassed()) {
                $('#controlEquipmentNotPassed').prop('checked', false).parent('label').removeClass('active');
                $('#controlEquipmentPassed').prop('checked', true).parent('label').addClass('active');
                return true;
            } else {
                $('#controlEquipmentNotPassed').prop('checked', true).parent('label').addClass('active');
                $('#controlEquipmentPassed').prop('checked', false).parent('label').removeClass('active');
                return false;
            }
        }

        function checkControlItemsPassed() {
            var failedItems = 0;

            $.each($('.itemFailed'), function () {
                if ($(this).prop('checked')) failedItems++
            })

            return (failedItems <= 0);
        }

        $('#btnSubmitControlEvent').click(function () {
            if (!checkControlItemsPassed() && !$('#control_event_supervisor_signature').val()) {
                $('#noticeOfFailedItems').modal('show');
            } else {
                $('#frmAddControlEvent').submit();
            }
        });

        $('.checkControlItem').click(function () {
            setcontrolEquipmentPassButton();
        });

        $('.checkSollValue').change(function () {
            const val = parseFloat($(this).val());
            const aci_id = $(this).data('aci_id');
            const aci_vaule_soll = parseFloat($(this).data('aci_vaule_soll'));
            const aci_value_target_mode = $(this).data('aci_value_target_mode');
            const aci_value_tol = parseFloat($(this).data('aci_value_tol'));
            const aci_value_tol_mod = $(this).data('aci_value_tol_mod');
            const tol = (aci_value_tol_mod === 'abs') ? aci_value_tol : aci_vaule_soll * aci_value_tol / 100;

            if (aci_value_target_mode === 'gt') {
                if (aci_vaule_soll <= val) {
                    $('#aci_Passed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_notPassed_' + aci_id).parent('label').removeClass('active');
                } else {
                    $('#aci_notPassed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_Passed_' + aci_id).parent('label').removeClass('active');
                }
            }

            if (aci_value_target_mode === 'lt') {
                if (aci_vaule_soll >= val) {
                    $('#aci_Passed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_notPassed_' + aci_id).parent('label').removeClass('active');
                } else {
                    $('#aci_notPassed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_Passed_' + aci_id).parent('label').removeClass('active');
                }
            }

            if (aci_value_target_mode === 'eq') {

                if ((aci_vaule_soll - tol) <= val && (aci_vaule_soll + tol) >= val) {
                    $('#aci_Passed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_notPassed_' + aci_id).parent('label').removeClass('active');
                } else {
                    $('#aci_notPassed_' + aci_id).prop('checked', true).parent('label').addClass('active');
                    $('#aci_Passed_' + aci_id).parent('label').removeClass('active');
                }
            }
            checkControlItemsPassed();
        });

        $('#controlEquipmentPassed').click(function () {
            if (!checkControlItemsPassed()) {
                $('#noticeOfFailedItems').modal('show');
            }
        });


        /**
         *   Handle control equipments
         */
        let noteNode = $('#notice_expired_item');
        let ControlEquipmentToListContent = '';
        noteNode.hide();
        const ControlEquipmentToList = $('#ControlEquipmentToList');

        /**
         *  Check local storage, if it has content to be displayed
         */

        if(sessionStorage.getItem('ControlEquipmentToListContent')){
            ControlEquipmentToList.html(sessionStorage.getItem('ControlEquipmentToListContent'));
        }


        $(document).on('click', '.btnAddControlEquipmentToList', function () {
            const nd = $('#set_control_equipment :selected');
            const controlEquipmentListItem = $('.controlEquipmentListItem');
            if (nd.prop('disabled')) {
                noteNode.show();
                return;
            }
            const btnControlSteps = $('#btn-controlSteps-tab');
            const equip_id = nd.val();
            const text = nd.text();
            const html = `
    <li class="controlEquipmentListItem list-group-item d-flex justify-content-between align-items-center" id="control_equipment_item_${equip_id}">
        <span>${text}</span>
        <input type="hidden"
               name="control_event_equipment[]"
               id="control_event_equipment_${equip_id}"
               value="${equip_id}"
        >
        <button type="button"
                class="btn btn-sm m-0 btnDeleteControlEquipItem"
                data-targetid="#control_equipment_item_${equip_id}"
        >
            <i class="fas fa-times"></i>
        </button>
    </li>
`;
            $('.controlEquipmentListInitialItem').remove();
            $('#set_control_equipment').removeClass('is-invalid');
            $('#ControlEquipmentToList').append(html);


            btnControlSteps.prop('disabled', false);
            if (btnControlSteps.hasClass('disabled'))
                btnControlSteps.removeClass('disabeld');

            sessionStorage.setItem('ControlEquipmentToListContent',ControlEquipmentToList.html());

        });

        $(document).on('click', '.btnDeleteControlEquipItem', function () {
            $($(this).data('targetid')).remove();
            if ($('.controlEquipmentListItem').length === 0) {
                $('#ControlEquipmentToList').append(`
<li class="controlEquipmentListInitialItem list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
    <span>{{__('Keine Prüfmittel ausgewählt')}}</span>
    <span class="fas fa-exclamation"></span>
</li>
`);
                $('#btn-controlSteps-tab').prop('disabled', true).addClass('disabeld');
            }
            sessionStorage.setItem('ControlEquipmentToListContent',ControlEquipmentToList.html());
        });


        /**
         *   Signatures
         */
        $('.btnAddSiganture').click(function () {
            const typ = $(this).data('sig');
            signaturePad.clear();
            $('#signatureType').val(typ);
            let sigHead = (typ === 'leit') ? '{{__('Leitung')}}' : '{{__('Prüfer')}}';
            $('#sigHead').text(sigHead);
        });

        $('#btnStoreSignature').click(function () {
            var data = signaturePad.toDataURL('image/png');
            const tp = $('#signatureType').val();
            if (tp === 'leit') {
                $('#control_event_supervisor_name').val($('#signaturName').val(),);
                $('#control_event_supervisor_signature').val(data);
                $('#imgSignatureLeitung').removeClass('d-none').attr('src', signaturePad.toDataURL());
            } else {
                $('#control_event_controller_name').val($('#signaturName').val(),);
                $('#control_event_controller_signature').val(data);
                $('#imgSignaturePruefer').removeClass('d-none').attr('src', signaturePad.toDataURL());
            }
            $('#signatureModal').modal('hide');

        });

        function resizeCanvas() {
// When zoomed out to less than 100%, for some very strange reason,
// some browsers report devicePixelRatio as less than 1
// and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);

// This part causes the canvas to be cleared
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

// This library does not listen for canvas changes, so after the canvas is automatically
// cleared by the browser, SignaturePad#isEmpty might still return false, even though the
// canvas looks empty, because the internal data of this library wasn't cleared. To make sure
// that the state of this library is consistent with visual state of the canvas, you
// have to clear it manually.
            signaturePad.clear();
        }

        var canvas = document.getElementById('signatureField'),
            signaturePad = new SignaturePad(canvas, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)'
            });

        $('#signatureModal').on('shown.bs.modal', function () {
            resizeCanvas();
        });

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;


        $('#btnClearCanvas').click(function () {
            signaturePad.clear();
        });
        $('#btnSignZuruck').click(function () {
            var data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line\n'+
                signaturePad.fromData(data);
            }
        });


    </script>

@endsection
