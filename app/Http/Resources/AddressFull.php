<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressFull extends JsonResource
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
            'type' => new AddressType($this->AddressType),
            'identifier' => $this->ad_label,
            'name' => $this->ad_name,
            'company' => $this->ad_name_firma,
            'company_2' => $this->ad_name_firma_2,
            'company_co' => $this->ad_name_firma_co,
            'company_unloading_point' => $this->ad_name_firma_abladestelle,
            'company_goods_income' => $this->ad_name_firma_wareneingang,
            'company_division' => $this->ad_name_firma_abteilung,
            'street' => $this->ad_anschrift_strasse,
            'no' => $this->ad_anschrift_hausnummer,
            'zip' => $this->ad_anschrift_plz,
            'city' => $this->ad_anschrift_ort,
            'floor' => $this->ad_anschrift_etage,
            'enterance' => $this->ad_anschrift_eingang,
        ];
    }
}
