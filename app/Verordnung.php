<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verordnung extends Model
{
    protected $guarded = [];

    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }


}
