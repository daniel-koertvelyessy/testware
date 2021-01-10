<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductParam extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'label' => $this->pp_label,
            'name'  => $this->pp_name,
            'value' => $this->pp_value,
            //            'product_id' => $this->produkt_id,
        ];
    }
}
