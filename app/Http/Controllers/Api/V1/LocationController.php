<?php

namespace App\Http\Controllers\Api\V1;

use App\AddressType;
use App\Adresse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressFull;
use App\Location;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\LocationFull as LocationFullResource;
use App\Http\Resources\LocationShow as LocationShowResource;
use Illuminate\Support\Str;

class LocationController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return LocationResource::collection(Location::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function full()
    {
        return LocationFullResource::collection(
            Location::with('Adresse','Profile' )->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->validateNewLocation();
        $adresse_id = (new \App\Adresse)->addAddress($request);
        $profile_id = (new \App\Profile)->addProfile($request);

        $standort_id = (!isset($request->uid)) ? Str::uuid() : $request->uid;
        (new \App\Standort)->add($standort_id, $request->identifier, 'locations');

        $location = new Location();
        $location->l_name_kurz = $request->identifier;
        $location->l_name_lang = $request->name;
        $location->l_beschreibung = $request->description;
        $location->adresse_id = $adresse_id;
        $location->profile_id = $profile_id;
        $location->standort_id = $standort_id;
        $location->save();

        $adresse_id = ($adresse_id===NULL) ? 'referenced id not found' : $adresse_id;
        $profile_id = ($profile_id===NULL) ? 'referenced id not found' : $profile_id;

        return [
            'status' =>true,
            'id' => $location->id,
            'uid' => $standort_id,
            'address' => $adresse_id,
            'employee' => $profile_id,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  Location $location
     * @return LocationShowResource
     */
    public function show(Location $location)
    {
        return new LocationShowResource($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Location $location
     * @param  Request  $request
     * @return LocationResource
     */
    public function update(Location $location, Request $request)
    {
        $location->l_name_lang = (isset($request->name))? $request->name : $location->l_name_lang;
        $location->l_name_kurz = (isset($request->identifier))? $request->identifier : $location->l_name_kurz;
        $location->l_beschreibung = (isset($request->description))? $request->description : $location->l_beschreibung;
        $location->save();

        return new LocationResource($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location $location
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Location $location) {
        $location->delete();
        return response()->json([
            'status' => 'location deleted'
        ]);
    }

    /**
     * @return array
     */
    public
    function validateNewLocation(): array
    {
        return request()->validate([
            'identifier' => 'bail|unique:locations,l_name_kurz|min:2|max:20|required',
            'name' => '',
            'description' => '',
            'uid' => 'unique:locations,standort_id',
        ]);
    }
}
