<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirmaProdukt extends Model
{
    protected $table = 'firma_produkt';

    protected $fillable = ['firma_id', 'produkt_id'];

    public function Firma() {
        return $this->belongsToMany(Firma::class);
    }
    public function Produkt() {
        return $this->belongsToMany(Produkt::class);
    }
}
