<?php

namespace App\Http\Resources\equipment;

use App\Building;
use App\Room;
use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\AddressShort as AdresseKurzResource;

class EquimentStats extends JsonResource
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
            'status' => $this->EquipmentState->eqs_label,
            'tested_at' => $this->tested_at,
            'test_due_at' => $this->test_due_at,
            'equipment_link' => route('api.v1.equipment.show',$this)
        ];
    }
}
