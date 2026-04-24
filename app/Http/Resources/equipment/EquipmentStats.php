<?php

namespace App\Http\Resources\equipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class EquipmentStats extends JsonResource
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
            'status' => $this->EquipmentState->eqs_label,
            'last_tested_at' => $this->ControlEquipment
                ->whereNotNull('deleted_at')  // abgeschlossene Prüfungen
                ->sortByDesc('updated_at')
                ->first()?->updated_at,

            'next_due_at' => $this->ControlEquipment
                ->whereNull('deleted_at')     // offene Prüfungen
                ->sortBy('qe_control_date_due')
                ->first()?->qe_control_date_due,
            'link_api' => route('api.v1.equipment.show', $this),
            'link_web' => route('equipment.show', $this),
        ];
    }
}
