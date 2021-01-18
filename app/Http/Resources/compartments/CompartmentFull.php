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
            'label' => $this->sp_label,
            'type' => new CompartmentTypeShort($this->StellplatzTyp),
            'name' => $this->sp_name,
            'description' => $this->sp_description,
            'room' => new RoomShort($this->Room),
            'objects' => new CompartmentStats($this)
        ];
    }
}
