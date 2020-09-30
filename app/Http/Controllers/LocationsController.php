<?php

namespace App\Http\Controllers;

use App\Location;
use App\Building;
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
     * @return Response
     */
    public function index()
    {
        return view('admin.location.index');
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
     * @return Response
     */
    public function create()
    {
        return view('admin.location.create');
    }

    /**
     * Speichere neuen Standort
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
//        $v = $this->validateNewLocation();

        $location = new Location();
        $location->l_benutzt = request('l_benutzt');
        $location->l_name_kurz = request('l_name_kurz');
        $location->l_name_lang = request('l_name_lang');
        $location->l_beschreibung = request('l_beschreibung');
        $location->standort_id = Str::uuid();
        $location->addresses_id = request('addresses_id');
        $location->profile_id = request('profile_id');

        $std = (new \App\Standort)->add($location->standort_id, $location->l_name_kurz,'locations');

//        dd($location->standort_id);

$location->save();




        $request->session()->flash('status', 'Der Standort <strong>' . request('l_name_kurz') . '</strong> wurde angelegt!');
        return view('admin.location.show', ['location' => $location]);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return Application|Factory|Response|View
     */
    public function show(Location $location)
    {
        return view('admin.location.show', ['location' => $location]);
    }

    /**
     * Show the form for editing the specified resource.
     *

     */
    public function edit(location $location)
    {

        return view('admin.location.edit', compact('location'));
        //        return view('location.edit',['location'=>$location]);
        //        return view('location.edit',['location'=>$location]);
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
     * @param Location $location
     * @return Response
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
     * @return array
     */
    public function validateLocation(): array
    {
        return request()->validate([
            'l_benutzt' => '',
            'l_name_kurz' => 'bail|min:2|max:20|required',
            'l_name_lang' => '',
            'l_beschreibung' => '',
            'addresses_id' => 'required',
            'profile_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewLocation(): array
    {
        return request()->validate([
            'l_benutzt' => '',
            'l_name_kurz' => 'bail|unique:locations,l_name_kurz|min:2|max:20|required',
            'l_name_lang' => '',
            'l_beschreibung' => '',
            'standort_id' => 'unique:locations,standort_id',
            'addresses_id' => 'required',
            'profile_id' => 'required'
        ]);
    }
}
