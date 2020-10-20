<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verordnung extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }


}
