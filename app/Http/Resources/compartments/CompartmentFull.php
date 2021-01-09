<?php

namespace App\Http\Resources\compartments;

use App\Http\Resources\rooms\RoomShort;
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
            'label' => $this->sp_name_kurz,
            'type' => new CompartmentTypeShort($this->StellplatzTyp),
            'name' => $this->sp_name_lang,
            'description' => $this->sp_name_text,
            'room' => new RoomShort($this->Room),
            'objects' => new CompartmentStats($this)
        ];
    }
}
