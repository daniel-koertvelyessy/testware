<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktKategorieParam extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function ProduktKategorie()
    {
        return $this->belongsTo(ProduktKategorie::class);
    }
}
