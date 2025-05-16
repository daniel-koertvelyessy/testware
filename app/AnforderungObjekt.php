<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnforderungObjekt extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Anforderung()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function Storage()
    {
        return $this->hasMany(Storage::class);
    }
}
