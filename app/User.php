<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public const LOCALES = [
        'de' => 'Deutsch',
        'en' => 'English',
        'nl' => 'Nederlands',
        'th' => 'Tailand',
        'fr' => 'French'
    ];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'locale'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        // gibt die Profile Daten zurück
        return $this->hasOne(Profile::class);
    }

    public function AnforderungControlItem()
    {
        return $this->hasOne(AnforderungControlItem::class);
    }

    public function EquipmentQualifiedUser()
    {
        return $this->hasMany(EquipmentQualifiedUser::class);
    }

    public function hasEquipment()
    {
        return $this->hasManyThrough('Equipment','EquipmentQualifiedUser');
    }

    public function instructedOnEquipment()
    {
        return $this->hasMany(EquipmentInstruction::class);
    }

    public function isInstructed($id)
    : bool
    {
        return EquipmentInstruction::where([
            ['equipment_instruction_trainee_id',$this->id],
            ['equipment_id',$id]
        ])->count() >0;
    }

    public function isQualified($id)
    : bool
    {
        return EquipmentQualifiedUser::where([
            ['user_id',$this->id],
            ['equipment_id',$id]
        ])->count() >0;
    }

    public function isInstructedForProduct($id)
    : bool
    {
        return EquipmentInstruction::where([
                ['equipment_instruction_trainee_id',$this->id],
                ['equipment_id',$id]
            ])->count() >0;
    }

    public function isQualifiedForProduct($id)
    : bool
    {
        return ProductQualifiedUser::where([
                ['user_id',$this->id],
                ['produkt_id',$id]
            ])->count() >0;
    }
}
