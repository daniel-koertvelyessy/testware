<?php

namespace App\Http\Controllers;

use App\Building;
use App\Location;
use App\Room;
use App\RoomType;
use App\Standort;
use App\Stellplatz;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoomController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        if(Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie erst einen Standort bevor Sie weitere Objekte anlegen können!');
            return redirect()->route('location.create');
        }
        if(Building::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Gebäude!</span> <br>Erstellen Sie erst einen Gebäude bevor Sie Räume anlegen können!');
            return redirect()->route('building.create');
        }
        if (Room::all()->count() > 8) {
            $roomList = Room::with('RoomType')->paginate(100);
            return view('admin.standorte.room.index', ['roomList' => $roomList]);
        } else {
            return view('admin.standorte.room.index');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        if(Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie erst einen Standort bevor Sie weitere Objekte anlegen können!');
            return redirect()->route('location.create');
        }
        if(Building::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Gebäude!</span> <br>Erstellen Sie erst einen Gebäude bevor Sie Räume anlegen können!');
            return redirect()->route('building.create');
        }
        return view('admin.standorte.room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request) {
        $set = Room::create($this->validateNewRoom());

        (new \App\Standort)->add($request->standort_id, $request->r_name_kurz, 'rooms');

        $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde angelegt!');

        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewRoom()
    : array {
        return request()->validate([
            'r_name_kurz'  => 'bail|unique:rooms,r_name_kurz|max:20|required|',
            'standort_id'  => 'unique:rooms,standort_id',
            'r_name_lang'  => 'max:100',
            'r_name_text'  => '',
            'building_id'  => 'required',
            'room_type_id' => 'required'
        ]);
    }

    public function copyRoom(Request $request) {

        if ($request->id) {

            $bul = Room::find($request->id);
            $neuroom = '';
            switch (true) {
                case strlen($bul->r_name_kurz) <= 20 && strlen($bul->r_name_kurz) > 14:
                    $neuroom = substr($bul->r_name_kurz, 0, 13) . '_1';
                    break;
                case strlen($bul->b_name_kurz) <= 14:
                    $neuroom = $bul->r_name_kurz . '_1';
                    break;
            }

            $bul->r_name_kurz = $neuroom;
            $copy = new Room();
            $copy->r_name_kurz = $neuroom;
            $copy->r_name_text = $bul->r_name_text;
            $copy->r_name_lang = $bul->r_name_lang;
            $copy->building_id = $bul->building_id;
            $copy->room_type_id = $bul->room_type_id;
            $copy->standort_id = Str::uuid();
//            $copy->
            $validator = Validator::make([
                $copy->r_name_kurz,
                $copy->r_name_text,
                $copy->r_name_lang,
                $copy->building_id,
                $copy->room_type_id,
                $copy->standort_id,
            ], [
                'r_name_kurz'  => 'bail|required|unique:rooms,r_name_kurz|max:20',
                'r_name_text'  => '',
                'r_name_lang'  => '',
                'building_id'  => '',
                'room_type_id' => '',
                'standort_id'  => '',

            ]);
            $copy->save();

            $std = (new \App\Standort)->add($copy->standort_id, $neuroom, 'rooms');

            $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde kopiert!');
            return redirect()->back();
        } else {
            return 0;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  Room $room
     * @return Application|Factory|Response|View
     */
    public function show(Room $room) {
        return view('admin.standorte.room.show', ['room' => $room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Room $room
     * @return Application|Factory|Response|View
     */
    public function edit(Room $room) {
        return view('admin.standorte.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Room    $room
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Room $room) {

//        dd($room);
        $room->update($this->validateRoom());

        $request->session()->flash('status', 'Der Raum <strong>' . $room->r_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($room->path());
    }

    /**
     * @return array
     */
    public function validateRoom()
    : array {
        return request()->validate([
            'r_name_kurz' => 'bail|min:2|max:10|required|',
            'r_name_lang' => 'bail|min:2|max:100',
            'r_name_text' => '',
            'building_id' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Room    $room
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function destroy(Request $request, Room $room) {
//        dd($request);
        Room::destroy($request->id);
        $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde gelöscht!');
        return redirect()->back();
    }

    /**
     * Lösche Raum aus GebäudeView über Ajax-Request.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyRoomAjax(Request $request) {

        $rm = Room::find($request->id)->standort_id;

        $stnd = Standort::where('std_id',$rm)->first();

        $stnd->delete();

        $rname = request('r_name_kurz');
        if (Room::destroy($request->id)) {

            $request->session()->flash('status', 'Der Raum <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function getRoomList(Request $request) {
        $data['html'] = '';
        if ($request->id !== 'void') {
            $data['html'] .= '
<option value="void">Raum auswählen oder anlegen</option>
';
            foreach (Room::where('building_id', $request->id)->get() as $room)
                $data['html'] .= '
<option value="' . $room->id . '">' . $room->r_name_kurz . ' / ' . $room->r_name_lang . '</option>
';
        } else {
            $data['html'] .= '
<option value="void">Bitte Gebäude auswählen</option>
';
        }
        return $data;
    }

    public function modal(Request $request) {



        if ($request->room_type_id === 'new' && isset($request->newRoomType)) {
            $bt = new RoomType();
            $bt->rt_name_kurz = $request->newRoomType;
            $bt->save();
            $request->room_type_id = $bt->id;
        }

        if ($request->modalType === 'edit') {
            $room = Room::find($request->id);
            if ($room->r_name_kurz !== $request->r_name_kurz) {
                $standort = Standort::where('std_id', $request->standort_id)->first();
                $standort->std_kurzel = $request->r_name_kurz;
                $standort->save();
            }
            $room->update($this->validateRoom());
            $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde aktualisiert!');
        } else {
            $this->validateNewRoom();
            $room = new Room();
            $room->r_name_kurz = $request->r_name_kurz;
            $room->r_name_lang = $request->r_name_lang;
            $room->r_name_text = $request->r_name_text;
            $room->standort_id = $request->standort_id;
            $room->building_id = $request->building_id;
            $room->save();

            $std = (new \App\Standort)->add($request->standort_id, $request->r_name_kurz, 'rooms');
            $request->session()->flash('status', 'Der Raum <strong>' . request('r_name_kurz') . '</strong> wurde angelegt!');
        }

        return redirect()->back();

    }


    public function getRoomData(Request $request) {
        return Room::find($request->id);
    }
    public function getRoomListeAsTable() {
        $html = '<div class="col">
<table class="table table-sm table-striped">
    <thead>
    <tr>
    <th>Standort</th>
    <th>Gebäude</th>
    <th>Nummer</th>
    <th>Name</th>
    <th></th>
</tr>
</thead>
<tbody>
        ';

        foreach (Room::all() as $room) {
            $html .= '
            <tr>
            <td><a href="/location/' . $room->building->location->id . '">' . $room->building->location->l_name_kurz . '</a></td>
            <td><a href="/building/' . $room->building->id . '">' . $room->building->b_name_kurz . '</a></td>
            <td>' . $room->r_name_kurz . '</td>
            <td>' . $room->r_name_lang . '</td>
            <td>
                <a href="' . $room->path() . '">
                    <i class="fas fa-chalkboard"></i>
                    <span class="d-none d-md-table-cell">' . __('Übersicht') . '</span>
                </a>
            </td>
            </tr>';
        }
        $html .= '</tbody></table></div>';

        return ['html' => $html];

    }

    public function getRoomListeAsKachel() {
        $html = '';
        foreach (Room::all() as $room) {
            $html .= '<div class="col-md-6 col-lg-4 col-xl-3 locationListItem mb-lg-4 mb-sm-2" id="room_id_' . $room->id . '">
                        <div class="card" style="height:20em;">
                            <div class="card-header">
                                 Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/' . $room->building->location->id . '">' . $room->building->location->l_name_kurz . '</a>
                                <i class="fas fa-angle-right"></i>
                                <a href="/building/' . $room->building->id . '">' . $room->building->b_name_kurz . '</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . $room->r_name_kurz . '</h5>
                                <h6 class="card-subtitletext-muted">' . $room->r_name_lang . '</h6>
                                <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                <p class="mt-0" style="height:6em;">' . str_limit($room->r_name_text, 100) . '</p>
                            </div>
                            <div class="card-footer">
                                <a href="' . $room->path() . '" class="card-link"><i class="fas fa-chalkboard"></i> Übersicht</a>
                            </div>
                        </div>
                    </div>';
        }

        return ['html' => $html];

    }
}
