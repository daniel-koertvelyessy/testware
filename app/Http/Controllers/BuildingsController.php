<?php

namespace App\Http\Controllers;

use App\Building;
use App\BuildingTypes;
use App\Location;
use App\Room;
use App\Storage;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Boolean;

class BuildingsController extends Controller
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
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie erst einen Standort bevor Sie ein Gebäude anlegen können!');
            return redirect()->route('location.create');
        }
        if (Building::all()->count() > 0) {
            $buildingList = Building::with('BuildingType')->sortable()->paginate(10);
            return view('admin.standorte.building.index', ['buildingList' => $buildingList]);
        } else {
            return redirect()->route('building.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie erst einen Standort bevor Sie ein Gebäude anlegen können!');
            return redirect()->route('location.create');
        }
        return view('admin.standorte.building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->b_we_has = $request->has('b_we_has') ? 1 : 0;

        $building = Building::create($this->validateNewBuilding());

        $std = (new \App\Storage)->add($request->storage_id, $request->b_label, 'buildings');

        $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewBuilding()
    : array
    {
        return request()->validate([
            'b_label'          => 'bail|required|unique:buildings,b_label|min:2|max:20',
            'b_name_ort'       => '',
            'b_name'           => '',
            'b_description'    => '',
            'b_we_has'         => '',
            'storage_id'       => '',
            'b_we_name'        => 'required_if:b_we_has,1',
            'location_id'      => 'required',
            'building_type_id' => 'required',
        ]);
    }

    public function copyBuilding(Request $request)
    {
        if ($request->id) {

            $bul = Building::find($request->id);
            $neuname = '';
            switch (true) {
                case strlen($bul->b_label) <= 20 && strlen($bul->b_label) > 14:
                    $neuname = substr($bul->b_label, 0, 13) . '_1';
                    break;
                case strlen($bul->b_label) <= 14:
                    $neuname = $bul->b_label . '_1';
                    break;
            }


            $bul->b_label = $neuname;
            $copy = new Building();
            $copy->b_label = $neuname;
            $copy->b_name_ort = $bul->b_name_ort;
            $copy->b_name = $bul->b_name;
            $copy->b_description = $bul->b_description;
            $copy->b_we_has = $bul->b_we_has;
            $copy->b_we_name = $bul->b_we_name;
            $copy->location_id = $bul->location_id;
            $copy->building_type_id = $bul->building_type_id;
            $copy->storage_id = Str::uuid();
            //            $copy->
            $validator = Validator::make([
                $copy->b_label,
                $copy->b_name_ort,
                $copy->b_name,
                $copy->b_description,
                $copy->b_we_has,
                $copy->b_we_name,
                $copy->location_id,
                $copy->building_type_id,
                $copy->storage_id,

            ], [
                'b_label'          => 'bail|required|unique:buildings,b_label|min:2|max:10',
                'b_name_ort'       => '',
                'b_name'           => '',
                'b_description'    => '',
                'b_we_has'         => '',
                'b_we_name'        => 'required_if:b_we_has,1',
                'location_id'      => 'required',
                'building_type_id' => 'required',
            ]);
            $copy->save();

            $std = (new \App\Storage)->add($copy->storage_id, $neuname, 'buildings');

            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde kopiert!');
            return redirect()->back();
        } else {
            $request->session()->flash('status', '<p>Fehler!</p>Das Gebäude <strong>' . request('b_label') . '</strong> konnte nicht kopiert werden!');
            return redirect()->back();
        }
    }

    public function getBuildingList($id)
    {
        return DB::table('buildings')->where('location_id', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  Building $building
     *
     * @return Application|Factory|Response|View
     */
    public function show(Building $building)
    {
        return view('admin.standorte.building.show', ['building' => $building]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Building $building
     *
     * @return Application|Factory|View
     */
    public function edit(building $building)
    {
        return view('admin.standorte.building.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Building $building
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Building $building)
    {

        if ($building->b_label !== $request->b_label) {
            $storage = Storage::where('storage_uid', $request->storage_id)->first();
            $storage->storage_label = $request->b_label;
            $storage->save();
        }
        $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
        $building->update($this->validateBuilding());

        $request->session()->flash('status', 'Das Gebäude <strong>' . $building->b_label . '</strong> wurde aktualisiert!');
        return redirect($building->path());
    }

    /**
     * @return array
     */
    public function validateBuilding()
    : array
    {
        return request()->validate([
            'b_label'          => 'bail|required|min:2|max:20',
            'b_name_ort'       => '',
            'b_name'           => '',
            'b_description'    => '',
            'b_we_has'         => '',
            'b_we_name'        => 'required_if:b_we_has,1',
            'location_id'      => 'required',
            'building_type_id' => '',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  Building $building
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, Building $building)
    {
        $rname = request('b_label');
        $building->delete();
        $request->session()->flash('status', 'Das Gebäude <strong>' . $rname . '</strong> wurde gelöscht!');
        return redirect()->back();
    }

    public function getBuildingData(Request $request)
    {
        return Building::find($request->id);
    }

    public function modal(Request $request)
    {

        if ($request->building_type_id === 'new' && isset($request->newBuildingType)) {
            $bt = new BuildingTypes();
            $bt->btname = $request->newBuildingType;
            $bt->save();
            $request->building_type_id = $bt->id;
        }


        if ($request->modalType === 'edit') {
            $buildingOld = Building::find($request->id);
            $buildingOld->b_we_has = $request->has('b_we_has') ? 1 : 0;
            if ($buildingOld->b_label !== $request->b_label) {
                $storage = Storage::where('storage_uid', $request->storage_id)->first();
                $storage->storage_label = $request->b_label;
                $storage->save();
            }
            $buildingOld->update($this->validateBuilding());
            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde aktualisiert!');
        } else {

            $this->validateNewBuilding();
            $building = new Building(); //::create();
            $building->b_label = $request->b_label;
            $building->b_name_ort = $request->b_name_ort;
            $building->b_name = $request->b_name;
            $building->b_description = $request->b_description;
            $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
            $building->storage_id = $request->storage_id;
            $building->b_we_name = $request->b_we_name;
            $building->location_id = $request->location_id;
            $building->building_type_id = $request->building_type_id;
            $building->save();

            $std = (new \App\Storage)->add($request->storage_id, $request->b_label, 'buildings');
            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde angelegt!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function destroyBuildingAjax(Request $request)
    : RedirectResponse
    {
        $building = Building::find($request->id)->first();

        $name = $building->b_name;
        $storage_id = $building->storage_id;

        $stnd = Storage::where('storage_uid', $storage_id)->first();
        $stnd->delete();

        Building::destroy($request->id);
        $request->session()->flash('status', 'Das Gebäude <strong>' . $name . '</strong> wurde gelöscht!');
        return redirect()->back();

    }

    public function getRoomListInBuilding(Request $request)
    {
        $data['select'] = '
            <option value="void">' . __('Bitte Gebäude auswählen') . '</option>';

        $data['radio'] = '';
        if ($request->id !== 'void') {
            if (Room::where('building_id', $request->id)->count() > 0) {
                $n = 0;
                foreach (Room::where('building_id', $request->id)->get() as $room) {
                    $data['select'] .= '
<option value="' . $room->id . '">[' . $room->RoomType->rt_label . '] ' . $room->r_label . ' / ' . $room->r_name . '</option>
';
                    $data['radio'] .= '
                <label class="btn btn-outline-primary"
                       style="border-radius: 0!important; margin-top: 5px !important;"
                >
                    <input type="radio"
                           name="radio_set_room_id"
                           id="room_list_item_' . $room->id . '"
                           class="radio_set_room_id"
                           value="' . $room->id . '"
                    >[' . $room->RoomType->rt_label . '] ' . $room->r_label . ' / ' . $room->r_name . '
                </label>
                ';

                    $n++;
                }
                $data['msg'] = $n . ' ' . __('Räume im Gebäude vorhanden');
            } else {
                $data['select'] .= '
<option value="void">' . __('Keine Räume im Gebäude vorhanden') . '</option>
';
                $data['msg'] = __('Keine Räume im Gebäude vorhanden');
            }
        } else {
            $data['select'] .= '
<option value="void">' . __('Bitte Gebäude auswählen') . '</option>
';
            $data['msg'] = __('Bitte Gebäude auswählen');
        }
        return $data;
    }

    public function getObjectsInBuilding(Request $request)
    {
        $data['html'] = '
<p class="mt-3">' . __('Folgende Objekte werden von der Lösung betroffen sein.') . '</p>
<ul class="list-group">';
        $building = Building::find($request->id);
        $countRooms = $building->rooms->count();
        $countEquipment = $building->countTotalEquipmentInBuilding() ?? 0;
        $countCompartment = $building->countStellPlatzs($building);

        $bgRooms = $countRooms > 0 ? 'list-group-item-danger' : '';
        $bgEquipment = $countEquipment > 0 ? 'list-group-item-danger' : '';
        $bgCompartments = $countCompartment > 0 ? 'list-group-item-danger' : '';

        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center ' . $bgRooms . ' ">' . __('Räume') . '<span class="badge badge-primary badge-pill">' . $countRooms . '</span></li>';
        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center ' . $bgCompartments . ' ">' . __('Stellplätze') . '<span class="badge badge-primary badge-pill">' . $countCompartment . '</span></li>';
        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center ' . $bgEquipment . ' ">' . __('Geräte') . '<span class="badge badge-primary badge-pill">' . $countEquipment . '</span></li>';

        return $data;
    }

    public function getBuildingListeAsTable()
    {
        $html = '<div class="col">
<table class="table table-responsive-md table-sm table-striped">
    <thead>
    <tr>
    <th>Standort</th>
    <th>Nummer</th>
    <th>Name</th>
    <th>Gebäudetyp</th>
    <th></th>
</tr>
</thead>
<tbody>
        ';

        foreach (Building::with('BuildingType')->get() as $building) {
            $html .= '
            <tr>
            <td><a href="/location/' . $building->location->id . '">' . $building->location->l_label . '</a></td>
            <td>' . $building->b_label . '</td>
            <td>' . $building->b_name . '</td>
            <td>' . $building->BuildingType->btname . '</td>
            <td>
                <a href="' . $building->path() . '">
                    <i class="fas fa-chalkboard"></i>
                    <span class="d-none d-md-table-cell">' . __('Übersicht') . '</span>
                </a>
            </td>
            </tr>';
        }
        $html .= '</tbody></table></div>';

        return ['html' => $html];
    }

    public function getBuildingListeAsKachel()
    {
        $html = '';
        foreach (Building::with('BuildingType')->get() as $building) {
            $html .= '<div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="geb_id_{{$building->id}}">
                        <div class="card">
                            <div class="card-header">
                                Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/' . $building->location->id . '">' . $building->location->l_label . '</a>
                            </div>
                                <div class="card-body" style="height:18em;">
                                    <h5 class="card-title">' . $building->BuildingType->btname . ': ' . $building->b_label . '</h5>
                                    <h6 class="card-subtitletext-muted">' . $building->b_name . '</h6>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Ort:</strong><span class="ml-2" >' . $building->b_name_ort . '</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Räume:</strong><span class="ml-2" >' . $building->rooms()->count() . '</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Stellplätze:</strong><span class="ml-2" >' . $building->countStellPlatzs($building) . '</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                    <p class="mt-0" style="height:6em;">
                                        ' . str_limit($building->b_description, 100) . '
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="' . $building->path() . '" class="card-link mr-auto"><i class="fas fa-chalkboard"></i> Übersicht</a>
                                </div>
                        </div>
                    </div>';
        }
        //echo $html;
        return ['html' => $html];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'b_we_name.required_if' => 'custom-message',
            'body.required'         => 'A message is required',
        ];
    }
}
