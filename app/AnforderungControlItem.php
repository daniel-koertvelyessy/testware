<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class AnforderungControlItem extends Model
{

    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
        'aci_name_kurz',
        'aci_name_lang',
        'aci_task',
    ];

    protected $guarded = [];

    public function search($term) {
        return AnforderungControlItem::where('aci_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('aci_name_lang', 'like', '%' . $term . '%')
            ->orWhere('aci_task', 'like', '%' . $term . '%')
            ->get();
    }

    public function Anforderung() {
        return $this->belongsTo(Anforderung::class);
}
    public function ControlEquipment() {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function user() {
        return $this->belongsTo(User::class,'aci_contact_id');
    }

    public function firma() {
        return $this->belongsTo(Firma::class);
    }

    public function isIncomplete(AnforderungControlItem $anforderungControlItem)
    {
        $isInComplete = false;
        $msgPG = '';
        $msgTo='';
        if ($anforderungControlItem->aci_control_equipment_required === 1) {

            if (ControlProdukt::all()->count() === 0) {
                $msgPG = '<li>Kein Prüfgerät vorhanden!</li>';
                $isInComplete = true;
            }
        }

        if ($anforderungControlItem->aci_value_target_mode === 'eq') {
            if ($anforderungControlItem->aci_value_tol === '' || $anforderungControlItem->aci_value_tol_mod === '')
                $msgTo = '<li>Toleranzangaben sind unvollständig</li>';
            $isInComplete = true;
        }
        return ($isInComplete) ? $msgPG.$msgTo : false;
    }

}
