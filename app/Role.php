<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Role extends Model
{
    protected $guarded = [];

    protected $casts = ['is_super_user' => 'boolean'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function addNew(Request $request)
    {
        $this->label = $request->label;
        $this->name = $request->name;
        $this->is_super_user = $request->is_super_user ?? 0;
        $this->save();

        return $this->id;
    }
}
