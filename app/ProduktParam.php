<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktParam extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkt()
    {
        return $this->belongsTo(Produkt::class);
    }
}
