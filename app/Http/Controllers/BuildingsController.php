<?php

namespace App\Http\Controllers;

use App\Building;
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

class BuildingsController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {

        if (Building::all()->count() > 6) {
            $buildingList = Building::with('BuildingType')->paginate(10);
            return view('admin.standorte.building.index', ['buildingList' => $buildingList]);
        } else {
            return view('admin.standorte.building.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.standorte.building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request) {
        $request->b_we_has = $request->has('b_we_has') ? 1 : 0;

        $building = Building::create($this->validateNewBuilding());

        $std = (new \App\Standort)->add($request->standort_id, $request->b_name_kurz, 'buildings');

        $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_name_kurz') . '</strong> wurde angelegt!');
        return redirect()->back();

    }

    /**
     * @return array
     */
    public function validateNewBuilding()
    : array {
        return request()->validate([
            'b_name_kurz'      => 'bail|required|unique:buildings,b_name_kurz|min:2|max:10',
            'b_name_ort'       => '',
            'b_name_lang'      => '',
            'b_name_text'      => '',
            'b_we_has'         => '',
            'b_we_name'        => 'required_if:b_we_has,1',
            'location_id'      => 'required',
            'building_type_id' => 'required',
        ]);
    }

    public function copyBuilding(Request $request) {
        if ($request->id) {

            $bul = Building::find($request->id);
            $neuname = '';
            switch (true) {
                case strlen($bul->b_name_kurz) <= 20 && strlen($bul->b_name_kurz) > 14:
                    $neuname = substr($bul->b_name_kurz, 0, 13) . '_1';
                    break;
                case strlen($bul->b_name_kurz) <= 14:
                    $neuname = $bul->b_name_kurz . '_1';
                    break;
            }


            $bul->b_name_kurz = $neuname;
            $copy = new Building();
            $copy->b_name_kurz = $neuname;
            $copy->b_name_ort = $bul->b_name_ort;
            $copy->b_name_lang = $bul->b_name_lang;
            $copy->b_name_text = $bul->b_name_text;
            $copy->b_we_has = $bul->b_we_has;
            $copy->b_we_name = $bul->b_we_name;
            $copy->location_id = $bul->location_id;
            $copy->building_type_id = $bul->building_type_id;
            $copy->standort_id = Str::uuid();
//            $copy->
            $validator = Validator::make([
                $copy->b_name_kurz,
                $copy->b_name_ort,
                $copy->b_name_lang,
                $copy->b_name_text,
                $copy->b_we_has,
                $copy->b_we_name,
                $copy->location_id,
                $copy->building_type_id,
                $copy->standort_id,

            ], [
                'b_name_kurz'      => 'bail|required|unique:buildings,b_name_kurz|min:2|max:10',
                'b_name_ort'       => '',
                'b_name_lang'      => '',
                'b_name_text'      => '',
                'b_we_has'         => '',
                'b_we_name'        => 'required_if:b_we_has,1',
                'location_id'      => 'required',
                'building_type_id' => 'required',
            ]);
            $copy->save();

            $std = (new \App\Standort)->add($copy->standort_id, $neuname, 'buildings');

            $request->session()->flash('status', 'Das Gebäude <strong>' . request('b_name_kurz') . '</strong> wurde kopiert!');
            return redirect()->back();
        } else {
            $request->session()->flash('status', '<p>Fehler!</p>Das Gebäude <strong>' . request('b_name_kurz') . '</strong> konnte nicht kopiert werden!');
            return redirect()->back();
        }
    }

    public function getBuildingList($id) {
        return DB::table('buildings')->where('location_id', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  Building $building
     * @return Application|Factory|Response|View
     */
    public function show(Building $building) {
        return view('admin.standorte.building.show', ['building' => $building]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Building $building
     * @return Application|Factory|View
     */
    public function edit(building $building) {
        return view('admin.standorte.building.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Building $building
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Building $building) {
        $building->b_we_has = $request->has('b_we_has') ? 1 : 0;
        $building->update($this->validateBuilding());

        $request->session()->flash('status', 'Das Gebäude <strong>' . $building->b_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($building->path());
    }

    /**
     * @return array
     */
    public function validateBuilding()
    : array {
        return request()->validate([
            'b_name_kurz'      => 'bail|required|min:2|max:10',
            'b_name_ort'       => '',
            'b_name_lang'      => '',
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
     */
    public function destroy(Request $request, Building $building) {


        $rname = request('b_name_kurz');
        $building->delete();
        $request->session()->flash('status', 'Das Gebäude <strong>' . $rname . '</strong> wurde gelöscht!');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyBuildingAjax(Request $request) {
        $rname = request('b_name_lang');
        if (Building::destroy($request->id)) {

            $request->session()->flash('status', 'Das Gebäude <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function getBuildingListeAsTable() {
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
            <td><a href="/location/' . $building->location->id . '">' . $building->location->l_name_kurz . '</a></td>
            <td>' . $building->b_name_kurz . '</td>
            <td>' . $building->b_name_lang . '</td>
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

    public function getBuildingListeAsKachel() {
        $html = '';
        foreach (Building::with('BuildingType')->get() as $building) {
            $html .= '<div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="geb_id_{{$building->id}}">
                        <div class="card">
                            <div class="card-header">
                                Befindet sich in <i class="fas fa-angle-right text-muted"></i>
                                <a href="/location/' . $building->location->id . '">' . $building->location->l_name_kurz . '</a>
                            </div>
                                <div class="card-body" style="height:18em;">
                                    <h5 class="card-title">' . $building->BuildingType->btname . ': ' . $building->b_name_kurz . '</h5>
                                    <h6 class="card-subtitletext-muted">' . $building->b_name_lang . '</h6>
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
    public function messages() {
        return [
            'b_we_name.required_if' => 'custom-message',
            'body.required'         => 'A message is required',
        ];
    }
}
