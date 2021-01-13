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

    public function addAPIRoomType(Request $request)
    {
        $this->rt_label = $request->type['label'];
        $this->rt_name = (isset($request->type['name'])) ? $request->type['name'] : null;
        $this->rt_name_text = (isset($request->type['description'])) ? $request->type['description'] : null;
        $this->save();
        return $this->id;
    }

    public function addNewType($data)
    {
        $this->rt_label = $data['label'];
        $this->rt_name = (isset($data['name'])) ? $data['name'] : null;
        $this->rt_name_text = (isset($data['description'])) ? $data['description'] : null;
        $this->save();
        return $this->id;
    }


}
