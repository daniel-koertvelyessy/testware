<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
