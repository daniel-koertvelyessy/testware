<?php

namespace App\Http\Controllers;

use App\AddressType;
use App\Adresse;
use App\AnforderungControlItem;
use App\Location;
use App\Building;
use App\LocationAnforderung;
use App\Profile;
use App\Standort;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;


class LocationsController extends Controller
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

        return view('admin.standorte.location.index');


    }


    public function search()
    {
        return view('search');
    }

    public function autocomplete(Request $request)
    {
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
    public function create()
    {
        return view('admin.standorte.location.create');
    }

    /**
     * Speichere neuen Standort
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {

        if ($request->adresse_id === NULL){

            $a = $this->validateInitialAdresse();
            $adresse = new Adresse();
            $adresse->ad_name_kurz = $request->ad_name_kurz;
            $adresse->ad_anschrift_strasse = $request->ad_anschrift_strasse;
            $adresse->ad_anschrift_plz = $request->ad_anschrift_plz;
            $adresse->ad_anschrift_ort = $request->ad_anschrift_ort;
            $adresse->save();
            $request->adresse_id = $adresse->id;
        }

        if ($request->profile_id === NULL){
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
     * Display the specified resource.
     *
     * @param Location $location
     * @return Application|Factory|Response|View
     */
    public function show(Location $location)
    {
        return view('admin.standorte.location.show', ['location' => $location]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Application|Factory|View
     */
    public function edit(location $location)
    {

        return view('admin.standorte.location.edit', compact('location'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Location $location
     * @return Response
     */
    public function update(Request $request, Location $location)
    {
        $location->update($this->validateLocation());

        $request->session()->flash('status', 'Der Standort <strong>' . $location->l_name_kurz . '</strong> wurde aktualisiert!');
        return redirect($location->path());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return bool
     */
    public function destroyLocationAjax(Request $request)
    {
        $rname = request('l_name_kurz');
        if ( Location::destroy($request->id) ){

            $request->session()->flash('status', 'Der Standort <strong>' . $rname . '</strong> wurde gelöscht!');
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Location $location
     * @return RedirectResponse
     */
    public function addLocationAnforderung(Request $request,location $location)
    {


        LocationAnforderung::create($this->validateLocationAnforderung());

//
//        if (AnforderungsController::getACI($request->anforderung_id)>0){
//
//        }


        $request->session()->flash('status', 'Die Anforderung <strong>' . $request->an_name_kurz . '</strong> wurde dem Standort angefügt!');




        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Application|Factory|View
     */
    public function deleteLocationAnforderung(Request $request,location $location)
    {



    }

    /**
     * @return array
     */
    public function validateLocation(): array
    {
        return request()->validate([
            'standort_id' => '',
            'l_name_kurz' => 'bail|min:2|max:20|required',
            'l_name_lang' => '',
            'l_beschreibung' => '',
            'adresse_id' => 'required',
            'profile_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateInitialAdresse(): array
    {
        return request()->validate([
            'ad_name_kurz' => 'bail|max:20|required|unique:adresses,ad_name_kurz',
            'ad_anschrift_strasse' => 'required',
            'ad_anschrift_plz' => 'required',
            'ad_anschrift_ort' => 'required'
        ]);
    }
    /**
     * @return array
     */
    public function validateLocationAnforderung(): array
    {
        return request()->validate([
            'anforderung_id' => 'required',
            'location_id' => 'required',
        ]);
    }

    /**
     * @return array
     */
    public function validateInitialProfile(): array
    {
        return request()->validate([
            'ma_name' => 'bail|max:20|required|unique:profiles,ma_name',
            'ma_vorname' => 'max:100',
            'user_id' => '',
        ]);
    }



    /**
     * @return array
     */
    public function validateNewLocation(): array
    {
        return request()->validate([
            'l_name_kurz' => 'bail|unique:locations,l_name_kurz|min:2|max:20|required',
            'l_name_lang' => '',
            'l_beschreibung' => '',
            'standort_id' => 'unique:locations,standort_id',
            'adresse_id' => 'required',
            'profile_id' => 'required'
        ]);
    }
}
