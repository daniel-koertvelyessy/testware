<?php

namespace App\Http\Resources\locations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressShort as AdresseKurzResource;

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
            'label' => $this->l_name_kurz,
            'name' => $this->l_name_lang,
        ];
    }
}
