<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProduktAnforderungVerordnung extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-database');
            Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');
            Cache::forget('system-status-objects');
        });
    }

    public function ProduktKategorie()
    {
        return $this->belongsTo(ProduktKategorie::class);
    }

    public function Verordnung()
    {
        return $this->hasMany(Verordnung::class);
    }
}
