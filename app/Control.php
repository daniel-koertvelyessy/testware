<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }
}
