<?php

namespace App\Http\Controllers\Api\V1;

use App\Building;
use App\Http\Controllers\Controller;
use App\Room;
use App\Http\Resources\Room as RoomResource;
use App\Http\Resources\RoomFull as RoomFullResource;
use App\RoomType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RoomController extends Controller {

    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index() {
        return RoomResource::collection(
            Room::with('RoomType', 'building')->get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function full() {
        return RoomFullResource::collection(
            Room::with('RoomType', 'building')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RoomResource
     */
    public function store(Request $request) {
        $request->validate([
            'identifier'   => 'required|unique:rooms,r_name_kurz|max:20',
            'uid'          => 'unique:rooms,standort_id',
            'name'         => '',
            'description'  => '',
            'building_id'  => '',
            'room_type_id' => '',
        ]);

        if (!Building::find($request->building_id))
            return response()->json([
                'error' => 'no building with given id found'
            ], 422);

        if (!RoomType::find($request->room_type_id))
            return response()->json([
                'error' => 'no room type with given id found'
            ], 422);

        $room = new Room();
        $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
        $room->r_name_kurz = $request->identifier;
        $room->standort_id = $uid;
        $room->r_name_lang = $request->name;
        $room->r_name_text = $request->description;
        $room->building_id = $request->building_id;
        $room->room_type_id = $request->room_type_id;
        $room->save();

        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  Room $room
     * @return RoomResource
     */
    public function show(Room $room) {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Room $room
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Room $room) {
        $room->delete();
        return response()->json([
            'status' => 'room deleted'
        ]);
    }
}
