<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdresseKurz as AdresseKurzResource;

class Location extends JsonResource
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
            'id' => $this->id,
            'created' => (string)$this->created_at,
            'name' => $this->l_name_lang,
            'identifier' => $this->l_name_kurz,
            'description' => $this->l_beschreibung,

        ];
    }
}
