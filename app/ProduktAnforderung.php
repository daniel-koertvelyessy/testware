<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktAnforderung extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
    }

    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }

}
