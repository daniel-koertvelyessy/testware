<?php

namespace App\Http\Resources\companies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
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
            'created' => (string) $this->created_at,
            'updated' => (string) $this->updated_at,
            'label' => $this->fa_label,
            'name' => $this->fa_name,
            'description' => $this->fa_description,
            'creditor_no' => $this->fa_kreditor_nr,
            'debitor_no' => $this->fa_debitor_nr,
            'vat' => $this->fa_vat,
            'address_id' => $this->adresse_id,
        ];
    }
}
