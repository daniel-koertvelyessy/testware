<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Stellplatz extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
            Cache::forget('system-status-counter');
        });
        static::updating(function (Stellplatz $stellplatz) {
            Cache::forget('app-get-current-amount-Stellplatz');
            Cache::forget('system-status-counter');
        });
    }

    public function search($term)
    {
        return Stellplatz::whereRaw('lower(sp_label) like ?', '%' .strtolower( $term) . '%')
                         ->orWhereRaw('lower(sp_name) like ?', '%' .strtolower( $term) . '%')
                         ->orWhereRaw('lower(sp_description) like ?', '%' .strtolower( $term) . '%')
                         ->get();
    }

    public function Room()
    {
        return $this->belongsTo(Room::class);
    }

    public function path()
    {
        return route('stellplatz.show', $this);
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
            'countTotalEquipmentInCompartment' . $this->id,
            now()->addSeconds(30),
            function () {
                return $this->Storage->countReferencedEquipment();
            }
        );
    }
}
