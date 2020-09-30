<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktParam extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkte()
    {
        return $this->belongsTo(Produkt::class);
    }
}
