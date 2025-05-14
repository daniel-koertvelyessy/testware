<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ControlProdukt extends Model
{
    protected $fillable = [
        'produkt_id',
    ];
    public function Produkt(): BelongsTo
    {
        return $this->belongsTo(Produkt::class);
    }


}
