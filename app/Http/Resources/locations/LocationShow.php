<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\LocationShow as LocationShowResource;

class LocationShow extends JsonResource
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
            'created' => (string)$this->created_at,
            'updated' => (string)$this->updated_at,
            'uid' => $this->standort_id,
            'name' => $this->l_name_lang,
            'identifier' => $this->l_name_kurz,
            'description' => $this->l_beschreibung,
            'address_id' => $this->adresse_id,
            'employee_id' => $this->profile_id,
        ];
    }
}