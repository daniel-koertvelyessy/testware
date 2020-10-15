<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anforderung extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function LocationAnforderung()
    {
        return $this->hasMany(LocationAnforderung::class);
    }

    public function Equipment()
    {
        return $this->hasMany(Equipment::class);
    }



    public function Verordnung()
    {
        return $this->belongsTo(Verordnung::class);
    }


    public function AnforderungControlItem() {
        return $this->hasMany(AnforderungControlItem::class);
    }

    public function ControlInterval() {
        return $this->belongsTo(ControlInterval::class);
    }

    public function AnforderungType() {
        return $this->hasMany(AnforderungType::class);
    }
}
