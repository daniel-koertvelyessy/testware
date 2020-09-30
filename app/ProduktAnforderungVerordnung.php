<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduktAnforderungVerordnung extends Model
{
    public function ProduktKategorie()
    {
        return $this->belongsTo(ProduktKategorie::class);
    }

    public function Verordnung()
    {
        return $this->hasMany(Verordnung::class);
    }
}
