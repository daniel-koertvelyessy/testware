<?php

namespace App\Http\Controllers;

use App\Building;
use App\Location;
use App\Room;
use App\RoomType;
use App\Storage;
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

class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">' . __('Es existieren noch keine Standorte!') . '</span> <br>' . __('Erstellen Sie erst einen Standort bevor Sie weitere Objekte anlegen können!'));
            return redirect()->route('location.create');
        }
        if (Building::all()->count() === 0) {
            session()->flash('status', '<span class="lead">' . __('Es existieren noch keine Gebäude!') . '</span> <br>' . __('Erstellen Sie erst einen Gebäude bevor Sie Räume anlegen können!'));
            return redirect()->route('building.create');
        }
        if (Room::all()->count() > 10) {
            $roomList = Room::with('RoomType', 'location')->sortable()->paginate(10);
            return view('admin.standorte.room.index', ['roomList' => $roomList]);
        } elseif (Room::all()->count() > 0) {
            $roomList = Room::with('RoomType', 'location')->sortable()->get();
            return view('admin.standorte.room.index', ['roomList' => $roomList]);
        } else {
            session()->flash('status', __('Es existieren noch keine Räume!'));
            return redirect()->route('room.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">' . __('Es existieren noch keine Standorte!') . '</span> <br>Erstellen Sie erst einen Standort bevor Sie weitere Objekte anlegen können!');
            return redirect()->route('location.create');
        }
        if (Building::all()->count() === 0) {
            session()->flash('status', '<span class="lead">' . __('Es existieren noch keine Gebäude!') . '</span> <br>' . __('Erstellen Sie erst einen Gebäude bevor Sie Räume anlegen können!'));
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
    public function store(Request $request)
    {
        $room =  Room::create($this->validateNewRoom());
        (new Storage)->add($request->storage_id, $request->r_label, 'rooms');
        $request->session()->flash(
            'status',
            __('Der Raum') . ' <strong>' . request('r_label') . '</strong> ' .  __('wurde angelegt!')
        );
        return redirect()->route('room.show', $room);
    }

    /**
     * @return array
     */
    public function validateNewRoom(): array
    {
        return request()->validate([
            'r_label'  => 'bail|unique:rooms,r_label|max:20|required|',
            'storage_id'  => 'unique:rooms,storage_id',
            'r_name'  => 'max:100',
            'r_name_text'  => '',
            'building_id'  => 'required',
            'room_type_id' => 'required'
        ]);
    }

    public function copyRoom(Request $request)
    {

        if ($request->id) {

            $bul = Room::find($request->id);
            $neuroom = '';
            switch (true) {
                case strlen($bul->r_label) <= 20 && strlen($bul->r_label) > 14:
                    $neuroom = substr($bul->r_label, 0, 13) . '_1';
                    break;
                case strlen($bul->b_label) <= 14:
                    $neuroom = $bul->r_label . '_1';
                    break;
            }

            $bul->r_label = $neuroom;
            $copy = new Room();
            $copy->r_label = $neuroom;
            $copy->r_name_text = $bul->r_name_text;
            $copy->r_name = $bul->r_name;
            $copy->building_id = $bul->building_id;
            $copy->room_type_id = $bul->room_type_id;
            $copy->storage_id = Str::uuid();
            //            $copy->
            $validator = Validator::make([
                $copy->r_label,
                $copy->r_name_text,
                $copy->r_name,
                $copy->building_id,
                $copy->room_type_id,
                $copy->storage_id,
            ], [
                'r_label'  => 'bail|required|unique:rooms,r_label|max:20',
                'r_name_text'  => '',
                'r_name'  => '',
                'building_id'  => '',
                'room_type_id' => '',
                'storage_id'  => '',

            ]);
            $copy->save();

            $std = (new Storage)->add($copy->storage_id, $neuroom, 'rooms');

            $request->session()->flash('status', 'Der Raum <strong>' . request('r_label') . '</strong> wurde kopiert!');
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
    public function show(Room $room)
    {
        return view('admin.standorte.room.show', ['room' => $room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Room $room
     * @return Application|Factory|Response|View
     */
    public function edit(Room $room)
    {
        return view('admin.standorte.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Room    $room
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Room $room)
    {

        //        dd($room);
        $room->update($this->validateRoom());
        if ($room->r_label !== $request->r_label) {
            $storage = Storage::where('storage_uid', $request->storage_id)->first();
            $storage->storage_label = $request->r_label;
            $storage->save();
        }
        $request->session()->flash('status', 'Der Raum <strong>' . $room->r_label . '</strong> wurde aktualisiert!');
        return redirect($room->path());
    }

    /**
     * @return array
     */
    public function validateRoom(): array
    {
        return request()->validate([
            'r_label' => 'bail|min:2|max:10|required|',
            'r_name' => 'bail|min:2|max:100',
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
    public function destroy(Request $request, Room $room)
    {
        //        dd($request);
        Room::destroy($request->id);
        $request->session()->flash('status', 'Der Raum <strong>' . request('r_label') . '</strong> wurde gelöscht!');
        return redirect()->back();
    }

    /**
     * Lösche Raum aus GebäudeView über Ajax-Request.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyRoomAjax(Request $request)
    {

        $rm = Room::find($request->id)->storage_id;

        $stnd = Storage::where('storage_uid', $rm)->first();

        $stnd->delete();

        $rname = request('r_label');
        if (Room::destroy($request->id)) {

            $request->session()->flash('status', 'Der Raum <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function getStellplatzListInRoom(Request $request)
    {
        $data['html'] = '';
        if ($request->id !== 'void') {
            //            $data['html'] .= '
            //<option value="void">Stellplatz auswählen oder anlegen</option>
            //';
            if (Stellplatz::where('room_id', $request->id)->count() > 0) {
                foreach (Stellplatz::where('room_id', $request->id)->get() as $stellplatz) {
                    $data['html'] .= '
<option value="' . $stellplatz->id . '">[' . $stellplatz->StellplatzTyp->spt_label . '] ' . $stellplatz->sp_label . ' / ' . $stellplatz->sp_name . '</option>
';
                }
            } else {
                $data['html'] .= '
<option value="void">Keine Stellplätze im Raum vorhanden</option>
';
            }
        } else {
            $data['html'] .= '
<option value="void">Bitte Stellplatz auswählen</option>
';
        }
        return $data;
    }

    public function modal(Request $request)
    {

        if ($request->room_type_id === 'new' && isset($request->newRoomType)) {
            $bt = new RoomType();
            $bt->rt_label = $request->newRoomType;
            $bt->save();
            $request->room_type_id = $bt->id;
        }

        if ($request->modalType === 'edit') {
            $room = Room::find($request->id);
            if ($room->r_label !== $request->r_label) {
                $storage = Storage::where('storage_uid', $request->storage_id)->first();
                $storage->storage_label = $request->r_label;
                $storage->save();
            }
            $room->update($this->validateRoom());
            $request->session()->flash('status', 'Der Raum <strong>' . request('r_label') . '</strong> wurde aktualisiert!');
        } else {
            $this->validateNewRoom();
            $room = new Room();
            $room->r_label = $request->r_label;
            $room->r_name = $request->r_name;
            $room->r_name_text = $request->r_name_text;
            $room->storage_id = $request->storage_id;
            $room->building_id = $request->building_id;
            $room->room_type_id = $request->room_type_id;
            $room->save();

            $std = (new Storage)->add($request->storage_id, $request->r_label, 'rooms');
            $request->session()->flash('status', 'Der Raum <strong>' . request('r_label') . '</strong> wurde angelegt!');
        }

        return redirect()->back();
    }


    public function getRoomData(Request $request)
    {
        return Room::find($request->id);
    }
    public function getRoomListeAsTable()
    {
        $html = '<div class="col">
<table class="table table-responsive-md table-sm table-striped">
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
            <td><a href="/location/' . $room->building->location->id . '">' . $room->building->location->l_label . '</a></td>
            <td><a href="/building/' . $room->building->id . '">' . $room->building->b_label . '</a></td>
            <td>' . $room->r_label . '</td>
            <td>' . $room->r_name . '</td>
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

    public function getRoomListeAsKachel()
    {
        $html = '';
        foreach (Room::all() as $room) {
            $html .= '<div class="col-md-6 col-lg-4 col-xl-3 locationListItem mb-lg-4 mb-sm-2" id="room_id_' . $room->id . '">
                        <div class="card" style="height:20em;">
                            <div class="card-header">
                                 Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/' . $room->building->location->id . '">' . $room->building->location->l_label . '</a>
                                <i class="fas fa-angle-right"></i>
                                <a href="/building/' . $room->building->id . '">' . $room->building->b_label . '</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . $room->r_label . '</h5>
                                <h6 class="card-subtitletext-muted">' . $room->r_name . '</h6>
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
