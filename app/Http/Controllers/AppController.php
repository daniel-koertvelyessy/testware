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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AppController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {

        $userid = (isset($request->equipment_event_user)) ? $request->equipment_event_user : 1;
        $equipment = EquipmentUid::where('equipment_uid', $request->equipment_id)->first();
//        $this->validateNewEquipmentEvent();
//        dd($equipment->equipment_id);
        $eevent = new EquipmentEvent();
        $eevent->equipment_event_text = $request->equipment_event_text;
        $eevent->equipment_event_user = $userid;
        $eevent->equipment_id = $equipment->equipment_id;
        $eevent->save();

        $eh = new EquipmentHistory();

        $eh->eqh_eintrag_kurz = __('Schadensmeldung');
        $eh->eqh_eintrag_text = 'Gerät wurde über die App als beschädigt gemeldet. Das Event wurde ausgelöst und wird nachverfolgt.';
        $eh->equipment_id = $equipment->equipment_id;
        $eh->save();
        Notification::send(User::find($userid), new EquipmentEventCreated($eevent));

        $request->session()->flash('status', 'Schadensmeldung wurde erfolgreich eingereicht. Vielen Dank!');
        return redirect()->route('portal-main');
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
}