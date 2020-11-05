<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentEventItem extends Model
{
    protected $fillable = [

    ];

    use SoftDeletes;

    public function events() {
        return $this->belongsTo(EquipmentEvent::class);
    }

}
