<?php

namespace App\Http\Resources\buildings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingShort extends JsonResource
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
            'label' => $this->b_name_kurz,
            'uid' => $this->standort_id,
            'name' => $this->b_name_lang,
            'description' => $this->b_name_text,
        ];
    }
}
