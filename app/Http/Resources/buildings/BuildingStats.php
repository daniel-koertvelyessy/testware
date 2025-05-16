<?php

namespace App\Http\Resources\buildings;

use App\Room;
use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingStats extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $roomCount = 0;
        $compartmentCount = 0;

        $rooms = Room::where('building_id', $this->id);
        $roomCount += $rooms->count();
        foreach ($rooms->get() as $room) {
            $compartments = Stellplatz::where('room_id', $room->id);
            $compartmentCount += $compartments->count();
        }

        return [
            'rooms' => $roomCount,
            'compartments' => $compartmentCount,
            'equipment' => $this->countTotalEquipmentInBuilding(),
        ];
    }
}
