<?php

namespace App\Http\Resources\equipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentShort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->eq_uid,
            'name' => $this->eq_name,
            'link' => route('api.v1.equipment.show',$this)
        ];
    }
}
