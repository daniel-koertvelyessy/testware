<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land extends Model
{
    use SoftDeletes;

    public function adress(): HasMany
    {
        return $this->hasMany(Adresse::class);
    }
}
