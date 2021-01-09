<?php

namespace App\Http\Controllers;

use App\Building;
use App\BuildingTypes;
use App\Location;
use App\Room;
use App\Standort;
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
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->b_we_has = $request->has('b_we_has') ? 1 : 0;

        $building = Building::create($this->validateNewBuilding());

        $std = (new \App\Standort)->add($request->standort_id, $request->b_label, 'buildings');

        $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewBuilding(): array
    {
        return request()->validate([
            'b_label'      => 'bail|required|unique:buildings,b_label|min:2|max:20',
            'b_name_ort'       => '',
            'b_name'      => '',
            'b_name_text'      => '',
            'b_we_has'         => '',
            'standort_id'      => '',
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
            $copy->b_name_text = $bul->b_name_text;
            $copy->b_we_has = $bul->b_we_has;
            $copy->b_we_name = $bul->b_we_name;
            $copy->location_id = $bul->location_id;
            $copy->building_type_id = $bul->building_type_id;
            $copy->standort_id = Str::uuid();
            //            $copy->
            $validator = Validator::make([
                $copy->b_label,
                $copy->b_name_ort,
                $copy->b_name,
                $copy->b_name_text,
                $copy->b_we_has,
                $copy->b_we_name,
                $copy->location_id,
                $copy->building_type_id,
                $copy->standort_id,

            ], [
                'b_label'      => 'bail|required|unique:buildings,b_label|min:2|max:10',
                'b_name_ort'       => '',
                'b_name'      => '',
                'b_name_text'      => '',
                'b_we_has'         => '',
                'b_we_name'        => 'required_if:b_we_has,1',
                'location_id'      => 'required',
                'building_type_id' => 'required',
            ]);
            $copy->save();

            $std = (new \App\Standort)->add($copy->standort_id, $neuname, 'buildings');

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
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Building $building)
    {

        if ($building->b_label !== $request->b_label) {
            $standort = Standort::where('std_id', $request->standort_id)->first();
            $standort->std_kurzel = $request->b_label;
            $standort->save();
        }
        $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
        $building->update($this->validateBuilding());

        $request->session()->flash('status', 'Das Gebäude <strong>' . $building->b_label . '</strong> wurde aktualisiert!');
        return redirect($building->path());
    }

    /**
     * @return array
     */
    public function validateBuilding(): array
    {
        return request()->validate([
            'b_label'      => 'bail|required|min:2|max:20',
            'b_name_ort'       => '',
            'b_name'      => '',
            'b_name_text'      => '',
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
                $standort = Standort::where('std_id', $request->standort_id)->first();
                $standort->std_kurzel = $request->b_label;
                $standort->save();
            }
            $buildingOld->update($this->validateBuilding());
            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde aktualisiert!');
        } else {

            $this->validateNewBuilding();
            $building = new Building(); //::create();
            $building->b_label = $request->b_label;
            $building->b_name_ort = $request->b_name_ort;
            $building->b_name = $request->b_name;
            $building->b_name_text = $request->b_name_text;
            $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
            $building->standort_id = $request->standort_id;
            $building->b_we_name = $request->b_we_name;
            $building->location_id = $request->location_id;
            $building->building_type_id = $request->building_type_id;
            $building->save();

            $std = (new \App\Standort)->add($request->standort_id, $request->b_label, 'buildings');
            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_label') . '</strong> wurde angelegt!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyBuildingAjax(Request $request)
    {

        $rm = Building::find($request->id)->standort_id;
        $stnd = Standort::where('std_id', $rm)->first();

        $stnd->delete();
        $rname = Building::find($request->id)->first()->b_name;
        if (Building::destroy($request->id)) {

            $request->session()->flash('status', 'Das Gebäude <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function getRoomListInBuilding(Request $request)
    {
        $data['html'] = '';
        if ($request->id !== 'void') {
            if (Room::where('building_id', $request->id)->count() > 0) {
                foreach (Room::where('building_id', $request->id)->get() as $room) {
                    $data['html'] .= '
<option value="' . $room->id . '">[' . $room->RoomType->rt_label . '] ' . $room->r_label . ' / ' . $room->r_name . '</option>
';
                }
            } else {
                $data['html'] .= '
<option value="void">Keine Räume im Gebäude vorhanden</option>
';
            }
        } else {
            $data['html'] .= '
<option value="void">Bitte Gebäude auswählen</option>
';
        }
        return $data;
    }

    public function getBuildingListeAsTable()
    {
        $html = '<div class="col">
<table class="table table-sm table-striped">
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
                                        ' . str_limit($building->b_name_text, 100) . '
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
