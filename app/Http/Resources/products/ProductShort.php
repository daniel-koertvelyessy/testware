<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShort extends JsonResource
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
            'label' => $this->prod_label,
            'name' => $this->prod_name,
            'description' => $this->prod_description,
            'number' => $this->prod_nummer,
        ];
    }
}
