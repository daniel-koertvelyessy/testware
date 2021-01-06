<?php

namespace App\Http\Controllers;

use App\AddressType;
use App\Adresse;
use App\AnforderungControlItem;
use App\Location;
use App\Building;
use App\LocationAnforderung;
use App\Profile;
use App\Room;
use App\Standort;
use App\Stellplatz;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;


class LocationsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function explorer(Request $request, Location $location) {
        if (Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie Ihren ersten Standort!');
            return redirect()->route('location.create');
        } else {
            if (isset($request->location))
                $location = Location::find($request->location);
            return view('admin.standorte.explorer', ['location' => $location]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index() {
        if (Location::all()->count() === 0) {
            session()->flash('status', '<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie Ihren ersten Standort!');
            return redirect()->route('location.create');
        }

        if (Location::all()->count() > 6) {
            $locationList = Location::all()->sortable()->paginate(10);
            return view('admin.standorte.location.index', ['locationList' => $locationList]);
        } else {
            return view('admin.standorte.location.index');
        }
    }


    public function search() {
        return view('search');
    }

    public function autocomplete(Request $request) {
        $search = $request->input('query');
        $locresults = Location::select("id", "l_name_kurz", 'l_name_lang')
            ->where('l_name_kurz', 'LIKE', "%$search%")
            ->orWhere('l_name_lang', 'LIKE', "%$search%")
            ->orWhere('l_beschreibung', 'LIKE', "%$search%")
            ->get();

        return response()->json($locresults);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create() {
        return view('admin.standorte.location.create');
    }

    /**
     * Speichere neuen Standort
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request) {

        if ($request->adresse_id === NULL) {

            $a = $this->validateInitialAdresse();
            $adresse = new Adresse();
            $adresse->ad_name_kurz = $request->ad_name_kurz;
            $adresse->ad_anschrift_strasse = $request->ad_anschrift_strasse;
            $adresse->ad_anschrift_plz = $request->ad_anschrift_plz;
            $adresse->ad_anschrift_ort = $request->ad_anschrift_ort;
            $adresse->save();
            $request->adresse_id = $adresse->id;
        }

        if ($request->profile_id === NULL) {
            $p = $this->validateInitialProfile();
            $profile = new Profile();
            $profile->ma_name = $request->ma_name;
            $profile->ma_vorname = $request->ma_vorname;
            $profile->user_id = $request->user_id;
            $profile->save();
            $request->profile_id = $profile->id;
        }


        $location = new Location();
        $location->l_benutzt = $request->l_benutzt;
        $location->l_name_kurz = $request->l_name_kurz;
        $location->l_name_lang = $request->l_name_lang;
        $location->l_beschreibung = $request->l_beschreibung;
        $location->profile_id = $request->profile_id;
        $location->adresse_id = $request->adresse_id;
        $location->standort_id = $request->standort_id;
        $location->save();


//        Location::create($this->validateNewLocation());


        $request->session()->flash('status', 'Der Standort <strong>' . request('l_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('location.show', ['location' => $location]));
    }

    /**
     * @return array
     */
    public
    function validateInitialAdresse()
    : array {
        return request()->validate([
            'ad_name_kurz'         => 'bail|max:20|required|unique:adresses,ad_name_kurz',
            'ad_anschrift_strasse' => 'required',
            'ad_anschrift_plz'     => 'required',
            'ad_anschrift_ort'     => 'required'
        ]);
    }

    /**
     * @return array
     */
    public
    function validateInitialProfile()
    : array {
        return request()->validate([
            'ma_name'    => 'bail|max:20|required|unique:profiles,ma_name',
            'ma_vorname' => 'max:100',
            'user_id'    => '',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Location $location
     * @return Application|Factory|Response|View
     */
    public function show(Location $location) {
        return view('admin.standorte.location.show', ['location' => $location]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Application|Factory|View
     */
    public function edit(location $location) {

        return view('admin.standorte.location.edit', compact('location'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Location $location
     * @return Response
     */
    public function update(Request $request, Location $location) {
        $location->update($this->validateLocation());

        $request->session()->flash('status', 'Der Standort <strong>' . $location->l_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($location->path());
    }

    /**
     * @return array
     */
    public
    function validateLocation()
    : array {
        return request()->validate([
            'standort_id'    => '',
            'l_name_kurz'    => 'bail|min:2|max:20|required',
            'l_name_lang'    => '',
            'l_beschreibung' => '',
            'adresse_id'     => 'required',
            'profile_id'     => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyLocationAjax(Request $request) {
        $rname = request('l_name_kurz');
        if (Location::destroy($request->id)) {

            $request->session()->flash('status', 'Der Standort <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    public function getLocationListeAsTable() {
        $html = '
<table class="table table-sm table-striped">
    <thead>
    <tr>
    <th>'.__('Standort').'</th>
    <th>'.__('Name').'</th>
    <th>'.__('Gebäude').'</th>
    <th>'.__('Geräte').'</th>
</tr>
</thead>
<tbody>
        ';

        foreach (Location::all() as $location) {
            $html .= '
            <tr>
                <td><a href="/location/' . $location->id . '">' . $location->l_name_kurz . '</a></td>
                <td>' . $location->l_name_lang . '</td>
                <td>' . $location->Building->count() . '</td>
                <td>' . $location->countTotalEquipmentInLocation(). '</td>
            </tr>';
        }
        $html .= '</tbody>
</table>';

//        echo $html;
        return ['html' => $html];

    }

    public function getLocationListeAsKachel() {
        $html = '';
        foreach (Location::all() as $location) {
            $html .= ' <div class="col-lg-4 col-md-6 locationListItem mb-lg-4 mb-sm-2 " id="loc_id_' . $location->id . '">
                    <div class="card" style="height:20em;">
                        <div class="card-body">
                            <h5 class="card-title">' . $location->l_name_kurz . '</h5>
                            <h6 class="card-subtitletext-muted">' . $location->l_name_lang . '</h6>
                            <p class="card-text mt-1 mb-0"><small><strong>'.__('Gebäude').':</strong> ' . $location->Building->count() . '</small></p>
                            <p class="card-text mt-1 mb-0"><small><strong>'.__('Geräte').':</strong> '. $location->countTotalEquipmentInLocation() .'</small></p>
                            <p class="card-text mt-1 mb-0"><small><strong>'.__('Beschreibung').':</strong></small></p>
                            <p class="mt-0" style="height:6em;overflow-y: scroll">' . $location->l_beschreibung . '</p>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <a href="' . $location->path() . '" class="btn btn-link btn-sm mr-auto"><i class="fas fa-chalkboard"></i> '.__('Übersicht').'</a>
                        </div>
                    </div>
                    </div>';
        }
//echo $html;
        return ['html' => $html];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Location $location
     * @return RedirectResponse
     */
    public function addLocationAnforderung(Request $request, location $location) {


        LocationAnforderung::create($this->validateLocationAnforderung());

//
//        if (AnforderungsController::getACI($request->anforderung_id)>0){
//
//        }


        $request->session()->flash('status', 'Die Anforderung <strong>' . $request->an_name_kurz . '</strong> wurde dem Standort angefügt!');


        return redirect()->back();

    }

    /**
     * @return array
     */
    public
    function validateLocationAnforderung()
    : array {
        return request()->validate([
            'anforderung_id' => 'required',
            'location_id'    => 'required',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Application|Factory|View
     */
    public function deleteLocationAnforderung(Request $request, location $location) {


    }

    public function getLocationTree(Request $request) {

        $location = Location::find($request->id);
        $room = [];
        $data = [
            'text' => $location->l_name_kurz,
            'href' => $location->id,
            'tags' => [__('Gebäude'), Building::where('location_id', $location->id)->count()],

        ];
        if (Building::where('location_id', $location->id)->count() > 0) {
            foreach (Building::where('location_id', $location->id)->get() as $building) {
                if (Room::where('building_id', $building->id)->count() > 0) {
                    foreach (Room::where('building_id', $building->id)->get() as $room) {
                        if (Stellplatz::where('room_id', $room->id)->count() > 0) {
                            foreach (Stellplatz::where('room_id', $room->id)->get() as $stellplatz) {
                                $spl[] = [
                                    'type' => 'stellplatz',
                                    'text' => 'Stellplatz ' . $stellplatz->sp_name_kurz,
                                    'href' => $stellplatz->id,
                                ];
                            }

                            $rm[] = [
                                'text'  => 'Raum ' . $room->r_name_kurz,
                                'href'  => $room->id,
                                'type'  => 'room',
                                'tags'  => [__('Stellplätze'), Stellplatz::where('room_id', $room->id)->count()],
                                'state' => [
                                    'expanded' => false,
                                    'selected' => false
                                ],
                                'nodes' => $spl
                            ];

                        } else {
                            $rm[] = [
                                'text'  => 'Raum ' . $room->r_name_kurz,
                                'href'  => $room->id,
                                'type'  => 'room',
                                'tags'  => [__('Stellplätze'), Stellplatz::where('room_id', $room->id)->count()],
                                'state' => [
                                    'expanded' => false,
                                    'selected' => false
                                ]
                            ];
                        }


                    }
                    $data['nodes'][] = [
                        'text'  => 'Gebäude ' . $building->b_name_kurz,
                        'href'  => $building->id,
                        'type'  => 'building',
                        'tags'  => [__('Räume'), Room::where('building_id', $building->id)->count()],
                        'state' => [
                            'expanded' => false,
                            'selected' => false
                        ],
                        'nodes' => $rm
                    ];
                } else {
                    $data['nodes'][] = [
                        'text'  => 'Gebäude ' . $building->b_name_kurz,
                        'href'  => $building->id,
                        'type'  => 'building',
                        'tags'  => [__('Räume'), Room::where('building_id', $building->id)->count()],
                        'state' => [
                            'expanded' => false,
                            'selected' => false
                        ]
                    ];
                }


            }
        }
        return $data;
    }

    public function getBuildingListInLocation(Request $request) {
        $data['html'] = '';
        if ($request->id !== 'void') {
            foreach (Building::where('location_id', $request->id)->get() as $building) {
                $data['html'] .= '
        <option value="' . $building->id . '">[' . $building->BuildingType->btname . '] ' . $building->b_name_kurz . ' / ' . $building->b_name_lang . '</option>
';
            }
        } else {
            $data['html'] .= '
        <option value="void">Bitte Stellplatz auswählen</option>
';
        }
        return $data;
    }

    /**
     * @return array
     */
    public
    function validateNewLocation()
    : array {
        return request()->validate([
            'l_name_kurz'    => 'bail|unique:locations,l_name_kurz|min:2|max:20|required',
            'l_name_lang'    => '',
            'l_beschreibung' => '',
            'standort_id'    => 'unique:locations,standort_id',
            'adresse_id'     => 'required',
            'profile_id'     => 'required'
        ]);
    }
}
