<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Stellplatz extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
        });
        static::updating(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
        });
    }

    public function search($term)
    {
        return Stellplatz::where('sp_label', 'like', '%' . $term . '%')
            ->orWhere('sp_name', 'like', '%' . $term . '%')
            ->orWhere('sp_name_text', 'like', '%' . $term . '%')
            ->get();
    }
    public function Room()
    {
        return $this->belongsTo(Room::class);
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

    public function Storage()
    {
        return $this->hasOne(Storage::class, 'storage_uid', 'storage_id');
    }
    public function countTotalEquipmentInCompartment()
    {
        Cache::remember(
            'countTotalEquipmentInCompartment'.$this->id,
            now()->addSeconds(30),
            function () {
                return $this->Storage->countReferencedEquipment();
            }
        );
    }
}
