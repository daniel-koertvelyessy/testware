<?php

namespace App\Http\Resources\locations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\locations\Location as LocationResource;
use App\Http\Resources\locations\EquipmentShow as LocationShowResource;

class LocationShow extends JsonResource
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
            'created' => (string)$this->created_at,
            'updated' => (string)$this->updated_at,
            'label' => $this->l_label,
            'uid' => $this->storage_id,
            'name' => $this->l_name,
            'description' => $this->l_beschreibung,
            'address_id' => $this->adresse_id,
            'employee_id' => $this->profile_id,
        ];
    }
}
