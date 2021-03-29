<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tag extends Model
{
    public function addNew(Request $request)
    {
        $this->label = $request->label;
        $this->name = $request->name;
        $this->color = $request->color;
        $this->save();
        return $this->id;
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class,'note_tag')->withTimestamps();
    }
}
