<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoomType extends Model
{
    protected $guarded = [];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function addAPIRoomType(Request $request) {
        $this->rt_name_kurz = $request->type['label'];
        $this->rt_name_lang = (isset($request->type['name'])) ? $request->type['name'] : null;
        $this->rt_name_text = (isset($request->type['description'])) ? $request->type['description'] : null;
        $this->save();
        return $this->id;
    }
}
