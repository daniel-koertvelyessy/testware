<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduktKategorieProdukt extends Model
{
    public function MaterialKategorie()
    {
        return $this->hasMany(ProduktKategorie::class);
    }

    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
    }
}
