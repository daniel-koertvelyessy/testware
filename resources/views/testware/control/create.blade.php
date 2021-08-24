@extends('layout.layout-admin')

@section('mainSection', 'testWare')

@section('pagetitle')
    {{__('Prüfung erfassen')}}
@endsection

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal fade "
         tabindex="-1"
         role="dialog"
         aria-labelledby="myExtraLargeModalLabel"
         aria-hidden="true"
         id="signatureModal"
    >
        <div class="modal-dialog modal-lg"
             role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="messWertDialog"
                    >{{__('Unterschrift')}} <span id="sigHead"></span></h5>
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
                    >Achtung!</h5>
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
                    <p>Bitte kontrollieren und wiederholen Sie gegebenfalls den jeweils beanstandeten Prüfschritt.</p>
                    <p>Sie können diese Prüfung als <strong>bestanden</strong> abschließen, wenn die Leitung die Entscheidung entsprechend begründet und die Prüfung entsprechend signiert.</p>
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
            <div class="row mb-4">
                <div class="col">
                    <h1 class="h3">{{ ( $aci_execution) ? __('Externe') : __('Interne') }} {{__('Prüfung erfassen')}}</h1>
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

                    @if ($aci_execution === 0)
                        @if($aci_control_equipment_required===1)
                            <a class="nav-link"
                               id="controlEquipment-tab"
                               data-toggle="tab"
                               href="#controlEquipment"
                               role="tab"
                               aria-controls="controlEquipment"
                               aria-selected="false"
                            >{{ __('Prüfmittel') }}</a>
                        @endif

                        <a class="nav-link"
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
                                    <x-staticfield id="controlUserName"
                                                   label="{{__('Prüfer')}}"
                                                   value="{{ auth()->user()->name }}"
                                    />
                                    <input type="hidden"
                                           name="user_id"
                                           id="user_id"
                                           value="{{ auth()->user()->id }}"
                                    >
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
                            @php(  $equipment = App\Equipment::find($test->equipment_id) )
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
                            <h2 class="h5">{{__('Prüfaufgabe')}} </h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <p class="lead p-3 border">{{ $test->Anforderung->an_name }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <p class="lead">{{ __('Befähigte Personen für die Prüfung') }}</p>
                            <ul class="list-unstyled">
    @php($enabledUser=[])
    @foreach(\App\ProductQualifiedUser::where('produkt_id',$test->equipment->produkt->id)->get() as $qualifiedUser)
        <li class="list-group-item d-flex align-items-center justify-content-between">
           <span>
               <span class="text-muted"><strong><abbr title="{{ __('Aus Produktdaten') }}">P</abbr></strong></span>
               {{$qualifiedUser->user->name}}
           </span>

            @if($qualifiedUser->user->id === auth()->user()->id)
                <span class="fas fa-check-circle text-success"></span>
                @php($enabledUser[] = $qualifiedUser->user->id)
            @endif
        </li>
    @endforeach
    @foreach(\App\EquipmentQualifiedUser::where('equipment_id',$test->equipment_id)->get() as $qualifiedUser)
        <li class="list-group-item d-flex align-items-center justify-content-between">
            <span>
            {{$qualifiedUser->user->name}}
            </span>
            @if($qualifiedUser->user->id === auth()->user()->id)
                <span class="fas fa-check-circle text-success"></span>
                @php($enabledUser[] = $qualifiedUser->user->id)
            @endif
        </li>
    @endforeach
</ul>

</div>
</div>

<div class="mt-5 border-top pt-2">
@if ($aci_execution===0)
@if($aci_control_equipment_required===1)
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
@if ($aci_execution==0)
@if($aci_control_equipment_required===1)
<div class="tab-pane fade"
 id="controlEquipment"
 role="tabpanel"
 aria-labelledby="controlEquipment-tab"
>
<div class="row">
    <div class="col-md-6">
        <h2 class="h5">{{__('Verwendete Prüfmittel')}}</h2>
        <x-selectgroup
            id="set_control_equipment"
            label="{{__('Prüfmittel wählen')}}"
            btnL="{{__('hinzufügen')}}"
            class="btnAddControlEquipmentToList"
        >

            @forelse (App\Equipment::all() as $controlEquipment)
                @if($controlEquipment->getControlProductData() !== null)
                    @if($controlEquipment->ControlEquipment->first()->qe_control_date_due > now())
                        <option value="{{ $controlEquipment->id }}">
                            {{ $controlEquipment->eq_name  }}
                        </option>
                    @else
                        <option value="{{ $controlEquipment->id }}"
                                disabled
                        >{{ $controlEquipment->eq_name.' - '. $controlEquipment->eq_inventar_nr }} {{__('Prüfung überfällig!')}}
                        </option>
                    @endif
                @endif
            @empty
                <option value="void"
                        selected
                        disabled
                >{{__('Keine Prüfmittel gefunden')}}
                </option>
            @endforelse
        </x-selectgroup>

    </div>
    <div class="col-md-6">
        <ul class="list-group"
            id="ControlEquipmentToList"
        >
            <li class="controlEquipmentListInitialItem list-group-item list-group-item-warning d-flex justify-content-between align-items-center"
                id="control_equipment_item_${equip_id}"
            >
                <span>{{__('Keine Prüfmittel ausgewählt')}}</span> <span class="fas fa-exclamation ml-2"></span>
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
            class="btn btn-sm btn-primary bentNextTab btnCheckPMList"
            data-showtab="#controlSteps-tab"
    >{{__('weiter')}}</button>
</div>
</div>
@endif
<div class="tab-pane fade"
id="controlSteps"
role="tabpanel"
aria-labelledby="controlSteps-tab"
>
<div class="row">
<div class="col">

    <table class="table table-responsive-md table-borderless">

        @forelse (App\AnforderungControlItem::where('anforderung_id',$test->anforderung_id)->get() as $aci)

            @if(in_array(auth()->user()->id,$enabledUser))
                <tr>
                    <td colspan="4"
                        class="m-0 p-0"
                    >
                        <input type="hidden"
                               name="event_item[]"
                               id="event_item_{{ $aci->id }}"
                               value="{{ $aci->id }}"
                        >
                        <input type="hidden"
                               name="control_item_aci[{{ $aci->id }}][]"
                               id="control_item_aci_{{ $aci->id }}"
                               value="{{ $aci->id }}"
                        >
                        <span class="text-muted small">{{ __('Aufgabe / Ziel') }}:</span><br><span class="lead"> {{ $aci->aci_name }}</span>
                        <div class="dropdown d-md-none">
                            <button class="btn btn-sm btn-outline-primary"
                                    data-toggle="collapse"
                                    data-target="#taskDetails_{{ $aci->id }}"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="taskDetails_{{ $aci->id }}"
                            >
                                {{__('Details')}}
                            </button>

                            <div class="collapse"
                                 id="taskDetails_{{ $aci->id }}"
                            >
                                {{ $aci->aci_task }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col"
                        class="d-none d-md-table-cell"
                    >{{__('Beschreibung der Prüfung')}}
                    </th>
                    <th scope="col"
                        style="min-width: 95px;"
                    >{{__('Soll')}}
                    </th>
                    <th scope="col">{{__('Ist')}}</th>
                    <th scope="col">{{__('Bestanden')}}</th>
                </tr>
                <tr>
                    <td class="d-none d-md-table-cell">{{ $aci->aci_task }}</td>
                    <td style="vertical-align: middle;">
                        @if($aci->aci_vaule_soll !== null)
                            <strong>{{ $aci->aci_vaule_soll }}</strong> {{ $aci->aci_value_si }}
                        @else
                            -
                        @endif
                    </td>
                    <td style="min-width: 95px;">
                        @if($aci->aci_vaule_soll !== null)
                            <label for="control_item_read_{{ $aci->id }}"
                                   class="sr-only"
                            >Ist-Wert
                            </label>
                            <input type="text"
                                   placeholder="Wert"
                                   class="form-control decimal checkSollValue"
                                   id="control_item_read_{{ $aci->id }}"
                                   name="control_item_read[{{ $aci->id }}][]"
                                   data-aci_id="{{ $aci->id }}"
                                   data-aci_vaule_soll="{{ $aci->aci_vaule_soll }}"
                                   data-aci_value_target_mode="{{ $aci->aci_value_target_mode??'' }}"
                                   data-aci_value_tol="{{ $aci->aci_value_tol??'' }}"
                                   data-aci_value_tol_mod="{{ $aci->aci_value_tol_mod??'' }}"
                                   required
                            >
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-toggle"
                             data-toggle="buttons"
                        >
                            <label class="btn btn-outline-success">
                                <input type="radio"
                                       id="aci_Passed_{{ $aci->id }}"
                                       name="control_item_pass[{{ $aci->id }}][]"
                                       value="1"
                                       class="checkControlItem itemPassed"
                                >
                                JA
                            </label>
                            <label class="btn btn-outline-danger">
                                <input type="radio"
                                       id="aci_notPassed_{{ $aci->id }}"
                                       name="control_item_pass[{{ $aci->id }}][]"
                                       value="0"
                                       class="checkControlItem itemFailed"
                                >
                                NEIN
                            </label>
                        </div>

                    </td>
                </tr>
                @if (!$loop->last)
                    <tr>
                        <td colspan="4"
                            class="m-0 p-0"
                        >
                            <div class="dropdown-divider"></div>
                        </td>
                    </tr>
                @endif
            @else
                <tr>
                    <td>
                        <p>Zum Ausführen des Vorgangs <span class="badge-info p-2">{{ $aci->aci_name }}</span> fehlt Ihnen die benötigte Berechtigung!</p>
                        <p>Brechtigt sind: {{ App\User::with('profile')->find($aci->aci_contact_id)->name }}</p>
                    </td>
                </tr>
            @endif
        @empty
            <tr>
                <td>
                    <x-notifyer>Es sind keine Vorgänge zu diesem Gerät gefunden worden!</x-notifyer>
                </td>
            </tr>
        @endforelse
    </table>
</div>
</div>
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
                     label="Kürzel"
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
           @if ($aci_execution===1)
           required
        @endif
    >
    <label class="custom-file-label"
           for="prodDokumentFile"
    >{{__('Datei wählen')}}</label>
</div>


@if ($aci_execution===0)


    <h2 class="h4">{{__('Unterschriften')}}</h2>
    <p>Signieren Sie die erfolgte Prüfung. Sollte eine Signierung einer Führungskraft erforderlich sein, kann diese im Feld <code>Unterschrift Leitung</code> erfolgen.</p>
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
                <img src=""
                     class="d-none img-fluid"
                     alt="Unterschriftbild Prüfer"
                     id="imgSignaturePruefer"
                     style="height:200px"
                >
                <input type="hidden"
                       name="control_event_controller_signature"
                       id="control_event_controller_signature"
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
                         label="Prüfer Name"
            />
        </div>
        <div class="col-md-6">
            <x-textfield id="control_event_supervisor_name"
                         label="Leitung Name"
            />
        </div>
    </div>
@endif
</div>
</div>

<div class="row my-4">
<div class="col">
<h2 class="h4">Abschluss</h2>
<div class="row">
    <div class="col-md-6">
        <p class="lead">{{__('Das Gerät hat die Prüfung')}} </p>
        <div class="btn-group btn-group-toggle mt-md-4"
             data-toggle="buttons"
        >
            <label class="btn btn-outline-success active">
                <input type="radio"
                       id="controlEquipmentPassed"
                       name="control_event_pass"
                       value="1"
                > {{__('Bestanden')}}
            </label>
            <label class="btn btn-outline-danger">
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
                                    strtolower($test->Anforderung->ControlInterval->ci_delta)
                                    )
                                ->toDateString()
                                }}"
        />
    </div>
</div>
<x-textarea id="control_event_text"
            label="{{__('Bemerkungen zur Prüfung')}}"
/>
</div>
</div>
<button
id="btnSubmitControlEvent"
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
const tol = (aci_value_tol_mod === 'abs') ? aci_value_tol : aci_value_tol / 100;

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
$('.btnAddControlEquipmentToList').click(function () {
const nd = $('#set_control_equipment :selected');
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

});
$(document).on('click', '.btnDeleteControlEquipItem', function () {
$($(this).data('targetid')).remove();
if ($('.controlEquipmentListItem').length === 0) {
$('#ControlEquipmentToList').append(`
<li class="controlEquipmentListInitialItem list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
<span>Keine Prüfmittel ausgewählt</span>
<span class="fas fa-exclamation"></span>
</li>
`);
}
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
