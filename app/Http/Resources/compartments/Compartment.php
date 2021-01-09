<?php

namespace App\Http\Resources\compartments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompartmentFull extends JsonResource
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
            'identifier' => $this->sp_name_kurz,
            'uid' => $this->standort_id,
            'type' => new CompartmentTypeShort($this->stellplatz_typ_id),
            'name' => $this->sp_name_lang,
            'description' => $this->sp_name_text,
            'room' => new RoomShort($this->room_id),
        ];
    }
}
