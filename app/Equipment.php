<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Equipment extends Model
{
    protected $guarded = [];

    //    protected $table = 'equipments';

    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'eq_inventar_nr',
        'eq_serien_nr',
        'eq_ibm',
        'eq_uid',
        'produkt_id',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Equipment $equipment) {
            Cache::forget('app-get-current-amount-Equipment');
        });
        static::updating(function (Equipment $equipment) {
            Cache::forget('app-get-current-amount-Equipment');
        });
    }

    static function getControlEquipmentList()
    {
        return \DB::table('equipment')->select(
            'equipment.eq_inventar_nr',
            'equipment.id',
            'control_equipment.qe_control_date_due',
            'produkts.prod_label'
        )
            ->join('control_produkts', 'equipment.produkt_id', '=', 'control_produkts.produkt_id')
            ->join('control_equipment', 'control_equipment.equipment_id', '=', 'equipment.id')
            ->join('produkts', 'equipment.produkt_id', '=', 'produkts.id')
            ->get();
    }

    public function search($term)
    {
        return Equipment::where('eq_inventar_nr', 'like', '%' . $term . '%')
            ->orWhere('eq_serien_nr', 'like', '%' . $term . '%')
            ->orWhere('eq_inventar_nr', 'like', '%' . $term . '%')
            ->orWhere('eq_text', 'like', '%' . $term . '%')
            ->orWhere('eq_uid', 'like', '%' . $term . '%')
            ->get();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'eq_inventar_nr';
    }

    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function produktDetails()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id', 'id', 'EquipmentDetails');
    }

    public function EquipmentParam()
    {
        return $this->hasMany(EquipmentParam::class);
    }

    public function EquipmentState()
    {
        return $this->belongsTo(EquipmentState::class);
    }

    public function EquipmentHistory()
    {
        return $this->hasMany(EquipmentHistory::class);
    }

    public function showStatus()
    {
        return '<span class="' . $this->EquipmentState->estat_icon . ' text-' . $this->EquipmentState->estat_color . '"></span>';
    }

    public function standort()
    {
        return $this->belongsTo(Standort::class);
    }

    public function control()
    {
        return $this->hasMany(ControlEvent::class);
    }

    public function ControlEquipment()
    {
        return $this->hasMany(ControlEquipment::class);
    }

    public function EquipmentUid()
    {
        return $this->hasOne(EquipmentUid::class);
    }

    public function hasUser()
    {
        return $this->hasManyThrough('User', 'EquipmentQualifiedUser');
    }
}
