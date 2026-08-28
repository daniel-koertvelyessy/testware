<?php

namespace App\Http\Resources\equipment;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentPortalList extends JsonResource
{
    public function toArray($request)
    {
        // nächste offene Prüfung
        $nextDue = $this->ControlEquipment
            ->whereNull('deleted_at')
            ->sortBy('qe_control_date_due')
            ->first();

        return [
            'uid'            => $this->eq_uid,
            'inventory'      => $this->eq_inventar_nr,
            'name'           => $this->eq_name,
            'status'         => $this->EquipmentState->estat_label,
            'status_color'   => $this->EquipmentState->estat_color,
            'is_test_device' => (bool) $this->produkt->ControlProdukt,
            'storage'        => $this->storage?->storage_label ?? '–',
            'next_due_at'    => $nextDue?->qe_control_date_due ?? null,
            'link_web'       => route('equipment.show', $this),
        ];
    }
}