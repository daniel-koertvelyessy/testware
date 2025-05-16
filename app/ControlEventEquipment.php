<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEventEquipment extends Model
{
    protected $guarded = [];

    //    protected $table = 'equipments';

    use SoftDeletes;

    public function Equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function ControlEvent()
    {
        return $this->hasMany(ControlEvent::class);
    }
}
