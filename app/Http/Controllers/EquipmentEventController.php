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

class EquipmentEventController extends Controller
{
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
        if (EquipmentEvent::count() > 10) {
            $eventList = EquipmentEvent::with('Equipment', 'User')->sortable()->paginate(10);
            return view('testware.events.index', ['eventListItems' => $eventList]);
        } else {
            $eventList = EquipmentEvent::with('Equipment', 'User')->sortable()->get();
            return view('testware.events.index', ['eventListItems' => $eventList]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('testware.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $event = EquipmentEvent::create($this->validateNewEquipmentEvent());
        return redirect()->route('event.show', $event);
    }

    /**
     * @return array
     */
    public function validateNewEquipmentEvent()
    : array
    {
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
     *
     * @return RedirectResponse
     */
    public function accept(Request $request)
    {
        $this->validateNewEquipmentEvent();

        $event = EquipmentEvent::find($request->equipment_event_id);
        $event->read = now();
        $event->update();

        $event_item = (new EquipmentEventItem)->addItem($request);

        $equipment = Equipment::where('id',$request->equipment_id)->first();
        $euipStatIsNotChanged = ($equipment->equipment_state_id == $request->equipment_state_id);

        if (!$euipStatIsNotChanged) {
            $stat = EquipmentState::find($request->equipment_state_id)->first();
            (new EquipmentHistory)->add(
                __('Gerätestatus geändert'),
                __('Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf :label geändert',['label'=>$stat->estat_label]),
                $equipment->equipment_id
            );

            $equipment->equipment_state_id = $request->equipment_state_id;
            $equipment->save();
        }

        $event = EquipmentEvent::find($request->equipment_event_id)->first();

        if (isset($request->setInformUser)) {
            Notification::send(User::find($request->user_id), new EquipmentEventChanged($event_item));
        }

        return redirect()->route('event.show', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentEvent $event
     *
     * @return Application|Factory|Response|View
     */
    public function show(EquipmentEvent $event)
    {
        return view('testware.events.show', compact('event'));
    }

    public function read(EquipmentEvent $event, $notification = NULL)
    {
        foreach(\Auth::user()->unreadNotifications()->get() as $note){
            if ($notification == $note->id) $note->markAsRead();
        }

        $event->markAsRead();
        return redirect()->route('event.show', $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentEvent $event
     *
     * @return Response
     */
    public function edit(EquipmentEvent $event)
    {
        dd($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request        $request
     * @param  EquipmentEvent $event
     *
     * @return Response
     */
    public function update(Request $request, EquipmentEvent $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentEvent $event
     * @param  Request        $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(EquipmentEvent $event, Request $request)
    : RedirectResponse
    {

        if (isset($request->event_decline_text)) {
            $eqh_eintrag_kurz = __('Schadensmeldung - Abgelehnt');
            $eqh_eintrag_text = __('Die Schadensmeldung wurde abgelehnt. Begründung: ') . request('event_decline_text');
        } else {
            $eqh_eintrag_kurz = __('Schadensmeldung - Abgeschlossen');
            $eqh_eintrag_text = __('Die Schadensmeldung wurde geschlossen. Bemerkung: ') . request('equipment_event_item_text');
        }

        (new EquipmentEventItem)->addItem($request);

        (new EquipmentHistory)->add($eqh_eintrag_kurz, $eqh_eintrag_text, $event->equipment->id);

        if (isset($request->equipment_state_id)) {
            $equipment = Equipment::find($event->equipment->id);
            $equipment->equipment_state_id = $request->equipment_state_id;
            $equipment->save();

            $stat = EquipmentState::find($request->equipment_state_id)->first();

            (new EquipmentHistory)->add(__('Gerätestatus geändert'), __('Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf :label geändert', ['label' => $stat->estat_label]), $event->equipment->id);

        }

        $event->delete();
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentEvent $event
     * @param  Request        $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function close(Request $request)
    : RedirectResponse
    {

        EquipmentEvent::destroy($request->equipment_event_id);

        (new EquipmentEventItem)->addItem($request);

        (new EquipmentHistory)->add(__('Schadensmeldung - Abgeschlossen'), __('Die Schadensmeldung wurde geschlossen. Bemerkung: :text', ['text' => request('equipment_event_item_text')]), $request->equipment_id);

        $equipment = Equipment::find($request->equipment_id);
        $equipment->equipment_state_id = $request->equipment_state_id;
        $equipment->save();

        $stat = EquipmentState::find($request->equipment_state_id)->first();

        (new EquipmentHistory)->add(__('Gerätestatus geändert'), __('Auf Grund einer Schadensbegutachtung wurde der Status des Gerätes auf :label geändert', ['label' => $stat->estat_label]), $request->equipment_id);

        (new EquipmentDocController)->store($request);

        return redirect()->route('dashboard');
    }


    public function restore(Request $request)
    {
        $event = EquipmentEvent::withTrashed()->find($request->id);
        $event->restore();
        return redirect()->route('event.show', $event);
    }
}
