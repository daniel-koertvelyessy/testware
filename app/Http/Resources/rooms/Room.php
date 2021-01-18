<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Room extends JsonResource
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
            'id' => $this->id,
            'created' => (string)$this->created_at,
            'updated' => (string)$this->updated_at,
            'label' => $this->r_label,
            'uid' => $this->storage_id,
            'name' => $this->r_name,
            'description' => $this->r_description,
            'building_id' => $this->building_id,
            'room_type_id' => $this->room_type_id,
        ];
    }
}
