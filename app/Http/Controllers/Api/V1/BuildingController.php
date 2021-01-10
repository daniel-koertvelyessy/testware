<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Building;
use App\Location;
use App\BuildingTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\buildings\BuildingFull as BuildingFullResource;
use App\Http\Resources\buildings\Building as BuildingResource;
use App\Http\Resources\buildings\BuildingShow as BuildingShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class BuildingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return BuildingResource::collection(
                Building::with('BuildingType', 'location')->paginate($request->input('per_page'))
            );
        }
        return BuildingResource::collection(
            Building::with('BuildingType', 'location')->get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')) {
            return BuildingFullResource::collection(
                Building::with('BuildingType', 'location')->paginate($request->input('per_page'))
            );
        }
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
    public function store(Request $request)
    {
        $this->validateBuilding($request);

        if (!Location::find($request->location_id))
            return response()->json([
                'error' => 'no location with given id found'
            ], 422);

        $type_id = 1;

        if (isset($request->type_id)) {
            if (!BuildingTypes::find($request->type_id)) {
                return response()->json([
                    'error' => 'no valid building type with given id found'
                ], 422);
            } else {
                $type_id = $request->type_id;
            }
        }

        if (isset($request->type['label'])) {
            $buildingType = \App\BuildingTypes::where('btname', $request->type['label'])->first();
            if (!$buildingType) {
                $newBuildingType = new BuildingTypes();
                $newBuildingType->btname = $request->type['label'];
                $newBuildingType->btbeschreibung = (isset($request->type['description'])) ? $request->type['description'] : null;
                $newBuildingType->save();
                $type_id = $newBuildingType->id;
            } else {
                $bt = $buildingType->get();
                $type_id = $bt->id;
            }
        }

        $building = new Building();
        $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
        $building->b_label = $request->label;
        $building->b_we_has = $request->goods_income_has;
        $building->storage_id = $uid;
        (new \App\Storage)->add($uid, $request->label, 'buildings');
        $building->b_name = $request->name;
        $building->b_name_ort = $request->place;
        $building->b_name = $request->description;
        $building->b_we_name = $request->goods_income_name;
        $building->building_type_id = $type_id;
        $building->location_id = (isset($request->location_id)) ? $request->location_id : 1;
        $building->save();
        return new BuildingResource($building);
    }

    /**
     * Display the specified resource.
     *
     * @param  Building $building
     * @return BuildingShowResource
     */
    public function show(Building $building)
    {
        return new BuildingShowResource($building);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label'        => 'required',
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
        if ($building) {
            if (isset($request->goods_income_has)) {
                $goods_income_has = ($request->goods_income_has) ? 1 : 0;
            }
            $building->b_label = (isset($request->label)) ? $request->label : $building->b_label;
            $building->b_we_has = (isset($request->goods_income_has)) ? $goods_income_has : $building->b_we_has;
            $building->b_name = (isset($request->name)) ? $request->name : $building->b_name;
            $building->b_name_ort = (isset($request->place)) ? $request->place : $building->b_name_ort;
            $building->b_name_text = (isset($request->description)) ? $request->description : $building->b_name;
            $building->b_we_name = (isset($request->goods_income_name)) ? $request->goods_income_name : $building->b_we_name;
            $uid = (isset($request->uid)) ? $request->uid : $building->storage_id;
            $building->storage_id = $uid;
            (new \App\Storage)->change($uid, $request->label, 'buildings');
            $building->building_type_id = (isset($request->type_id) && BuildingTypes::find($request->type_id)) ? $request->type_id : $building->building_type_id;
            $building->location_id = (isset($request->location_id) && Location::find($request->location_id)) ? $request->location_id : $building->location_id;
            $building->save();
            return new BuildingShowResource($building);
        } else {
            $this->validateBuilding($request);
            $building = new Building();
            $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
            $building->b_label = $request->label;
            $building->b_we_has = $request->goods_income_has;
            $building->storage_id = $uid;
            (new \App\Storage)->add($uid, $request->label, 'buildings');
            $building->b_name = $request->name;
            $building->b_name_ort = $request->place;
            $building->b_name_text = $request->description;
            $building->b_we_name = $request->goods_income_name;
            $building->building_type_id = (isset($request->type_id)) ? $request->type_id : 1;
            $building->location_id = (isset($request->location_id)) ? $request->location_id : 1;
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
    public function destroy(Building $building)
    {
        $building->delete();
        return response()->json([
            'status' => 'building deleted'
        ]);
    }

    /**
     * @param  Request $request
     */
    public function validateBuilding(Request $request): void
    {
        $request->validate([
            'label'        => 'required|unique:buildings,b_label',
            'goods_income_has'  => 'required|boolean',
            'uid'               => 'unique:buildings,storage_id',
            'type_id'           => '',
            'name'              => '',
            'place'             => '',
            'description'       => '',
            'goods_income_name' => '',
            'location_id'       => '',
        ]);
    }
}
