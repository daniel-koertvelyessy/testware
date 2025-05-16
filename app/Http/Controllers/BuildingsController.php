<?php

namespace App\Http\Controllers;

use App\Building;
use App\BuildingTypes;
use App\Location;
use App\Room;
use App\Storage;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
        $this->checkLocation();
        if (Building::all()->count() === 0 && Auth::user()->isAdmin()) {
            return redirect()->route('building.create');
        } else {
            return view('admin.standorte.building.index', ['buildingList' => Building::with('BuildingType')->sortable()->paginate(10)]);
        }
    }

    protected function checkLocation()
    {
        if (Location::all()->count() === 0 && Auth::user()->isAdmin()) {
            session()->flash('status', __('<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie erst einen Standort bevor Sie ein Gebäude anlegen können!'));

            return redirect()->route('location.create')->with('status');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkLocation();

        return view('admin.standorte.building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //    $this->authorize('isAdmin', Auth()->user());
        $addBuilding = (new Building)->addNew($request);
        ($addBuilding)
            ? $request->session()->flash('status', __('Das Gebäude <strong>:label</strong> wurde angelegt!', ['label' => request('b_label')]))
            : $request->session()->flash('status', __('Fehler beim Anlegen des Gebäudes :label!', ['label' => request('b_label')]));

        return back();
    }

    public function getBuildingList($id)
    {
        return Building::where('location_id', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Application|Factory|Response|View
     */
    public function show(Building $building)
    {
        $this->checkLocation();

        return view('admin.standorte.building.show', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return Application|Factory|View
     */
    public function edit(building $building)
    {
        //    $this->authorize('isAdmin', Auth()->user());
        return view('admin.standorte.building.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Building $building)
    {
        //   $this->authorize('isAdmin', Auth()->user());
        (new Storage)->checkUpdate($request->storage_id, $request->b_label);
        $building->b_we_has = $request->has('b_we_has')
            ? 1
            : 0;
        $building->update($this->validateBuilding());
        $request->session()->flash('status', __('Das Gebäude <strong>:label</strong> wurde aktualisiert!', ['label' => $building->b_label]));

        return redirect($building->path());
    }

    public function validateBuilding(): array
    {
        return request()->validate([
            'b_label' => [
                'bail',
                'min:2',
                'max:20',
                'required',
                Rule::unique('buildings')->ignore(\request('id')),
            ],
            'b_name_ort' => '',
            'b_name' => '',
            'b_description' => '',
            'b_we_has' => '',
            'storage_id' => '',
            'b_we_name' => 'required_if:b_we_has,1',
            'location_id' => 'required',
            'building_type_id' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, Building $building)
    {
        //    $this->authorize('isAdmin', Auth()->user());
        $request->session()->flash('status', __('Das Gebäude <strong>:label</strong> wurde gelöscht!', ['label' => $building->b_name]));
        $building->delete();

        return redirect()->back();
    }

    public function getBuildingData(Request $request)
    {
        return Building::find($request->id);
    }

    public function modal(Request $request)
    {

        $this->validateBuilding();

        if ($request->building_type_id === 'new' && isset($request->newBuildingType)) {
            $bt = new BuildingTypes;
            $bt->btname = $request->newBuildingType;
            $bt->save();
            $request->building_type_id = $bt->id;
        }

        if ($request->modalType === 'edit') {
            //            dd($request);
            $building = Building::find($request->id);
            if ($building->b_label !== $request->b_label) {
                $storage = Storage::where('storage_uid', $request->storage_id)->first();
                $storage->storage_label = $request->b_label;
                $storage->save();
            }
            $request->session()->flash('status', __('Das Gebäude <strong>:name</strong> wurde aktualisiert!', ['name' => request('b_label')]));
        } else {
            $building = new Building; // ::create();

            $std = (new Storage)->add($request->storage_id, $request->b_label, 'buildings');
            $request->session()->flash('status', __('Das Gebäude <strong>:name</strong> wurde angelegt!', ['name' => request('b_label')]));
        }
        $building->b_label = $request->b_label;
        $building->b_name_ort = $request->b_name_ort;
        $building->b_name = $request->b_name;
        $building->b_description = $request->b_description;
        $building->b_we_has = $request->has('b_we_has')
            ? 1
            : 0;
        $building->storage_id = $request->storage_id;
        $building->b_we_name = $request->b_we_name;
        $building->location_id = $request->location_id;
        $building->building_type_id = $request->building_type_id;
        $building->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyBuildingAjax(Request $request): RedirectResponse
    {
        $building = Building::find($request->id)->first();

        $name = $building->b_name;
        $storage_id = $building->storage_id;

        $stnd = Storage::where('storage_uid', $storage_id)->first();
        $stnd->delete();

        Building::destroy($request->id);
        $request->session()->flash('status', __('Das Gebäude <strong>:name</strong> wurde gelöscht!', ['name' => $name]));

        return redirect()->back();
    }

    public function getRoomListInBuilding(Request $request)
    {
        $data['select'] = '
            <option value="void">'.__('Bitte Gebäude auswählen').'</option>';

        $data['radio'] = '';
        if ($request->id !== 'void') {
            if (Room::with('building')->where('building_id', $request->id)->count() > 0) {
                $n = 0;
                foreach (Room::with('building', 'RoomType')->where('building_id', $request->id)->get() as $room) {
                    $data['select'] .= '
<option value="'.$room->id.'">['.$room->RoomType->rt_label.'] '.$room->r_label.' / '.$room->r_name.'</option>
';
                    $data['radio'] .= '
                <label class="btn btn-outline-primary"
                       style="border-radius: 0!important; margin-top: 5px !important;"
                       id="label_room_list_item_'.$room->id.'"
                >
                    <input type="radio"
                           name="radio_set_room_id"
                           id="room_list_item_'.$room->id.'"
                           class="radio_set_room_id"
                           value="'.$room->id.'"
                    >['.$room->RoomType->rt_label.'] '.$room->r_label.' / '.$room->r_name.'
                </label>
                ';

                    $n++;
                }
                $data['msg'] = $n.' '.__('Räume im Gebäude vorhanden');
            } else {
                $data['select'] .= '
<option value="void">'.__('Keine Räume im Gebäude vorhanden').'</option>
';
                $data['msg'] = __('Keine Räume im Gebäude vorhanden');
            }
        } else {
            $data['select'] .= '
<option value="void">'.__('Bitte Gebäude auswählen').'</option>
';
            $data['msg'] = __('Bitte Gebäude auswählen');
        }

        return $data;
    }

    public function getObjectsInBuilding(Request $request)
    {
        $data['html'] = '
<p class="mt-3">'.__('Folgende Objekte werden von der Lösung betroffen sein.').'</p>
<ul class="list-group">';
        $building = Building::find($request->id);
        $countRooms = $building->room->count();
        $countEquipment = $building->countTotalEquipmentInBuilding() ?? 0;
        $countCompartment = $building->countStellPlatzs($building);

        $bgRooms = $countRooms > 0
            ? 'list-group-item-danger'
            : '';
        $bgEquipment = $countEquipment > 0
            ? 'list-group-item-danger'
            : '';
        $bgCompartments = $countCompartment > 0
            ? 'list-group-item-danger'
            : '';

        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center '.$bgRooms.' ">'.__('Räume').'<span class="badge badge-primary badge-pill">'.$countRooms.'</span></li>';
        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center '.$bgCompartments.' ">'.__('Stellplätze').'<span class="badge badge-primary badge-pill">'.$countCompartment.'</span></li>';
        $data['html'] .= '<li class="list-group-item d-flex justify-content-between align-items-center '.$bgEquipment.' ">'.__('Geräte').'<span class="badge badge-primary badge-pill">'.$countEquipment.'</span></li>';

        return $data;
    }

    public function getBuildingListeAsTable()
    {
        $html = '<div class="col">
<table class="table table-responsive-md table-sm table-striped">
    <thead>
    <tr>
    <th>'.__('Standort').'</th>
    <th>'.__('Nummer').'</th>
    <th>'.__('Name').'</th>
    <th>'.__('Gebäudetyp').'</th>
    <th></th>
</tr>
</thead>
<tbody>
        ';

        foreach (Building::with('BuildingType')->get() as $building) {
            $html .= '
            <tr>
            <td><a href="/location/'.$building->location->id.'">'.$building->location->l_label.'</a></td>
            <td>'.$building->b_label.'</td>
            <td>'.$building->b_name.'</td>
            <td>'.$building->BuildingType->btname.'</td>
            <td>
                <a href="'.$building->path().'">
                    <i class="fas fa-chalkboard"></i>
                    <span class="d-none d-md-table-cell">'.__('Übersicht').'</span>
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
                                <a href="/location/'.$building->location->id.'">'.$building->location->l_label.'</a>
                            </div>
                                <div class="card-body" style="height:18em;">
                                    <h5 class="card-title">'.$building->BuildingType->btname.': '.$building->b_label.'</h5>
                                    <h6 class="card-subtitletext-muted">'.$building->b_name.'</h6>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Ort:</strong><span class="ml-2" >'.$building->b_name_ort.'</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Räume:</strong><span class="ml-2" >'.$building->room()->count().'</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0">
                                        <span class="small">
                                            <strong>Stellplätze:</strong><span class="ml-2" >'.$building->countStellPlatzs($building).'</span>
                                        </span>
                                    </p>
                                    <p class="card-text mt-1 mb-0"><small><strong>Beschreibung:</strong></small></p>
                                    <p class="mt-0" style="height:6em;">
                                        '.str_limit($building->b_description, 100).'
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="'.$building->path().'" class="card-link mr-auto"><i class="fas fa-chalkboard"></i> Übersicht</a>
                                </div>
                        </div>
                    </div>';
        }

        // echo $html;
        return ['html' => $html];
    }

    /**
     * Check if a label exists for a building
     *
     * @return bool[]
     */
    public function checkDuplicateLabel(Request $request): array
    {
        $building = Building::where('b_label', $request->term)->first();

        return ($building)
            ? [
                'exists' => true,
            ]
            : [
                'exists' => false,
            ];
    }

    public function copyBuilding(Request $request)
    {
        $building = Building::find($request->id);
        $uid = Str::uuid();
        $storageID = (new Storage)->add(
            $uid,
            'newBuilding',
            'buildings'
        );

        $copyBuilding = $building->replicate()->fill([
            'b_label' => 'newBuilding',
            'storage_id' => $uid,
        ]);

        $copyBuilding->save();
        $request->session()->flash('status', __('Das Gebäude wurde kopiert'));

        return redirect()->route('building.show', $copyBuilding);
    }
}
