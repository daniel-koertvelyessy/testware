<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firma extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function path()
    {
        return view('admin.firma.show', $this);
    }


    public function Adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function produkt()
    {
        return $this->belongsToMany(Produkt::class);
    }

    public function getFirmaAdressData($aid) {
        return Adresse::find($aid)->first();
    }

}
