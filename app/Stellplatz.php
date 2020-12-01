<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Stellplatz extends Model
{
    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::saving(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
        });
        static::updating(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
        });
    }

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
    public function StellplatzTyp()
    {
        return $this->belongsTo(StellplatzTyp::class);
    }


}
