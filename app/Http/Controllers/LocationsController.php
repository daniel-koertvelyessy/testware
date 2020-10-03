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
//        dd($request);
        $v = $this->validateNewLocation();

        $location = Location::create($this->validateNewLocation());


        $request->session()->flash('status', 'Der Standort <strong>' . request('l_name_kurz') . '</strong> wurde angelegt!');
        return view('admin.standorte.location.show', ['location' => $location]);
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
