<?php

namespace App\Http\Resources\equipment;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Equipment master data plus its inspection history for the auditor portal.
 *
 * Intended for `portal_show/{uid}`: one equipment record with every
 * control-equipment entry (open, completed and archived) so a portal client
 * can render a detail flyout without linking out to the Testware UI (to which
 * external auditors may not have access).
 */
class EquipmentPortalShow extends JsonResource
{
    public function toArray($request)
    {
        $history = $this->ControlEquipment()
            ->withTrashed()
            ->with('Anforderung')
            ->get()
            ->map(function ($ce) {
                return [
                    'requirement'     => $ce->Anforderung?->an_label,
                    'last_at'         => $ce->qe_control_date_last,
                    'due_at'          => $ce->qe_control_date_due,
                    'status'          => $this->inspectionStatus($ce),
                    'completed_at'    => $ce->deleted_at,
                    'archived_at'     => $ce->archived_at,
                ];
            })
            ->values();

        return [
            'uid'            => $this->eq_uid,
            'inventory'      => $this->eq_inventar_nr,
            'name'           => $this->eq_name,
            'serial'         => $this->eq_serien_nr,
            'status'         => $this->EquipmentState?->estat_label,
            'status_color'   => $this->EquipmentState?->estat_color,
            'is_test_device' => (bool) $this->produkt->ControlProdukt,
            'storage'        => $this->storage?->storage_label ?? '–',
            'installed_at'   => $this->installed_at,
            'purchased_at'   => $this->purchased_at,
            'price'          => $this->eq_price,
            'link_web'       => route('equipment.show', $this),
            'history'        => $history,
        ];
    }

    private function inspectionStatus($ce): string
    {
        if ($ce->deleted_at) {
            return 'completed';
        }

        return $ce->archived_at ? 'archived' : 'open';
    }
}
