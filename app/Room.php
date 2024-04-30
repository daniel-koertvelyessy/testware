<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Room extends Model
{
    use SoftDeletes, Sortable;

    //

    public $sortable = [
        'created_at',
        'updated_at',
        'r_label',
        'r_name',
        'r_description',
    ];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Room $room) {
            Cache::forget('app-get-current-amount-Room');
            Cache::forget('countTotalEquipmentInRoom');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function (Room $room) {
            Cache::forget('app-get-current-amount-Room');
            Cache::forget('countTotalEquipmentInRoom');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }


    public function path()
    {
        return route('room.show', $this);
    }

    public function RoomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function stellplatzs()
    {
        return $this->hasMany(Stellplatz::class);
    }

    public function location()
    {
        return $this->building()->with('Location');
    }

    public function building()
    {
        return $this->belongsTo(Building::class,'building_id');
    }

    public function Storage()
    {
        return $this->hasOne(Storage::class, 'storage_uid', 'storage_id');
    }

    public function countTotalEquipmentInRoom()
        :int
    {
       return Cache::remember(
            'countTotalEquipmentInRoom' . $this->id,
            now()->addSeconds(30),
            function () {
                $equipCounter = 0;
                $equipCounter += ($this->Storage) ? $this->Storage->countReferencedEquipment() : 0;
                foreach ($this->stellplatzs as $compartment) {
                    $equipCounter += ($compartment->Storage) ? $compartment->Storage->countReferencedEquipment() : 0;
                }
                return $equipCounter;
            }
        );
    }
}
