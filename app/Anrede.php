<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anrede extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function Contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
