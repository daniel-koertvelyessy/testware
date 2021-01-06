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

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::saving(function (Room $room) {
            Cache::forget('app-get-current-amount-Room');
        });
        static::updating(function (Room $room) {
            Cache::forget('app-get-current-amount-Room');
        });
    }

    public function search($term) {
        return Room::where('r_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('r_name_lang', 'like', '%' . $term . '%')
            ->orWhere('r_name_text', 'like', '%' . $term . '%')
            ->get();
    }


    public function building()
    {
        return $this->belongsTo(Building::class);
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

    public function location() {
        return $this->building()->with('Location');
    }

    public function Standort() {
        return $this->hasOne(Standort::class, 'std_id','standort_id');
    }

}
