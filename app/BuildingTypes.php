<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingTypes extends Model
{
    protected $guarded = [];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
