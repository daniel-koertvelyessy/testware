<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Building;
use App\Location;
use App\BuildingTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingFull as BuildingFullResource;
use App\Http\Resources\Building as BuildingResource;
use App\Http\Resources\BuildingShow as BuildingShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BuildingController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index() {
        return BuildingResource::collection(
            Building::with('BuildingType', 'location')->get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function full() {
        return BuildingFullResource::collection(
            Building::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return BuildingResource
     */
    public function store(Request $request) {
        $request->validate([
            'identifier'        => 'required|unique:buildings,b_name_kurz',
            'goods_income_has'  => 'required',
            'uid'               => '',
            'type_id'           => '',
            'name'              => '',
            'place'             => '',
            'description'       => '',
            'goods_income_name' => '',
            'location_id'       => '',
        ]);
        $building = new Building();
        $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
        $building->b_name_kurz = $request->identifier;
        $building->b_we_has = $request->goods_income_has;
        $building->standort_id =  $uid;
        (new \App\Standort)->add($uid,$request->identifier,'buildings');
        $building->b_name_lang = $request->name;
        $building->b_name_ort = $request->place;
        $building->b_name_lang = $request->description;
        $building->b_we_name = $request->goods_income_name;
        $building->building_type_id = (isset($request->type_id))? $request->type_id : 1;
        $building->location_id = (isset($request->location_id))? $request->location_id : 1;
        $building->save();
        return new BuildingResource($building);
    }

    /**
     * Display the specified resource.
     *
     * @param  Building $building
     * @return BuildingShowResource
     */
    public function show(Building $building) {
        return new BuildingShowResource($building);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return BuildingShowResource
     */
    public function update(Request $request, $id) {
        $request->validate([
            'identifier'        => 'required',
            'goods_income_has'  => 'required',
            'uid'               => '',
            'type_id'           => '',
            'name'              => '',
            'place'             => '',
            'description'       => '',
            'goods_income_name' => '',
            'location_id'       => '',
        ]);

        $building = Building::find($id);
        if ($building){
            if (isset($request->goods_income_has)) {
               $goods_income_has =  ($request->goods_income_has) ? 1 : 0;
            }
            $building->b_name_kurz = (isset($request->identifier)) ? $request->identifier : $building->b_name_kurz;
            $building->b_we_has = (isset($request->goods_income_has)) ? $goods_income_has : $building->b_we_has;
            $building->b_name_lang = (isset($request->name)) ? $request->name : $building->b_name_lang;
            $building->b_name_ort = (isset($request->place)) ? $request->place : $building->b_name_ort;
            $building->b_name_lang = (isset($request->description)) ? $request->description : $building->b_name_lang;
            $building->b_we_name = (isset($request->goods_income_name)) ? $request->goods_income_name : $building->b_we_name;
            $uid = (isset($request->uid)) ? $request->uid : $building->standort_id;
            $building->standort_id = $uid;
            (new \App\Standort)->change($uid,$request->identifier,'buildings');
            $building->building_type_id = (isset($request->type_id) && BuildingTypes::find($request->type_id)) ? $request->type_id : $building->building_type_id;
            $building->location_id = (isset($request->location_id) && Location::find($request->location_id)) ? $request->location_id : $building->location_id;
            $building->save();
            return new BuildingShowResource($building);
        } else {
            $request->validate([
                'identifier'        => 'required|unique:buildings,b_name_kurz',
                'goods_income_has'  => 'required',
                'uid'               => '',
                'type_id'           => '',
                'name'              => '',
                'place'             => '',
                'description'       => '',
                'goods_income_name' => '',
                'location_id'       => '',
            ]);
            $building = new Building();
            $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
            $building->b_name_kurz = $request->identifier;
            $building->b_we_has = $request->goods_income_has;
            $building->standort_id =  $uid;
            (new \App\Standort)->add($uid,$request->identifier,'buildings');
            $building->b_name_lang = $request->name;
            $building->b_name_ort = $request->place;
            $building->b_name_lang = $request->description;
            $building->b_we_name = $request->goods_income_name;
            $building->building_type_id = (isset($request->type_id))? $request->type_id : 1;
            $building->location_id = (isset($request->location_id))? $request->location_id : 1;
            $building->save();
            return new BuildingResource($building);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Building $building
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Building $building) {
        $building->delete();
        return response()->json([
            'status' => 'building deleted'
        ]);
    }
}
