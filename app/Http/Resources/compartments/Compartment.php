<?php

namespace App\Http\Resources\compartments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Compartment extends JsonResource
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
            'uid' => $this->storage_id,
            'name' => $this->sp_name,
            'description' => $this->sp_description,
            'compartment_type_id' => $this->stellplatz_typ_id,
            'room_id' => $this->room_id,
        ];
    }
}
