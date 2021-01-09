<?php

namespace App\Http\Resources\locations;

use App\Http\Resources\AddressFull;
use App\Http\Resources\ProfileFull;
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
            'label' => $this->l_label,
            'uid' => $this->standort_id,
            'name' => $this->l_name,
            'description' => $this->l_beschreibung,
            'address' => new AddressFull($this->Adresse),
            'manager' => new ProfileFull($this->Profile),
            'location_objects' => new LocationStats($this)
        ];
    }
}
