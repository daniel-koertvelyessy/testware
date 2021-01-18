<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomType extends JsonResource
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
            'label' => $this->rt_label,
            'name' => $this->rt_name,
            'description' => $this->rt_description,
        ];
    }
}
