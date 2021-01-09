<?php

namespace App\Http\Controllers\Api\V1;

use App\Building;
use App\Http\Controllers\Controller;
use App\Room;
use App\Http\Resources\rooms\Room as RoomResource;
use App\Http\Resources\rooms\RoomFull as RoomFullResource;
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
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request) {
        if ($request->input('per_page')){
            return RoomResource::collection(
                Room::with('RoomType', 'building')->paginate($request->input('per_page'))
            );
        }
        return RoomResource::collection(
            Room::with('RoomType', 'building')->get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function full(Request $request) {
        if ($request->input('per_page')){
            return RoomFullResource::collection(
                Room::with('RoomType', 'building')->paginate($request->input('per_page'))
            );
        }
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
            'label'   => 'required|unique:rooms,r_name_kurz|max:20',
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
        $room->r_name_kurz = $request->label;
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
     * @return RoomResource
     */
    public function update(Request $request, $id) {
        $request->validate([
            'label'   => 'required',
            'uid'          => '',
            'name'         => '',
            'description'  => '',
            'building_id'  => '',
            'room_type_id' => 'exclude_unless:type.label,true|required',
            'type.label' => 'exclude_unless:room_type_id,true|required',
        ]);

        $room = Room::find($id);
        if ($room) {
            $room->r_name_kurz = (isset($request->label)) ? $request->label : $room->r_name_kurz;
            $room->r_name_lang = (isset($request->name)) ? $request->name : $room->r_name_lang;
            $room->r_name_text = (isset($request->description)) ? $request->description : $room->r_name_text;

            /**
             * Check if room-uid is given and update/add the table "standorts"
             */
            $uid = (isset($request->uid)) ? $request->uid : $room->standort_id;
            $room->standort_id = $uid;
            (new \App\Standort)->change($uid, $request->label, 'rooms');

        } else {
            /**
             * Room was not found. Try to add as new room
             */
            $room = new Room();
            $room->r_name_kurz = $request->label ;
            $room->r_name_lang = (isset($request->name)) ? $request->name : null;
            $room->r_name_text = (isset($request->description)) ? $request->description : null;

            /**
             * Check if room-uid is given and add the table "standorts"
             */
            $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
            $room->standort_id = $uid;
            (new \App\Standort)->add($uid, $request->label, 'rooms');

        }

        /**
         * Check if building-id is given and check if the referenced building exits
         */
        if (isset($request->building_id)) {
            $building = Building::find($room->building_id);
            if ($building) {
                $room->building_id = $request->building_id;
            } else {
                return response()->json([
                    'error' => 'referenced building could not be found'
                ], 422);
            }
        } else {
            $room->building_id = 1;
        }


        /**
         * Check if room-type-id or room-type-name is given and check if they exits
         */
        if (isset($request->room_type_id)) {
            $roomType = RoomType::find($room->room_type_id);
            if ($roomType) {
                $room->room_type_id = $request->room_type_id;
            } else {
                return response()->json([
                    'error' => 'referenced room type could not be found'
                ], 422);
            }
        } elseif (isset($request->type['label'])){
            $roomType = RoomType::where('rt_name_kurz', $request->type['label'])->first();

            if ($roomType) {
                $room->room_type_id = $roomType->id;
            } else {
                $room->room_type_id =  (new \App\RoomType)->addAPIRoomType($request);
            }
        } else {
            $room->room_type_id = 1;
        }
        $room->save();
        return new RoomResource($room);
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
