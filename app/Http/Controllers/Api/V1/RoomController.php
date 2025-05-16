<?php

namespace App\Http\Controllers\Api\V1;

use App\Building;
use App\Http\Controllers\Controller;
use App\Http\Resources\rooms\Room as RoomResource;
use App\Http\Resources\rooms\RoomFull as RoomFullResource;
use App\Room;
use App\RoomType;
use App\Storage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return RoomResource::collection(Room::with('RoomType', 'building')->paginate($request->input('per_page')));
        }

        return RoomResource::collection(Room::with('RoomType', 'building')->get());
    }

    public function storemany(Request $request)
    {
        $jsondata = (object) $request->json()->all();
        if (isset($jsondata->label)) {
            return $this->store($request);
        } else {
            $idList = [];
            $roomTypeList = [];
            $buildList = [];
            $countNew = 0;
            $countUpdate = 0;
            $countSkipped = 0;

            foreach ($jsondata as $data) {
                /**
                 *    label is a required field. Skipp this dataset
                 */
                if (! isset($data['label'])) {
                    $roomTypeList[] = ['error' => 'no required items found (missing item [label])'];
                    $countSkipped++;

                    continue;
                }

                /**
                 *  first, check if a valid room-type label or room-type-id is given
                 */
                if (isset($data['type']['label'])) {
                    $roomType = RoomType::where('rt_label', $data['type']['label'])->first();
                    if ($roomType) {
                        $room_type_id = $roomType->id;
                    } else {
                        $room_type_id = (new RoomType)->addNewType($data['type']);
                        $roomTypeList[] = [
                            'id' => $room_type_id,
                        ];
                    }
                } elseif (isset($data['room_type_id'])) {
                    $roomType = RoomType::find($data['room_type_id']);
                    if ($roomType) {
                        $room_type_id = $roomType->id;
                    } else {
                        $roomTypeList[] = ['error' => 'skipp dataset due to invalid room type given'];
                        $countSkipped++;

                        continue;
                    }
                } else {
                    $roomTypeList[] = ['error' => 'skipp dataset due to invalid room type given'];
                    $countSkipped++;

                    continue;
                }

                if (isset($data['building']['label'])) {
                    $checkBuilding = Building::where('b_label', $data['building']['label'])->first();
                    if ($checkBuilding && $checkBuilding->storage_id === $data['building']['uid']) {
                        $building_id = $checkBuilding->id;
                    } elseif (! $checkBuilding) {
                        $building_id = (new Building)->add($data['building']);
                        $buildList[] = [
                            'id' => $building_id,
                            'label' => $data['building']['label'],
                        ];
                    } else {
                        $roomTypeList[] = ['error' => 'skipp dataset due to building data given'];
                        $countSkipped++;

                        continue;
                    }
                } elseif (isset($data['building_id'])) {
                    $building = Building::find($data['building_id']);
                    if ($building) {
                        $building_id = $building->id;
                    } else {
                        $roomTypeList[] = ['error' => 'skipp dataset due to building data given'];
                        $countSkipped++;

                        continue;
                    }
                } else {
                    $roomTypeList[] = ['error' => 'skipp dataset due to building data given'];
                    $countSkipped++;

                    continue;
                }

                $storage_id = ((new Storage)->checkUidExists($data['uid'])) ? $data['uid'] : Str::uuid();
                (new Storage)->add($storage_id, $data['label'], 'rooms');

                if (Room::where('r_label', $data['label'])->count() > 0) {
                    /**
                     *   room with matching label found  => update!
                     */
                    $room = Room::where('r_label', $data['label'])->first();
                    $countUpdate++;
                    $updateRoom = true;
                } elseif (isset($data['id']) && Room::find($data['id'])) {
                    /**
                     *   exact room with matching label AND id found => update!
                     */
                    $room = Room::find($data['id']);
                    $countUpdate++;
                    $updateRoom = true;
                } else {
                    /**
                     *   no matching found => create new one!
                     */
                    $room = new Room;
                    $countNew++;
                    $updateRoom = false;
                }

                if ($updateRoom) {
                    $r_label = (isset($data['label'])) ? $data['label'] : $room->r_label;
                    $r_name = (isset($data['name'])) ? $data['name'] : $room->r_name;
                    $storage_uid = (isset($data['uid'])) ? $data['uid'] : $room->storage_id;
                    $r_description = (isset($data['description'])) ? $data['description'] : $room->r_description;
                } else {
                    $r_label = $data['label'];
                    $r_name = (isset($data['name'])) ? $data['name'] : null;
                    $storage_uid = (isset($data['uid'])) ? $data['uid'] : $storage_id;
                    $r_description = (isset($data['description'])) ? $data['description'] : null;
                }

                $room->r_label = $r_label;
                $room->r_name = $r_name;
                $room->storage_id = $storage_uid;
                $room->r_description = $r_description;
                $room->room_type_id = $room_type_id;
                $room->building_id = $building_id;
                $room->save();

                $idList[] = [
                    'id' => $room->id,
                    'label' => $r_label,
                ];
            }

            return response()->json([
                'updated_objects' => $countUpdate,
                'skipped_objects' => $countSkipped,
                'new_objects' => [
                    'room' => $countNew,
                    'building' => $buildList,
                    'room_type' => $roomTypeList,
                ],
                'id_list' => $idList,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return RoomResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|unique:rooms,r_label|max:20',
            'uid' => 'unique:rooms,storage_id',
            'name' => '',
            'description' => '',
            'building_id' => '',
            'room_type_id' => '',
        ]);

        if (! Building::find($request->building_id)) {
            return response()->json([
                'error' => 'no building with given id found',
            ], 422);
        }

        if (! RoomType::find($request->room_type_id)) {
            return response()->json([
                'error' => 'no room type with given id found',
            ], 422);
        }

        $room = new Room;
        $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
        $room->r_label = $request->label;
        $room->storage_id = $uid;
        $room->r_name = $request->name;
        $room->r_description = $request->description;
        $room->building_id = $request->building_id;
        $room->room_type_id = $request->room_type_id;
        $room->save();

        return new RoomResource($room);
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')) {
            return RoomFullResource::collection(Room::with('RoomType', 'building')->paginate($request->input('per_page')));
        }

        return RoomFullResource::collection(Room::with('RoomType', 'building')->get());
    }

    /**
     * Display the specified resource.
     *
     *
     * @return RoomResource
     */
    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return RoomResource
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required',
            'uid' => '',
            'name' => '',
            'description' => '',
            'building_id' => '',
            'room_type_id' => 'exclude_unless:type.label,true|required',
            'type.label' => 'exclude_unless:room_type_id,true|required',
        ]);

        $room = Room::find($id);
        if ($room) {
            $room->r_label = (isset($request->label)) ? $request->label : $room->r_label;
            $room->r_name = (isset($request->name)) ? $request->name : $room->r_name;
            $room->r_description = (isset($request->description)) ? $request->description : $room->r_description;

            /**
             * Check if room-uid is given and update/add the table "storages"
             */
            $uid = (isset($request->uid)) ? $request->uid : $room->storage_id;
            $room->storage_id = $uid;
            (new Storage)->change($uid, $request->label, 'rooms');
        } else {
            /**
             * Room was not found. Try to add as new room
             */
            $room = new Room;
            $room->r_label = $request->label;
            $room->r_name = (isset($request->name)) ? $request->name : null;
            $room->r_description = (isset($request->description)) ? $request->description : null;

            /**
             * Check if room-uid is given and add the table "storages"
             */
            $uid = (isset($request->uid)) ? $request->uid : Str::uuid();
            $room->storage_id = $uid;
            (new Storage)->add($uid, $request->label, 'rooms');
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
                    'error' => 'referenced building could not be found',
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
                    'error' => 'referenced room type could not be found',
                ], 422);
            }
        } elseif (isset($request->type['label'])) {
            $roomType = RoomType::where('rt_label', $request->type['label'])->first();

            if ($roomType) {
                $room->room_type_id = $roomType->id;
            } else {
                $room->room_type_id = (new RoomType)->addAPIRoomType($request);
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
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'status' => 'room deleted',
        ]);
    }
}
