<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduktState extends Model
{
    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
 }
}
