<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    public function profile()
    {
        return $this->belongsTo(Location::class);
    }

    public function location()
    {
        return $this->hasMany(Location::class);
    }

    public function addresstyp()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function firma() {
        return $this->hasMany(Firma::class);
    }
}
