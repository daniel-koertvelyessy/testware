<?php

namespace App\Http\Resources\equipment;

use App\ControlEquipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\locations\Location as LocationResource;
use App\Http\Resources\equipment\EquipmentShow as EquipmentShowResource;

class EquipmentShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $testlist = [];
        foreach (ControlEquipment::where('equipment_id', $this->id)->get() as $listItem) {
            $testlist[$listItem->id] =
                [
                    'last_at'     => $listItem->qe_control_date_due,
                    'due_at'      => $listItem->qe_control_date_last,
                    'requirement' => $listItem->Anforderung->an_label,
                ];
        }


        return [
            'created'   => (string)$this->created_at,
            'updated'   => (string)$this->updated_at,
            'installed' => (string)$this->installed_at,
            'purchased' => (string)$this->purchased_at,
            'status'    => $this->EquipmentState->estat_label,
            'name'      => $this->eq_name,
            'uid'       => $this->eq_uid,
            'inventory' => $this->eq_inventar_nr,
            'serial'    => $this->eq_serien_nr,
            'price'     => $this->eq_price,
            'storage'   => $this->storage->storage_label,
            'testing'   => $testlist
        ];
    }
}
