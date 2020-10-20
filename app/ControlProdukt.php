<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlProdukt extends Model
{
    public function Produkt() {
        return $this->belongsTo(Produkt::class);
    }

    public function addProdukt(Produkt $produkt) {

        dd($produkt);

    }


}
