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
            'label' => $this->pk_name_kurz,
            'name' => $this->pk_name_lang,
            'number' => $this->pk_name_nummer,
            'description' => $this->pk_name_text,
        ];
    }
}
