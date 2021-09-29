<?php

namespace App\Http\Resources\address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressShort extends JsonResource
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
            'street' => $this->ad_anschrift_strasse,
            'no' => $this->ad_anschrift_hausnummer,
            'zip' => $this->ad_anschrift_plz,
            'city' => $this->ad_anschrift_ort,
        ];
    }
}
