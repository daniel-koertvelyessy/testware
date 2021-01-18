<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\compartments\Compartment;
use App\Http\Resources\compartments\CompartmentFull;
use App\Room;
use App\Storage;
use App\Stellplatz;
use App\StellplatzTyp;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CompartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return Compartment::collection(Stellplatz::with('StellplatzTyp', 'Room')->paginate($request->input('per_page')));
        }
        return Compartment::collection(Stellplatz::with('StellplatzTyp', 'Room')->get());
    }


    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')) {
            return CompartmentFull::collection(Stellplatz::with('StellplatzTyp', 'Room')->paginate($request->input('per_page')));
        }
        return CompartmentFull::collection(Stellplatz::with('StellplatzTyp', 'Room')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Compartment
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|unique:stellplatzs,sp_label|max:20',
            'uid' => '',
            'name' => '',
            'description' => '',
            'compartment_type_id' => '',
            'room_id' => '',
        ]);

        if (!Room::find($request->room_id))
            return response()->json([
                'error' => 'no room with given id found'
            ], 422);

        $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
        (new Storage)->add($uid, $request->label, 'stellplatzs');

        $compartment = new Stellplatz();
        $compartment->sp_label = $request->label;
        $compartment->storage_id = $uid;
        $compartment->sp_name = (isset($request->name)) ? $request->name : null;
        $compartment->sp_description = (isset($request->description)) ? $request->description : null;
        $compartment->room_id = $request->room_id;
        $compartment->stellplatz_typ_id = (new StellplatzTyp)->checkApiCompartmentType($request);

        $compartment->save();

        return new Compartment($compartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  Stellplatz $compartment
     * @return Compartment
     */
    public function show(Stellplatz $compartment)
    {
        return new Compartment($compartment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return Compartment
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|max:20',
            'uid' => '',
            'name' => '',
            'description' => '',
            'compartment_type_id' => 'exclude_unless:type,true|required',
            'type' => 'exclude_unless:compartment_type_id,true|required',
            'room_id' => '',
        ]);

        $compartment = Stellplatz::find($id);

        if ($compartment) {
            $compartment->sp_label = (isset($request->label)) ? $request->label : $compartment->sp_label;
            $compartment->sp_name = (isset($request->name)) ? $request->name : $compartment->sp_name;
            $compartment->sp_description = (isset($request->description)) ? $request->description : $compartment->sp_description;

            /**
             * Check if compartment-uid is given and update/add the table "storages"
             */
            $uid = (isset($request->uid)) ? $request->uid : $compartment->storage_id;
            $compartment->storage_id = $uid;
            (new \App\Storage)->change($uid, $request->label, 'stellplatzs');
            $compartment->stellplatz_typ_id  = (new StellplatzTyp)->checkApiCompartmentType($request);
            if (!$compartment->stellplatz_typ_id)
                return response()->json([
                    'error' => 'referenced compartment type could not be found'
                ], 422);
            $compartment->save();
        } else {
            return  $this->store($request);
        }

        return new Compartment($compartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Stellplatz $stellplatz
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Stellplatz $stellplatz)
    {
        $stellplatz->delete();
        return response()->json([
            'status' => 'compartment deleted'
        ]);
    }
}
