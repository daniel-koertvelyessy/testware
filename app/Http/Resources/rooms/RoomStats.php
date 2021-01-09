<?php

namespace App\Http\Resources\rooms;

use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressShort as AdresseKurzResource;

class RoomStats extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'compartments' => Stellplatz::where('room_id',$this->id)->count(),
            'equipment' => $this->countTotalEquipmentInRoom()
        ];
    }
}
