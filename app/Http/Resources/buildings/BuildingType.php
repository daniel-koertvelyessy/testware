<?php

namespace App\Http\Resources\buildings;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingType extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'label' => $this->btname,
            'description' => $this->btbeschreibung,
        ];
    }
}
