<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktKategorie extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
    }

    public function ProduktKategorieParam()
    {
        return $this->hasMany(ProduktKategorieParam::class);
    }


}
