<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnforderungType extends Model
{
    protected $guarded = [];

    public function anforderung() {
        return $this->belongsTo(Anforderung::class);
    }
}
