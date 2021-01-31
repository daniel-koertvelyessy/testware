<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NoteType extends Model
{
    protected $guarded=[];

    public function addType(Request $request)
    : bool
    {
        $this->label = $request->label;
        $this->name  = $request->name ?? null;
        $this->description  = $request->description ?? null;
        return $this->save();
    }
}
