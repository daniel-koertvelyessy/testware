<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnforderungType extends Model
{
    protected $guarded = [];

    public function anforderung(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Anforderung::class);
    }
}
