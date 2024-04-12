<?php

namespace App\Http\Resources\equipment;

use Illuminate\Http\Resources\Json\JsonResource;

class Equipment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'uid' => $this->eq_uid,
            'installed' => (string)$this->installed_at,
            'name' => $this->eq_name,
            'inventory' => $this->eq_inventar_nr,
            'serial' => $this->eq_serien_nr,
            'status' => $this->EquipmentState->estat_label,
            'link' => route('api.v1.equipment.show',$this)
        ];

    }
}
