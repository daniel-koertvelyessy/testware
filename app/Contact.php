<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function firma()
    {
        return $this->BelongsTo(Firma::class);
    }
}
