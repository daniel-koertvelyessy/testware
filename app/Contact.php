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

    public function fullName()
    {
        return $this->con_vorname . ' '. $this->con_name;
    }
}
