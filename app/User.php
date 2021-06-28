<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

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

    public function notes()
    {
        return $this->hasMany(Note::class);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'locale'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-counter');
        });
        static::updating(function () {
            Cache::forget('system-status-counter');
        });
    }

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
        return $this->hasManyThrough('Equipment', 'EquipmentQualifiedUser');
    }

    public function instructedOnEquipment()
    {
        return $this->hasMany(EquipmentInstruction::class);
    }

    public function isInstructed($id)
    : bool
    {
        return EquipmentInstruction::where([
                [
                    'equipment_instruction_trainee_id',
                    $this->id
                ],
                [
                    'equipment_id',
                    $id
                ]
            ])->count() > 0;
    }

    public function isQualified($id)
    : bool
    {
        return EquipmentQualifiedUser::where([
                [
                    'user_id',
                    $this->id
                ],
                [
                    'equipment_id',
                    $id
                ]
            ])->count() > 0;
    }

    public function isInstructedForProduct($id)
    : bool
    {
        return EquipmentInstruction::where([
                [
                    'equipment_instruction_trainee_id',
                    $this->id
                ],
                [
                    'equipment_id',
                    $id
                ]
            ])->count() > 0;
    }

    public function isQualifiedForProduct($id)
    : bool
    {
        return ProductQualifiedUser::where([
                [
                    'user_id',
                    $this->id
                ],
                [
                    'produkt_id',
                    $id
                ]
            ])->count() > 0;
    }

    /**
     * The roles that belong to the user.
     */
    public function roleUser()
    : BelongsToMany
    {
        return $this->belongsToMany('App\RoleUser');
    }

    public function addNew(Request $request)
    {
        $this->name = $request->name;
        $this->email = $request->email;
        $this->username = $request->username;
        $this->role_id = $request->role_id;
        $this->locale = $request->locales;
        $this->password = password_hash($request->password, PASSWORD_DEFAULT);
        $this->save();

        $this->roles()->attach([$request->role_id]);

        return $this->id;
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function removeUser(Request $request)
    : bool
    {
        $this->authorize('isAdmin', Auth()->user());

        $user = User::find($request->id);
        $deleteRoles = $user->roles()->detach();
        $deleteUser = $user->delete();

        return $deleteRoles && $deleteUser;

    }

    public function isAdmin()
    {
        /**
         * check if user is a SysAdmin. If so skip further checks
         */
        if ($this->role_id === 1) return true;

        /**
         * check if user has a role of Administrator
         */
        foreach ($this->roles as $role) {
            if ($role->is_super_user) {
                return true;
            }
        }
        return false;
    }

    public function isSysAdmin()
    {
        return $this->role_id === 1;
    }

    public function updatePassword($newPassword, User $user)
    {
        $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->update();
    }

}
