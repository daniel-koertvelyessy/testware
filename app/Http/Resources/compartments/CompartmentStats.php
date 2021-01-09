<?php

namespace App\Http\Resources\compartments;

use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressShort as AdresseKurzResource;

class CompartmentStats extends JsonResource
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
            'equipment' => $this->Standort->countReferencedEquipment()
        ];
    }
}
