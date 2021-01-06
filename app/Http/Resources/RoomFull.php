<?php

namespace App\Http\Resources;

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
            'identifier' => $this->r_name_kurz,
            'uid' => $this->standort_id,
            'type' => new RoomTypeShort($this->RoomType),
            'building' => new BuildingShort($this->building),
            'name' => $this->r_name_lang,
            'description' => $this->r_name_text,
        ];
    }
}
