<?php

namespace App\Http\Resources\locations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationShort extends JsonResource
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
            'label' => $this->l_label,
            'name' => $this->l_name,
        ];
    }
}
