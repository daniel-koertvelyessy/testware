<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Building;
use App\Location;
use App\Profile;
use App\Room;
use App\Stellplatz;
use App\Storage;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class LocationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function explorer(Request $request, Location $location)
    {

        if (Location::all()->count() === 0 && Auth::user()->isAdmin()) {
            session()->flash('status', __('<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie Ihren ersten Standort!'));
            return redirect()->route('location.create');
        }
        if (Auth::user()->isAdmin()) {
            if (isset($request->location)) $location = Location::find($request->location);
            return view('admin.standorte.explorer', compact('location'));
        } else {
            return redirect(route('storageMain'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {


        if (Location::all()->count() === 0 && Auth::user()->isAdmin()) {
            session()->flash('status', __('<span class="lead">Es existieren noch keine Standorte!</span> <br>Erstellen Sie Ihren ersten Standort!'));
            return redirect()->route('location.create');
        }

        $locationList = Location::with('Adresse', 'Profile')->sortable()->paginate(10);
        return view('admin.standorte.location.index', compact('locationList'));
    }

    public function search()
    {
        return view('search');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query');
        $locresults = Location::select("id", "l_label", 'l_name')->where('l_label', 'LIKE', "%$search%")->orWhere('l_name', 'LIKE', "%$search%")->orWhere('l_beschreibung', 'LIKE', "%$search%")->get();

        return response()->json($locresults);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.standorte.location.create');
    }

    /**
     * Speichere neuen Standort
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        //   $this->authorize('isAdmin', Auth()->user());
        $this->validateLocation();
        $adresse_id = $request->adresse_id ?? (new Adresse)->addNew($request);
        $profile_id = $request->profile_id ?? (new Profile)->addNew($request);
        (new Storage)->add($request->storage_id, $request->l_label, 'locations');

        if (isset($request->id)) {
            $location = Location::find($request->id);
            $this->update($request, $location);
            $request->session()->flash('status', __('Der Standort <strong>:label</strong> wurde angelegt!', ['label' => $request->l_label]));
        } else {
            $location = (new Location())->add($request, $adresse_id, $profile_id);
            $request->session()->flash('status', __('Der Standort <strong>:label</strong> wurde aktualisiert!', ['label' => $request->l_label]));
        }

        if (isset($request->continueExplorer)) {
            return redirect(route('lexplorer'));
        } else {
            return redirect(route('location.show', compact('location')));
        }
    }

    /**
     * @return array
     */
    public function validateLocation(): array
    {
        return request()->validate([
            'storage_id'     => '',
            'l_label'        => [
                'bail',
                'min:2',
                'max:20',
                'required',
                Rule::unique('locations')->ignore(\request('id'))
            ],
            'l_name'         => '',
            'l_beschreibung' => '',
            'adresse_id'     => 'required',
            'profile_id'     => 'required'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  Location $location
     *
     * @return Application|Factory|Response|View
     */
    public function show(Location $location)
    {
        $buildings = $location->Building()->paginate(10);
        return view('admin.standorte.location.show', compact('location'), compact('buildings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     *
     * @return Application|Factory|View
     */
    public function edit(location $location)
    {
        return view('admin.standorte.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Location $location
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Location $location)
    {
        $location->update($this->validateLocation());
        $request->session()->flash('status', __('Der Standort <strong>:label</strong> wurde aktualisiert!', ['label' => $location->l_label]));
        return redirect($location->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return bool
     */
    public function destroyLocationAjax(Request $request): bool
    {
        if (Location::destroy($request->id)) {
            $request->session()->flash('status', __('Der Standort <strong>:label</strong> wurde gelöscht!', ['label' => request('l_label')]));
            return true;
        } else {
            return false;
        }
    }

    public function getLocationListeAsTable(): array
    {
        return ['html' => view('components.locations_table', ['locations' => Location::sortable()->paginate(10)])->render()];
    }

    public function getLocationListeAsKachel(): array
    {
        $html = '';
        foreach (Location::all() as $location) {
            $html .= view('components.object_tile', ['object' => $location])->render();
        }

        return ['html' => $html];
    }

    public function getLocationTree(Request $request)
    {

        $location = Location::find($request->id);
        $room = [];
        $data = [
            'text' => $location->l_label,
            'href' => $location->id,
            'tags' => [
                __('Gebäude'),
                Building::where('location_id', $location->id)->count()
            ],

        ];
        if (Building::where('location_id', $location->id)->count() > 0) {
            foreach (Building::where('location_id', $location->id)->get() as $building) {
                if (Room::where('building_id', $building->id)->count() > 0) {
                    foreach (Room::where('building_id', $building->id)->get() as $room) {
                        if (Stellplatz::where('room_id', $room->id)->count() > 0) {
                            foreach (Stellplatz::where('room_id', $room->id)->get() as $stellplatz) {
                                $spl[] = [
                                    'type' => 'stellplatz',
                                    'text' => 'Stellplatz ' . $stellplatz->sp_label,
                                    'href' => $stellplatz->id,
                                ];
                            }

                            $rm[] = [
                                'text'  => 'Raum ' . $room->r_label,
                                'href'  => $room->id,
                                'type'  => 'room',
                                'tags'  => [
                                    __('Stellplätze'),
                                    Stellplatz::where('room_id', $room->id)->count()
                                ],
                                'state' => [
                                    'expanded' => false,
                                    'selected' => false
                                ],
                                'nodes' => $spl
                            ];
                        } else {
                            $rm[] = [
                                'text'  => 'Raum ' . $room->r_label,
                                'href'  => $room->id,
                                'type'  => 'room',
                                'tags'  => [
                                    __('Stellplätze'),
                                    Stellplatz::where('room_id', $room->id)->count()
                                ],
                                'state' => [
                                    'expanded' => false,
                                    'selected' => false
                                ]
                            ];
                        }
                    }
                    $data['nodes'][] = [
                        'text'  => 'Gebäude ' . $building->b_label,
                        'href'  => $building->id,
                        'type'  => 'building',
                        'tags'  => [
                            __('Räume'),
                            Room::where('building_id', $building->id)->count()
                        ],
                        'state' => [
                            'expanded' => false,
                            'selected' => false
                        ],
                        'nodes' => $rm
                    ];
                } else {
                    $data['nodes'][] = [
                        'text'  => 'Gebäude ' . $building->b_label,
                        'href'  => $building->id,
                        'type'  => 'building',
                        'tags'  => [
                            __('Räume'),
                            Room::where('building_id', $building->id)->count()
                        ],
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

    public function getBuildingListInLocation(Request $request)
    {
        $n = 0;
        $data['select'] = '<option value="void">' . __('Bitte Gebäude auswählen') . '</option>';
        $data['radio'] = '';
        if ($request->id !== 'void') {
            foreach (Building::where('location_id', $request->id)->get() as $building) {
                $data['select'] .= '<option value="' . $building->id . '">[' . $building->BuildingType->btname . '] ' . $building->b_label . ' / ' . $building->b_name . '</option>';
                $data['radio'] .= '
                <label class="btn btn-outline-primary"
                       style="border-radius: 0!important; margin-top: 5px !important;"
                       id="label_building_list_item_' . $building->id . '"
                >
                    <input type="radio"
                           name="radio_set_building_id"
                           id="building_list_item_' . $building->id . '"
                           class="radio_set_building_id"
                           value="' . $building->id . '"
                    >[' . $building->BuildingType->btname . '] ' . $building->b_label . ' / ' . $building->b_name . ' </label>';
                $n++;
            }
            $data['msg'] = $n . ' ' . __('Gebäude zur Auswahl gefunden');
        } else {
            $data['select'] .= '<option value="void">' . __('Bitte Stellplatz auswählen') . '</option>';
            $data['radio'] .= '<label class="btn btn-outline-primary">' . __('Bitte Stellplatz auswählen') . '</label>';
            $data['msg'] = $n . ' ' . __('Gebäude zur Auswahl gefunden');
        }

        return $data;
    }
}
