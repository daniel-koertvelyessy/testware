<?php

namespace App\Http\Resources\compartments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompartmentTypeShort extends JsonResource
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
            'label' => $this->spt_name_kurz,
            'id' => $this->id,
        ];
    }
}
