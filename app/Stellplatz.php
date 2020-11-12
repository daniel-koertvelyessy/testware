<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stellplatz extends Model
{
    protected $guarded = [];

    public function search($term) {
        return Stellplatz::where('sp_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('sp_name_lang', 'like', '%' . $term . '%')
            ->orWhere('sp_name_text', 'like', '%' . $term . '%')
            ->get();
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function stellplatztypes()
    {
        return $this->belongsTo(StellplatzTyp::class);
    }
}
