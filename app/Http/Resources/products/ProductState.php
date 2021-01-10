<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductState extends JsonResource
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
            'label'          => $this->ps_label,
            'name'           => $this->ps_name,
            'description'    => $this->ps_name_text,
            'bs_color_class' => $this->ps_color,
            'bs_icon_class'  => $this->ps_icon,
        ];
    }
}
