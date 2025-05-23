<?php

namespace App\Http\Resources\rooms;

use App\Http\Resources\buildings\BuildingShort;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomFull extends JsonResource
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
            'created' => (string) $this->created_at,
            'updated' => (string) $this->updated_at,
            'label' => $this->r_label,
            'uid' => $this->storage_id,
            'name' => $this->r_name,
            'description' => $this->r_description,
            'type' => new RoomTypeShort($this->RoomType),
            'building' => new BuildingShort($this->building),
            'room_objects' => new RoomStats($this),
        ];
    }
}
