<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdresseFull extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'street' => $this->ad_anschrift_strasse,
            'no' => $this->ad_anschrift_hausnummer,
            'zip' => $this->ad_anschrift_plz,
            'place' => $this->ad_anschrift_ort,
        ];
    }
}
