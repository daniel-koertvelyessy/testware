<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationFull extends JsonResource
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
            'updated' => (string)$this->updated_at,
            'uid' => $this->standort_id,
            'name' => $this->l_name_lang,
            'identifier' => $this->l_name_kurz,
            'description' => $this->l_beschreibung,
            'address'=> new AddressFull($this->Adresse),
            'manager' => new ProfileFull($this->Profile)
        ];
    }
}
