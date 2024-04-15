<?php

namespace App\Http\Resources\equipment;

use App\ControlEquipment;
use Illuminate\Http\Resources\Json\JsonResource;

class TestEquipment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'uid'        => $this->eq_uid,
            'installed'  => (string)$this->installed_at,
            'name'       => $this->eq_name,
            'inventory'  => $this->eq_inventar_nr,
            'serial'     => $this->eq_serien_nr,
            'status'     => $this->EquipmentState->estat_label,
            'teststatus' => ControlEquipment::where('equipment_id', $this->id)->get()->map(function ($testStatusItem) {
                return [
                    'last_at'     => $testStatusItem->qe_control_date_due,
                    'due_at'      => $testStatusItem->qe_control_date_last,
                    'requirement' => $testStatusItem->Anforderung->an_label,
                    'initial'     => $testStatusItem->Anforderung->is_initial_test,
                    'external'    => $testStatusItem->Anforderung->is_external_test === true,
                ];
            }),
            'link_api'   => route('api.v1.equipment.show', $this),
            'link_web'   => route('equipment.show', $this)

        ];

    }
}
