<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomShort extends JsonResource
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
            'label' => $this->r_name_kurz,
            'uid' => $this->standort_id,
        ];
    }
}
