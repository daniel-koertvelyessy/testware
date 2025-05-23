<?php

namespace App\Http\Resources\locations;

use App\Building;
use App\Room;
use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationStats extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $buildings = Building::where('location_id', $this->id);
        $roomCount = 0;
        $compartmentCount = 0;
        foreach ($buildings->get() as $building) {
            $rooms = Room::where('building_id', $building->id);
            $roomCount += $rooms->count();
            foreach ($rooms->get() as $room) {
                $compartments = Stellplatz::where('room_id', $room->id);
                $compartmentCount += $compartments->count();
            }
        }

        return [
            'buildings' => $buildings->count(),
            'rooms' => $roomCount,
            'compartments' => $compartmentCount,
            'equipment' => $this->countTotalEquipmentInLocation(),
        ];
    }
}
