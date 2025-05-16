<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationAnforderung extends Model
{
    protected $fillable = [
        'location_id',
        'anforderung_id',
    ];

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

    public function Anforderung()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function AnforderungControlItem()
    {
        return $this->hasMany(AnforderungControlItem::class);
    }
}
