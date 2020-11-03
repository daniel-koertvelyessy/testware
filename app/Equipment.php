<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    protected $guarded = [];

//    protected $table = 'equipments';

    use SoftDeletes;


    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
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

    public function standort() {
        return $this->belongsTo(Standort::class);
    }

    public function control() {
        return $this->hasMany(ControlEvent::class);
    }

    public function ControlEquipment() {
        return $this->hasMany(ControlEquipment::class);
    }
    public function EquipmentUid() {
        return $this->hasOne(EquipmentUid::class);
    }

    static function getControlEquipmentList()
    {
        return \DB::table('equipment')->select('equipment.eq_inventar_nr','equipment.id',
            'control_equipment.qe_control_date_due',
            'produkts.prod_name_kurz')
            ->join('control_produkts','equipment.produkt_id','=','control_produkts.produkt_id')
            ->join('control_equipment','control_equipment.equipment_id','=','equipment.id')
            ->join('produkts','equipment.produkt_id','=','produkts.id')
            ->get();
    }
}
