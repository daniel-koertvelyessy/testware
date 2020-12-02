<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentEvent;
use App\EquipmentEventItem;
use App\EquipmentHistory;
use App\EquipmentState;
use App\EquipmentUid;
use App\Notifications\EquipmentEventChanged;
use App\Notifications\EquipmentEventCreated;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class EquipmentEventController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index() {
        $eventList = EquipmentEvent::paginate(10);
        return view('testware.events.index', ['eventListItems' => $eventList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create() {
        return view('testware.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {

        $event = EquipmentEvent::create($this->validateNewEquipmentEvent());
        return redirect()->route('event.show', $event);
    }

    /**
     * @return array
     */
    public function validateNewEquipmentEvent()
    : array {
        return request()->validate([
            'equipment_event_text' => '',
            'equipment_event_user' => '',
            'equipment_id'         => 'required',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function accept(Request $request) {
        $this->validateNewEquipmentEvent();

        $event = EquipmentEvent::find($request->equipment_event_id);
        $event->read = now();
        $event->update();
        $eeitem = new EquipmentEventItem();
        $eeitem->equipment_event_item_text = $request->equipment_event_item_text;
        $eeitem->user_id = (isset($request->user_id)) ? $request->user_id : Auth()->user()->id;
        $eeitem->equipment_event_id = $request->equipment_event_id;
        $eeitem->save();

        $equipment = Equipment::find($request->equipment_id)->first();
        $euipStatIsNotChanged = ($equipment->equipment_state_id == $request->equipment_state_id);

        if (!$euipStatIsNotChanged) {
            $eh = new EquipmentHistory();
            $stat = EquipmentState::find($request->equipment_state_id)->first();
            $eh->eqh_eintrag_kurz = __('Gerätestatus geändert');
            $eh->eqh_eintrag_text = 'Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf ' . $stat->estat_name_kurz . ' geändert';
            $eh->equipment_id = $equipment->equipment_id;
            $eh->save();
            $equipment->equipment_state_id = $request->equipment_state_id;
            $equipment->update();
        }

        $event = EquipmentEvent::find($request->equipment_event_id)->first();

        if (isset($request->setInformUser)) {
//            request()->user()->notify(new EquipmentEventChanged($eeitem));
            Notification::send(User::find($request->user_id), new EquipmentEventChanged($eeitem));
        }

        return redirect()->route('event.show', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentEvent $event
     * @return Application|Factory|Response|View
     */
    public function show(EquipmentEvent $event) {
        /*    $event->updated_at = now();
            $event->update();*/
        return view('testware.events.show', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentEvent $equipmentEvent
     * @return Response
     */
    public function edit(EquipmentEvent $equipmentEvent) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request        $request
     * @param  EquipmentEvent $equipmentEvent
     * @return Response
     */
    public function update(Request $request, EquipmentEvent $equipmentEvent) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentEvent $event
     * @param  Request        $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(EquipmentEvent $event, Request $request) {
        $event->delete();

        $eh = new EquipmentHistory();
        if (isset($request->event_decline_text)) {
            $eh->eqh_eintrag_kurz = __('Schadensmeldung - Abgelehnt');
            $eh->eqh_eintrag_text = 'Die Schadensmeldung wurde abgelehnt. Begründung: ' . request('event_decline_text');
        } else {
            $eh->eqh_eintrag_kurz = __('Schadensmeldung - Abgeschlossen');
            $eh->eqh_eintrag_text = 'Die Schadensmeldung wurde geschlossen. Bemerkung: ' . request('equipment_event_item_text');
        }
        $eh->equipment_id = $event->equipment->id;
        $eh->save();

        if (isset($request->equipment_state_id)) {
            $equipment = Equipment::find($eh->equipment_id);
            $equipment->equipment_state_id = $request->equipment_state_id;
            $equipment->save();
            $stat = EquipmentState::find($request->equipment_state_id)->first();

            $eh = new EquipmentHistory();
            $eh->eqh_eintrag_kurz = __('Gerätestatus geändert');
            $eh->eqh_eintrag_text = 'Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf ' . $stat->estat_name_kurz . ' geändert';
            $eh->equipment_id = $event->equipment->id;
            $eh->save();
        }

        return redirect()->route('testware.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentEvent $event
     * @param  Request        $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function close(EquipmentEvent $event, Request $request) {
//dd($request);
        $event->delete();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = __('Schadensmeldung - Abgeschlossen');
        $eh->eqh_eintrag_text = 'Die Schadensmeldung wurde geschlossen. Bemerkung: ' . request('equipment_event_item_text');
        $eh->equipment_id = $request->equipment_id;
        $eh->save();

        $equipment = Equipment::find($request->equipment_id);
        $equipment->equipment_state_id = $request->equipment_state_id;
        $equipment->save();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = __('Gerätestatus geändert');
        $stat = EquipmentState::find($request->equipment_state_id)->first();
        $eh->eqh_eintrag_text = 'Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf ' . $stat->estat_name_kurz . ' geändert';
        $eh->equipment_id = $request->equipment_id;
        $eh->save();

        $doc = new EquipmentDocController();
        $doc->store($request);

        return redirect()->route('testware.index');
    }


    public function restore(Request $request) {
        $event = EquipmentEvent::withTrashed()->find($request->id);
        $event->restore();
        return redirect()->route('event.show', $event);
    }
}
