<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produkt extends Model {
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'prod_nummer';
    }

    public function ProduktKategorie() {
        return $this->belongsTo(ProduktKategorie::class);
    }

    public function ProduktDoc() {
        return $this->hasMany(ProduktDoc::class);
    }

    public function ProduktState() {
        return $this->belongsTo(ProduktState::class);
    }

    public function path() {
        return route('produkt.show', $this);
    }

    public function ProduktParam() {
        return $this->hasMany(ProduktParam::class);
    }

    public function ProduktAnforderung() {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function firma() {
        return $this->belongsToMany(Firma::class);
    }


    public function ControlProdukt() {
        return $this->hasOne(ControlProdukt::class);
    }

    public function Equipment() {
        return $this->hasMany(Equipment::class);
    }


}
