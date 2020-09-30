<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anforderung extends Model
{
    protected $guarded = [];

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function Verordnung()
    {
        return $this->belongsTo(Verordnung::class);
    }


    public function AnforderungControlItem() {
        return $this->hasMany(AnforderungControlItem::class);
    }

    public function ControlInterval() {
        return $this->hasMany(ControlInterval::class);
    }
}
