<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirmaProdukt extends Model
{
    protected $table = 'firma_produkt';

    protected $fillable = ['firma_id', 'produkt_id'];

    public function Firma() {
        return $this->belongsTo(Firma::class );
    }
    public function Produkt() {
        return $this->belongsTo(Produkt::class);
    }




}
