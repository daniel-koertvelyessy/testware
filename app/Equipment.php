<?php

namespace App;

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
        return $this->hasMany(Control::class);
    }
}
