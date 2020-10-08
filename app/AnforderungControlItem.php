<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnforderungControlItem extends Model
{
    protected $guarded = [];

    public function Anforderung() {
        return $this->belongsTo(Anforderung::class);
}
    public function ControlEquipment() {
        return $this->belongsTo(ControlEquipment::class);
    }

}
