<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public const LOCALES = [
        'de' => 'Deutsch',
        'en' => 'English',
        'nl' => 'Nederlands',
        'th' => 'Tailand',
        'fr' => 'France'
    ];

    public const LANGS = [
        'Deutsch'    => 'de',
        'English'    => 'en',
        'Nederlands' => 'nl',
        'Tailand'    => 'th',
        'France'     => 'fr'
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

    public static function makePassword()
    {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%|{}*_"), 0, 8);

    }

    public function notes()
    {
        return $this->hasMany(Note::class);
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
        $this->role_id = 0;
        $this->user_theme = 'css/tbs.css';
        $this->locale = $request->locales;
        $this->password = Hash::make($request->password);
        $this->save();

        $this->roles()->attach([1]);

        return $this->id;
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * @param  Request $request
     *
     * @return mixed
     */
    public function addInstallerUser(array $details)
    {
        if ($this->checkUserExists($details['username'], $details['email'])) return 0;
        $this->name = $details['name'];
        $this->email = $details['email'];
        $this->username = $details['username'];
        $this->role_id = (isset($details['role_id'])) ? 1 : 0;
        $this->locale = $details['locales'];
        $this->password = Hash::make($details['password']);
        $this->save();

        $this->roles()->attach([1]);
        $this->roles()->attach([4]);

        return $this->id;
    }

    public function checkUserExists($username, $email)
    : bool
    {

        return User::where('username', $username)->count() > 0 || User::where('email', $email)->count() > 0;

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
