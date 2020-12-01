<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StellplatzTyp extends Model
{
    protected $guarded = [];

    public function stellplatz()
    {
        return $this->hasMany(Stellplatz::class);
    }

}
