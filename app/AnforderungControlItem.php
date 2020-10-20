<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnforderungControlItem extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    public function Anforderung() {
        return $this->belongsTo(Anforderung::class);
}
    public function ControlEquipment() {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function user() {
        return $this->belongsTo(User::class,'aci_contact_id');
    }

    public function firma() {
        return $this->belongsTo(Firma::class);
    }

}
