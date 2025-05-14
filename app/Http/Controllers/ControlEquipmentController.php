<?php

namespace App\Http\Controllers;

use App\AciDataSet;
use App\Anforderung;
use App\AnforderungControlItem;
use App\ControlDoc;
use App\ControlEquipment;
use App\ControlEvent;
use App\ControlEventDataset;
use App\ControlEventEquipment;
use App\ControlEventItem;
use App\ControlInterval;
use App\ControlProdukt;
use App\Equipment;
use App\EquipmentHistory;
use App\EquipmentQualifiedUser;
use App\Http\Services\Control\ControlEventService;
use App\Http\Services\Equipment\EquipmentEventService;
use App\Http\Services\Equipment\EquipmentService;
use App\ProductQualifiedUser;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Kyslik\ColumnSortable\Sortable;

class ControlEquipmentController extends Controller
{

    use SoftDeletes, Sortable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $controlItems = ControlEquipment::with([
            'Equipment:id,eq_name,eq_inventar_nr,eq_name,eq_uid',
            'Anforderung:id,an_label,an_name'
        ])->sortable()->paginate(10);
        $archivedControlItems = ControlEquipment::with('Equipment', 'Anforderung')->whereNotNull('archived_at')->get();
        $isSysAdmin = \Auth::user()->isSysAdmin();
        $controlIntervalList = ControlInterval::select('id', 'ci_label')->get();
        $requirements = Anforderung::select([
            'id',
            'an_label'
        ])->get();
        $countControlProducts = ControlProdukt::count();
        return view('testware.control.index', compact('controlItems', 'isSysAdmin', 'archivedControlItems', 'controlIntervalList', 'requirements', 'countControlProducts'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Redirector|RedirectResponse
     */
    public function create(Request $request)
    {
        $service = new EquipmentEventService();
        $controlItem = ControlEquipment::find($request->test_id);

        if (is_null($controlItem)) {
            $request->session()->flash('status', __('Die gesuchte Prüfung wurde nicht gefunden!'));
            return redirect(route('control.index'));
        }

        $check_aci_execution_is_external = [];
        $check_aci_control_equipment_required = [];
        $controlEquipmentIsComplete = true;
        $controlEquipmentIsCompleteMsg = __('<strong>Fehler</strong><p>Die Prüfung kann nicht gestartet werden, da folgende Probleme erkannt wurden:</p>');
        $controlEquipmentIsCompleteItem = '';


        if ($controlItem->countQualifiedUser() === 0) {
            $controlEquipmentIsComplete = false;
            $controlEquipmentIsCompleteItem .= __('- Keine befähigte Nutzer gefunden!').'<br>';
        }

        $acidata = AnforderungControlItem::where('anforderung_id', $controlItem->anforderung_id)->get();

        if ($acidata->count() === 0) {
            $controlEquipmentIsComplete = false;
            $controlEquipmentIsCompleteItem .= __('- Keine Kontrollvorgänge für die Anforderung gefunden!').'<br>';
        }

        if ($controlEquipmentIsComplete) {
            foreach ($acidata as $aci) {
                $check_aci_execution_is_external[] = $aci->aci_execution;
                $check_aci_control_equipment_required[] = $aci->aci_control_equipment_required;
            }

            $enabledUser = $service->getQuaifiedUserList($controlItem);
            $equipmentControlList = $service->makeEquipmentControlCollection();

//                dd($service->findAvaliableEquipmentControlItems());

            return view('testware.control.create', [
                'current_user'               => Auth::user(),
                'controlEquipmentAvaliable'  => $service->findAvaliableEquipmentControlItems(),
                'equipmentControlList'       => $equipmentControlList,
                'equipment'                  => Equipment::find($controlItem->equipment_id),
                'qualified_user_list'        => $enabledUser,
                'test'                       => $controlItem,
                'is_external'                => $controlItem->Anforderung->is_external,
                'control_equipment_required' => array_search(true, $check_aci_control_equipment_required),
            ]);
        } else {
            $controlEquipmentIsCompleteMsg .= $controlEquipmentIsCompleteItem;

            $request->session()->flash('status', $controlEquipmentIsCompleteMsg);

            return redirect(route('equipment.show', $controlItem->Equipment));
        }
    }

    public function archive(Request $request, ControlEquipment $controlequipment)
    {
        $controlequipment->archived_at = date('Y-m-d');
        $msg = $controlequipment->save()
            ? __('Prüfung wurde archiviert')
            : __('Die Prüfung konnte nicht archiviert werden');

        session()->flash('status', $msg);

        return back();
    }

    public function reactivate(Request $request, ControlEquipment $controlequipment)
    {
        $controlequipment->archived_at = null;
        $msg = $controlequipment->save()
            ? __('Prüfung wurde reaktiviert')
            : __('Die Prüfung konnte nicht reaktiviert werden');

        session()->flash('status', $msg);

        return back();
    }


    public function add(Request $request): RedirectResponse
    {

        $requirement = Anforderung::findOrFail($request->anforderung_id);

        $controlEquipment = new ControlEquipment();
        $controlEquipment->qe_control_date_last = $request->qe_control_date_last;
        $controlEquipment->qe_control_date_due = $request->qe_control_date_due;
        $controlEquipment->qe_control_date_warn = $request->qe_control_date_warn;
        $controlEquipment->control_interval_id = $requirement->control_interval_id;
        $controlEquipment->anforderung_id = $request->anforderung_id;
        $controlEquipment->equipment_id = $request->equipment_id;

        $msg = $controlEquipment->save()
            ? __('Prüfung wurde angelegt')
            : __('Die Prüfung konnte nicht angelegt werden');

        $request->session()->flash('status', $msg);


        return redirect(route('equipment.show', ['equipment' => Equipment::find($request->equipment_id)]));

    }

    public function store(Request $request): RedirectResponse
    {

//            dd($request);

        $controlEquipment = ControlEquipment::find($request->control_equipment_id);

        $equipment = Equipment::find($request->equipment_id);
        $changeEquipmentStatus = false;
        $itempassed = 0;
        $itemfailed = 0;
        $eventHasDoku = false;
        $filename = '';

        if ($controlEquipment) {
            $qe_control_date_warn = $controlEquipment->qe_control_date_warn;
            $anforderung_id = $controlEquipment->anforderung_id;
            $equipment_id = $controlEquipment->equipment_id;
        } else {
            /**
             *
             *   if $controlEquiment is not present it is
             *   assumed that equipment controlling was manually
             *   initiated.
             *
             *   Therefor a new instance of ControlEquipment is
             *   generated.
             *
             */
            $controlEquipment = new ControlEquipment();
            $controlEquipment->qe_control_date_last = $request->control_event_date;
            $controlEquipment->qe_control_date_due = $request->control_event_date;
            $controlEquipment->qe_control_date_warn = $request->qe_control_date_warn;
            $controlEquipment->control_interval_id = $request->control_interval_id;
            $controlEquipment->anforderung_id = $request->anforderung_id;
            $controlEquipment->equipment_id = $request->equipment_id;
            $controlEquipment->save();

            $qe_control_date_warn = $request->qe_control_date_warn;
            $anforderung_id = $request->anforderung_id;
            $equipment_id = $request->equipment_id;

            if (isset($request->setQualifiedUser)) {
                $setQualifiedUser = new EquipmentQualifiedUser();
                $setQualifiedUser->user_id = $request->user_id;
                $setQualifiedUser->equipment_id = $request->equipment_id;
                $setQualifiedUser->equipment_qualified_date = $request->control_event_date;
                $setQualifiedUser->equipment_qualified_firma = $request->equipment_qualified_firma;
                $setQualifiedUser->save();
            }

        }

        /**
         * get Equipment data
         */
        $old_state_id = $equipment->equipment_state_id;

        $request->control_event_pass = request()->has('control_event_pass')
            ? 1
            : 0;

        if ($old_state_id !== 1) {
            if ($request->control_event_pass === 1) {
                $equipment->equipment_state_id = 1;
                $equipment->save();
                $changeEquipmentStatus = true;
            }
        }

        $setNextControlEquipment = new ControlEquipment();
        $setNextControlEquipment->qe_control_date_last = $request->control_event_date;
        $setNextControlEquipment->qe_control_date_due = $request->control_event_next_due_date;
        $setNextControlEquipment->qe_control_date_warn = $qe_control_date_warn;
        $setNextControlEquipment->anforderung_id = $anforderung_id;
        $setNextControlEquipment->control_interval_id = $request->control_interval_id;
        $setNextControlEquipment->equipment_id = $equipment_id;
        $setNextControlEquipment->save();

        $this->validateControlEvent();
        $controlevent = new ControlEvent(); // ControlEvent::create();
        $controlevent->control_event_next_due_date = $request->control_event_next_due_date;
        $controlevent->control_event_pass = $request->control_event_pass;
        $controlevent->control_event_date = $request->control_event_date;
        $controlevent->control_event_controller_signature = $request->control_event_controller_signature;
        $controlevent->control_event_controller_name = $request->control_event_controller_name;
        $controlevent->control_event_supervisor_signature = $request->control_event_supervisor_signature;
        $controlevent->control_event_supervisor_name = $request->control_event_supervisor_name;
        $controlevent->user_id = $request->user_id;
        $controlevent->control_event_text = $request->control_event_text;
        $controlevent->control_equipment_id = $controlEquipment->id;
        $controlevent->save();

        $control_event_id = $controlevent->id;

        /**
         *  Check, if control event is internaly executed and store values accordingly
         */
        if ($controlEquipment->Anforderung->isInternal()) {

            if (isset($request->event_item)) {
                for ($i = 0; $i < count($request->event_item); $i++) {
                    $itemId = $request->event_item[$i];
                    $controlEventItem = new ControlEventItem();
                    $controlEventItem->control_item_aci = $itemId;
                    $controlEventItem->control_item_read = $request->control_item_read[$itemId] ?? null;

                    if (is_array($request->control_item_pass[$itemId])) {
                        $controlEventItem->control_item_pass = $request->control_item_pass[$itemId]['main'];
                        ($request->control_item_pass[$itemId]['main'] === '1')
                            ? $itempassed++
                            : $itemfailed++;
                    } else {
                        $controlEventItem->control_item_pass = $request->control_item_pass[$itemId];
                        ($request->control_item_pass[$itemId] === '1')
                            ? $itempassed++
                            : $itemfailed++;
                    }

                    $controlEventItem->control_event_id = $control_event_id;
                    $controlEventItem->equipment_id = $request->equipment_id;
                    $controlEventItem->save();

                    if (isset($request->dataset_item_read[$request->event_item[$i]])) {

                        foreach ($request->dataset_item_read as $dataset) {

                            foreach ($dataset as $aci_data_set_id => $datasetItem) {

                                $setresult = new ControlEventDataset();
                                ($request->control_item_pass[$itemId][$aci_data_set_id] === '1')
                                    ? $itempassed++
                                    : $itemfailed++;
                                $setresult->control_event_dataset_read = $datasetItem;
                                $setresult->control_event_dataset_pass = $request->control_item_pass[$itemId][$aci_data_set_id];

                                $setresult->aci_dataset_id = $aci_data_set_id;
                                $setresult->control_event_item_id = $controlEventItem->id;
                                $setresult->save();


                            }

                        }

                    }
                }
            }

            if (isset($request->control_event_equipment)) {
                for ($i = 0; $i < count($request->control_event_equipment); $i++) {
                    if ($request->control_event_equipment[$i] !== '00') {
                        $setControlEventEquipment = new ControlEventEquipment();
                        $setControlEventEquipment->equipment_id = $request->control_event_equipment[$i];
                        $setControlEventEquipment->control_event_id = $control_event_id;
                        $setControlEventEquipment->save();
                    }
                }
            }


        }

        if ($request->hasFile('controlDokumentFile')) {
            $eventHasDoku = true;
            $filename = (new ControlDoc)->addDocument($request);
            $request->session()->flash('status', __('Das Dokument <strong>:name</strong> wurde hochgeladen!', ['name' => $filename]));
        }


        /**
         * Add Data to History
         */
        $text = '<div class="d-flex flex-column">'.__('<span>Das Geräte wurde am :date geprüft:</span>', ['date' => $request->control_event_date]);

        /**
         * Start list of results
         */
        $text .= '<ul>';
        if (isset($request->event_item)) {
            $text .= __('<li>:passed von :total Prüfungen wurden bestanden</li>', [
                'passed' => $itempassed,
                'total'  => count($request->event_item)
            ]);
        }
        $text .= ($request->control_event_pass === 1)
            ? __('<li>Die Prüfung wurde insgesamt als <span class="text-success font-weight-bold">Bestanden</span> bewertet</li>')
            : __('<li>Die Prüfung wurde insgesamt als <span class="text-warning font-weight-bold">Nicht Bestanden</span> bewertet</li>');

        if ($changeEquipmentStatus) {
            $text .= __('<li>Der Gerätestatus wurde auf <span class="text-info font-weight-bold">:status</span> gesetzt</li>', ['status' => $equipment->EquipmentState->estat_label]);
        }

        $text .= __('<li>Die nächste Prüfung wurde auf den <span class="text-info">:date</span> gesetzt</li>', ['date' => $request->control_event_next_due_date]);
        if ($eventHasDoku) {
            $text .= __('<li>Das Dokument <span class="text-info">:name</span> wurde erfolgreich angefügt</li>', ['name' => $filename]);
        }
        $text .= '</ul></div>';

        (new EquipmentHistory)->add(__('Prüfung am :conDate ausgeführt ', ['conDate' => $request->control_event_date]), $text, $request->equipment_id);

        $controlEquipment->delete();

        return redirect(route('equipment.show', ['equipment' => Equipment::find($request->equipment_id)]));
    }

    /**
     * @return array
     */
    public function validateControlEvent(): array
    {
        return request()->validate([
            'control_event_next_due_date'        => 'date|required|after_or_equal::control_event_date',
            'control_event_pass'                 => 'required',
            'control_event_date'                 => 'date|required',
            'control_event_controller_signature' => '',
            'control_event_controller_name'      => 'required',
            'control_event_supervisor_signature' => '',
            'control_event_supervisor_name'      => '',
            'user_id'                            => '',
            'control_event_text'                 => '',
            'control_equipment_id'               => ''
        ], [
            'control_event_pass.required'            => __('Die abschließende Bewertung der Prüfung ist nicht gesetzt!'),
            'control_event_controller_name.required' => __('Der Name des Prüfers ist nicht gegeben!'),
            'control_event_next_due_date.required'   => __('Es wurde kein Datum für die nächste Prüfung vergeben!'),
            'control_event_next_due_date.after'      => __('Die nächste Prüfung kann nicht in der Vergangenheit liegen!'),
            'control_event_date.required'            => __('Bitte tragen Sie das Datum der Prüfung ein!'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  ControlEvent  $control
     *
     * @return Response
     */
    public function show(ControlEvent $control)
    {
        //
    }

    public function getControlEventDataSheet(Request $request)
    {

        return ControlEvent::makeControlEventReport($request->id);
    }

    public function edit(ControlEquipment $control)
    {
        return view('testware.control.edit', compact('control'));
    }

    public function update(Request $request, ControlEquipment $control)
    {
        $control->update($this->validateEquipmentControl());
        return back();
    }

    public function validateEquipmentControl(): array
    {
        return request()->validate([
            'archived_at'          => 'nullable|date',
            'qe_control_date_last' => 'date',
            'qe_control_date_due'  => 'date',
            'qe_control_date_warn' => '',
            'control_interval_id'  => '',
            'anforderung_id'       => 'required',
            'equipment_id'         => 'required',
        ], [
            'control_event_pass.required'                => __('Die abschließende Bewertung der Prüfung ist nicht gesetzt!'),
            'control_event_controller_name.required'     => __('Der Name des Prüfers ist nicht gegeben!'),
            'control_event_next_due_date.required'       => __('Es wurde kein Datum für die nächste Prüfung vergeben!'),
            'control_event_next_due_date.after_or_equal' => __('Die nächste Prüfung kann nicht in der Vergangenheit liegen!'),
            'control_event_date.required'                => __('Bitte tragen Sie das Datum der Prüfung ein!'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function destroy(Request $request, $control)
    {

        if (!\Auth::user()->isSysAdmin()) {
            request()->session()->flash('status', 'Keine Berechtigung zum Löschen des Eintrages!');
            return redirect()->back();
        }


        $controlEquipment = ControlEquipment::withTrashed()->findOrFail($control);

        $equipment_id = $controlEquipment->equipment_id;

        $control_date = $controlEquipment->created_at;


        if ($controlEquipment->forceDelete()) {
            $msg = 'Die Prüfung vom '.$control_date.' wurde erfolgreich gelöscht';
            (new EquipmentHistory)->add('Prüfung gelöscht', $msg, $equipment_id);

        } else {
            $msg = 'Fehler beim Löschen der Prüfung!';
        }

        Cache::forget('system-status-database');

        request()->session()->flash('status', $msg);
        return redirect()->back();

    }

    public function sync(Request $request)
    {
        $service = new ControlEventService();
        $res = [];
        if (isset($request->sycEquip) && count($request->sycEquip) > 0) {

            foreach ($request->sycEquip as $eq_uid) {
                $res[$eq_uid] = $service->syncEquipment($eq_uid, $request->has('sycEquipWithDeletion'));
            }
        }

        $request->session()->flash('status', $service->makeSyncMessageText($res));
        return back();
    }

    public function manual()
    {


        $requirement = Anforderung::find(request('requirement'));


        $equipment = Equipment::where('eq_uid', request('equipment'))->first();
        $service = new EquipmentEventService();
        if (!$equipment) {
            $equipment = Equipment::find(request('equipment'));
        };
        $enabledUser = [];
        $check_aci_execution_is_external = [];
        $check_aci_control_equipment_required = [];
        $equipmentControlList = $service->makeEquipmentControlCollection();


        $acidata = AnforderungControlItem::where('anforderung_id', $requirement->id)->get();

        foreach ($acidata as $aci) {
            $check_aci_execution_is_external[] = $aci->aci_execution;
            $check_aci_control_equipment_required[] = $aci->aci_control_equipment_required;
        }

        if ($equipment) {
            return view('testware.control.manual', [
                'controlEquipmentAvaliable'  => $service->findAvaliableEquipmentControlItems(),
                'equipmentControlList'       => $equipmentControlList,
                'qualifieduserList'          => (new EquipmentService)->getQualifiedPersonList($equipment),
                'current_user'               => Auth::user(),
                'userList'                   => User::select('id', 'name')->get(),
                'equipment'                  => $equipment,
                'requirement'                => $requirement,
                'qualified_user_list'        => $enabledUser,
                'is_external'                => $requirement->is_external,
                'control_equipment_required' => array_search(true, $check_aci_control_equipment_required),
            ]);
        } else {
            \Log::error('fehler beim Erstellen der Prüfung -> request '.\request());
            request()->session()->flash('status', 'Fehler beim Erstellen der Prüfung');
            return redirect()->route('equipment.maker');
        }

    }

    /*public function manual(ControlEvent $controlEvent, Equipment $equipment, Request $request)
    {

        (new EquipmentFuntionControl())->addControlEvent($request, $equipment->id);

        if ($request->hasFile('equipDokumentFile')) {
            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');
            $validation = $request->validate([
                'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
                // size:2048 => 2048kB
                'eqdoc_label'       => 'required|max:150'
            ]);
            $proDocFile->eqdoc_name = $file->getClientOriginalName();
            $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . $equipment->id);
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->equipment_id = $equipment->id;
            $proDocFile->eqdoc_description = request('eqdoc_description');
            $proDocFile->eqdoc_label = request('eqdoc_label');
            $proDocFile->save();
        } else {
            (new EquipmentHistory)->add(__('Fehlende Angaben beim Anlegen'), __('Das Geräte wurde ohne Prüfdokumente angelegt. Gerät erhält den Status "gesperrt"!'), $equipment->id);
        }

        if ($request->function_control_profil !== 'void') {

            $qualifiedUser = new EquipmentQualifiedUser();
            $qualifiedUser->equipment_qualified_firma = null;
            $qualifiedUser->equipment_qualified_date = date('Y-m-d');
            $qualifiedUser->user_id = $request->function_control_profil;
            $qualifiedUser->equipment_id = $equipment->id;
            $qualifiedUser->save();

            (new EquipmentHistory)->add(__('Befähigte Person angelegt'), User::find($request->function_control_profil)->name . ' ' . __('wurde als befähigte Person hinzugefügt.'), $equipment->id);

        }

    }*/

    public function fixbroken(Request $request)
    {
        $control = ControlEquipment::withTrashed()->findOrFail($request->control_equipment_id);
        $control->anforderung_id = $request->anforderung_id;
        $control->equipment_id = $request->equipment_id;
        $msg = $control->save()
            ? 'Prüfung korrigiert'
            : 'Fehler beim Speichern';
        $request->session()->flash('status', $msg);
        Cache::forget('system-status-database');
        return back();
    }

}
