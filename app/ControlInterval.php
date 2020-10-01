<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlInterval extends Model
{
    public function Anforderung() {
        return $this->hasMany(Anforderung::class);
    }
}
