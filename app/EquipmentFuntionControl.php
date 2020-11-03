<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentFuntionControl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'function_control_date',
        'function_control_firma',
        'function_control_pass',
        'equipment_id',
    ];

    public function firma() {
        return $this->belongsTo(Firma::class,'function_control_firma');
    }

}
