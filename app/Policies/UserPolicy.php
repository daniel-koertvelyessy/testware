<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function isSysAdmin()
    : Response
    {
        return Auth::user()->role_id === 1
            ? Response::allow()
            : Response::deny('nope, you cannot do that!');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function isAdmin(User $user)
    : Response
    {

        if ($user->role_id===1){
            return Response::allow();
        }
        $allow = false;
        foreach($user->roles as $role){
            if ($role->id === 1){
                $allow = true;
            }
        }

        return $allow
            ? Response::allow()
            : Response::deny('nope, you cannot do that!');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return true;  //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @param  User $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User $user
     * @param  User $model
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  User  $model
     *
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
