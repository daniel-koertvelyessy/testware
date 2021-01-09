<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductStateFull extends JsonResource
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
            'label' => $this->ps_name_kurz,
            'name' => $this->ps_name_lang,
            'description' => $this->ps_name_text,
            'bs_color_class' => $this->ps_color,
            'bs_icon_class' => $this->ps_icon,
        ];
    }
}
