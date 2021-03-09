<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use App\ControlDoc;
use App\ControlEvent;
use App\ControlEquipment;
use App\ControlEventEquipment;
use App\ControlEventItem;
use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentHistory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $controlItems = ControlEquipment::with('Equipment', 'Anforderung')->sortable()->paginate(20);
        return view('testware.control.index', compact('controlItems'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     *
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {

        $controlEquipmentIsComplete = true;
        $controlEquipmentIsCompleteMsg = __('<strong>Fehler</strong><p>Die Prüfung kann nicht gestartet werden, da folgende Probleme erkannt wurden:</p>');
        $controlEquipmentIsCompleteItem = '';
        $aci_execution = 0;
        $aci_control_equipment_required = 0;
        $controlItem = ControlEquipment::find($request->test_id);
        $qualifiedUser = 0;
        $qualifiedUser += $controlItem->Equipment->produkt->ProductQualifiedUser()->count();
        $qualifiedUser += $controlItem->Equipment->countQualifiedUser();


//dd($controlItem->Equipment);

        if ($controlItem->countQualifiedUser() === 0) {
            $controlEquipmentIsComplete = false;
            $controlEquipmentIsCompleteItem .= __('- Keine befähigte Nutzer gefunden!') . '<br>';
        }

        $acidata = AnforderungControlItem::where('anforderung_id', $controlItem->anforderung_id)->get();

        if ($acidata->count() === 0) {
            $controlEquipmentIsComplete = false;
            $controlEquipmentIsCompleteItem .= __('- Keine Kontrollvorgänge für die Anforderung gefunden!') . '<br>';
        }

        if ($controlEquipmentIsComplete) {
            foreach ($acidata as $aci) {
                $aci_execution = ($aci->aci_execution === 1) ? 1 : 0;
                $aci_control_equipment_required = ($aci->aci_control_equipment_required === 1) ? 1 : 0;
            }

            return view('testware.control.create', [
                'test'                           => $controlItem,
                'aci_execution'                  => $aci_execution,
                'aci_control_equipment_required' => $aci_control_equipment_required,
            ]);
        } else {
            $controlEquipmentIsCompleteMsg .= $controlEquipmentIsCompleteItem;

            $request->session()->flash('status', $controlEquipmentIsCompleteMsg);

            return redirect(route('equipment.show', $controlItem->Equipment));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        $ControlEquipment = ControlEquipment::find($request->control_equipment_id);

        $request->control_event_pass = request()->has('control_event_pass') ? 1 : 0;

        $setNewControlEquipment = new ControlEquipment();
        $setNewControlEquipment->qe_control_date_last = $request->control_event_date;
        $setNewControlEquipment->qe_control_date_due = $request->control_event_next_due_date;
        $setNewControlEquipment->qe_control_date_warn = $ControlEquipment->qe_control_date_warn;
        $setNewControlEquipment->anforderung_id = $ControlEquipment->anforderung_id;
        $setNewControlEquipment->equipment_id = $ControlEquipment->equipment_id;
        $setNewControlEquipment->save();

        $controlevent = ControlEvent::create($this->validateControlEvent());
        $itempassed = 0;
        $itemfailed = 0;
        $eventHasDoku = false;
        $filename = '';
        $control_event_id = $controlevent->id;

        if (isset($request->event_item)) {
            for ($i = 0; $i < count($request->event_item); $i++) {
                $itemId = $request->event_item[$i];
                $controlEventItem = new ControlEventItem();
                $controlEventItem->control_item_aci = $itemId;
                $controlEventItem->control_item_read = isset($request->control_item_read[$itemId][0]) ? $request->control_item_read[$itemId][0] : null;
                $controlEventItem->control_item_pass = $request->control_item_pass[$itemId][0];
                ($request->control_item_pass[$itemId][0] === '1') ? $itempassed++ : $itemfailed++;
                $controlEventItem->control_event_id = $control_event_id;
                $controlEventItem->equipment_id = $request->equipment_id;
                $controlEventItem->save();
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

        if ($request->hasFile('controlDokumentFile')) {
            $eventHasDoku = true;
            $filename = (new ControlDoc)->addDocument($request);
            $request->session()->flash('status', __('Das Dokument <strong>:name</strong> wurde hochgeladen!',['name'=>$filename]));
        }

//        dd();

        /**
         * Add Data to History
         */
        $text = 'Das Geräte wurde am ' . $request->control_event_date . ' geprüft. ';
        if (isset($request->event_item)) $text .= $itempassed . ' von ' . count($request->event_item) . ' Prüfungen wurden bestanden.';
        $text .= ' Die nächste Prüfung wurde auf den ' . $request->control_event_next_due_date . ' gesetzt.';
        if ($eventHasDoku) {
            $text .= ' Das Dokument ' . $filename . ' wurde erfolgreich angefügt.';
        }

        (new EquipmentHistory)->add(__('Prüfung am :conDate ausgeführt ', ['conDate' => $request->control_event_date]), $text, $request->equipment_id);
        $ControlEquipment->delete();
        return redirect(route('equipment.show', ['equipment' => Equipment::find($request->equipment_id)]));
    }

    /**
     * @return array
     */
    public function validateControlEvent()
    : array
    {
        return request()->validate([
            'control_event_next_due_date'        => 'date|required',
            'control_event_pass'                 => 'required',
            'control_event_date'                 => 'date|required',
            'control_event_controller_signature' => '',
            'control_event_controller_name'      => 'required',
            'control_event_supervisor_signature' => '',
            'control_event_supervisor_name'      => '',
            'user_id'                            => '',
            'control_event_text'                 => '',
            'control_equipment_id'               => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ControlEvent $control
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ControlEvent $control
     *
     * @return Response
     */
    public function edit(ControlEvent $control)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request           $request
     * @param  \App\ControlEvent $control
     *
     * @return Response
     */
    public function update(Request $request, ControlEvent $control)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ControlEvent $control
     *
     * @return Response
     */
    public function destroy(ControlEvent $control)
    {
        //
    }
}
