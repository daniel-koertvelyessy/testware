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
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->eq_uid,
            'name' => $this->eq_name,
            'link_api' => route('api.v1.equipment.show', $this),
            'link_web' => route('equipment.show', $this),
        ];
    }
}
