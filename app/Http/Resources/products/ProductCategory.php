<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategory extends JsonResource
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
            'label' => $this->pk_label,
            'name' => $this->pk_name,
            'number' => $this->pk_name_nummer,
            'description' => $this->pk_description,
        ];
    }
}
