<?php

namespace App\Http\Resources\control;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Control extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'uid' => $this->eq_uid,
            'installed' => (string) $this->installed_at,
            'name' => $this->eq_name,
            'inventory' => $this->eq_inventar_nr,
            'serial' => $this->eq_serien_nr,
            'status' => $this->EquipmentState->estat_label,
            'link_api' => route('api.v1.equipment.show', $this),
            'link_web' => route('equipment.show', $this),

        ];

    }
}
