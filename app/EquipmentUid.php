<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EquipmentUid extends Model
{
    protected $fillable = [
        'equipment_uid',
        'equipment_id',
    ];

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function addNew($equipment_uid, $equipment_id){
        $this->equipment_uid = $equipment_uid;
        $this->equipment_id = $equipment_id;
        $this->save();
    }

}
