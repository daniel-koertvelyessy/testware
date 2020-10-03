<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    protected $guarded = [];

    public function Adresse()
    {
        return $this->hasMany(Adresse::class);
    }
}
