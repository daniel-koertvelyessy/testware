<?php

namespace App\Http\Controllers;

use App\ControlEvent;
use App\ControlEquipment;
use App\ControlEventEquipment;
use App\ControlEventItem;
use App\Equipment;
use App\EquipmentHistory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ControlEventController extends Controller {

    use SoftDeletes;

    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index() {
        return view('testware.control.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return Application|Factory|Response|View
     */
    public function create(Request $request) {
        $controlItem = ControlEquipment::find($request->controlItem);
        return view('testware.control.create', ['controlItem' => $controlItem]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Application|Factory|Response|View
     */
    public function store(Request $request) {


        $ControlEquipment = ControlEquipment::find($request->control_equipment_id);

        $request->control_event_pass = request()->has('control_event_pass') ? 1 : 0;

        $setNewControlEquipment = new ControlEquipment();
        $setNewControlEquipment->qe_control_date_last = $request->control_event_date;
        $setNewControlEquipment->qe_control_date_due = $request->control_event_next_due_date;
        $setNewControlEquipment->qe_control_date_warn = $ControlEquipment->qe_control_date_warn;
        $setNewControlEquipment->anforderung_id = $ControlEquipment->anforderung_id;
        $setNewControlEquipment->equipment_id = $ControlEquipment->equipment_id;
        $setNewControlEquipment->save();

        $ControlEquipment->delete();

        $controlevent = ControlEvent::create($this->validateNewControlEvent());
        $itempassed = 0;
        $itemfailed = 0;
        $control_event_id = $controlevent->id;

        if (isset($request->evenItem)) {
            for ($i = 0; $i < count($request->evenItem); $i++) {
                $itemId = $request->evenItem[$i];
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

        $eh = new EquipmentHistory();

        $eh->eqh_eintrag_kurz = 'Prüfung am ' . $request->control_event_date . ' ausgeführt ';

        $text = 'Das Geräte wurde am ' . $request->control_event_date . ' geprüft. ';
        $text .= $itempassed . ' von ' . count($request->evenItem) . ' Prüfungen wurden bestanden.';
        $text .= ' Die nächste Prüfung wurde auf den ' . $request->control_event_next_due_date . ' gesetzt.';

        $eh->eqh_eintrag_text = $text;
        $eh->equipment_id = $request->equipment_id;
        $eh->save();


        return redirect(view('testware.equipment.show', ['equipment' => Equipment::find($request->equipment_id)->first()]));

    }

    /**
     * @return array
     */
    public function validateNewControlEvent()
    : array {
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
            'controlDokumentFile'                => 'nullable|file|mimes:pdf,tif,tiff,png,jpg,jpeg,gif,svg|max:10240',
            'control_equipment_id'               => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ControlEvent $control
     * @return Response
     */
    public function show(ControlEvent $control) {
        //
    }

    public function getControlEventDataSheet(Request $request) {

        return ControlEvent::makeControlEventReport($request->id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ControlEvent $control
     * @return Response
     */
    public function edit(ControlEvent $control) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request           $request
     * @param  \App\ControlEvent $control
     * @return Response
     */
    public function update(Request $request, ControlEvent $control) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ControlEvent $control
     * @return Response
     */
    public function destroy(ControlEvent $control) {
        //
    }
}
