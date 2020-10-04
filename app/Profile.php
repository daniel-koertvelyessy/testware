<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'ma_nummer',
        'ma_name',
        'ma_name_2',
        'ma_vorname',
        'ma_geburtsdatum',
        'ma_eingetreten',
        'ma_ausgetreten',
        'ma_telefon',
        'ma_mobil',
        'ma_fax',
        'ma_com_1',
        'ma_com_2',
        'group_id',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function path()
    {
        return route('profile.show', $this);
    }
}
