<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verordnung extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function Anforderung()
    {
        return $this->hasMany(Anforderung::class);
    }

    public function search($term) {
        return Verordnung::where('vo_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('vo_name_lang', 'like', '%' . $term . '%')
            ->orWhere('vo_nummer', 'like', '%' . $term . '%')
            ->orWhere('vo_stand', 'like', '%' . $term . '%')
            ->orWhere('vo_name_text', 'like', '%' . $term . '%')
            ->get();
    }

}
