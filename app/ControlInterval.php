<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ControlInterval extends Model
{
    public function Anforderung(): HasMany
    {
        return $this->hasMany(Anforderung::class);
    }
}
