<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentUid extends Model
{
    protected $fillable = [
        'equipment_uid',
        'equipment_id',
    ];

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

}
