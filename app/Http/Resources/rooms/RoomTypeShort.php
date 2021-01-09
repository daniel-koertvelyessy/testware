<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeShort extends JsonResource
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
            'label' => $this->rt_name_kurz,
        ];
    }
}
