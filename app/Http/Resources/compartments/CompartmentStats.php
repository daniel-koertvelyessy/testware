<?php

namespace App\Http\Resources\compartments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompartmentStats extends JsonResource
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
            'equipment' => $this->Storage->countReferencedEquipment(),
        ];
    }
}
