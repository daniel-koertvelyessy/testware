<?php

namespace App\Http\Resources\products;

use App\Equipment;
use App\ProduktAnforderung;
use App\Stellplatz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AddressShort as AdresseKurzResource;

class ProductStats extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request) {
        $requirement_array = [];
        $requirements = ProduktAnforderung::where('produkt_id',$this->id)->get();
        foreach ($requirements as $requirement)
            $requirement_array[] = [
                'id' => $requirement->Anforderung->id,
                'type'=> $requirement->Anforderung->an_name_lang
            ];

        $countChildEquipment = Equipment::where('produkt_id',$this->id)->count();
        return [
            'requirements' => $requirement_array,
            'equipment' => $countChildEquipment,

        ];
    }
}
