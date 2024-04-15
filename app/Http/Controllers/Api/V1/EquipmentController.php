<?php

namespace App\Http\Controllers\Api\V1;

use App\Equipment;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

use App\Http\Resources\equipment\Equipment as EquipmentResource;
use App\Http\Resources\equipment\TestEquipment as TestEquipmentResource;
use App\Http\Resources\equipment\EquipmentShow as EquipmentShowResource;
use App\Http\Resources\equipment\EquipmentStats as EquipmentStatsResource;

class EquipmentController extends Controller
{

    public function __construct() {
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
            return EquipmentResource::collection(Equipment::with('EquipmentState'))->paginate($request->input('per_page'));
        }
        return EquipmentResource::collection(Equipment::with('EquipmentState')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EquipmentShowResource
     */
    public function show(Equipment $equipment)
    {
        return new EquipmentShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment $equipment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->json([
            'status' => 'eqipment deleted'
        ]);
    }

    public function status()
    {
        return EquipmentStatsResource::collection(Equipment::with('EquipmentState')->get());
    }

    public function testEquipment()
    {
       return TestEquipmentResource::collection(Equipment::with('EquipmentState')->get()->filter(function($equipment){
            if($equipment->produkt->ControlProdukt) return $equipment;
        })
       );


    }


}
