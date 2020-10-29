<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    //

    protected $guarded = [];


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
        return $this->hasMany(Stellplatz::class)    ;
    }



}
