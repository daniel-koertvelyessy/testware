<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdressFirma extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function firma()
    {
        return $this->belongsTo(Firma::class);
    }

    public function Address()
    {
        return $this->hasMany(Address::class);
    }
}
