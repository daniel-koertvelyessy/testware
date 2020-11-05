<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentInstruction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }
}
