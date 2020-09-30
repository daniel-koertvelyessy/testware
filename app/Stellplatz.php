<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stellplatz extends Model
{
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function stellplatztypes()
    {
        return $this->belongsTo(StellplatzTyp::class);
    }
}
