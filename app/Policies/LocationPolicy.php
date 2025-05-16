<?php

namespace App\Policies;

use App\Location;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;
    /*
        public function before(User $user)
        {
            if ($user->role_id === 1){
                return true;
            }
        }*/

    /**
     * Determine whether the user can view any models.
     *
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     *
     * @return mixed
     */
    public function create(User $user)
    {
        dd($user->roles());
        if ($user->role_id === 1) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     *
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     *
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     *
     * @return mixed
     */
    public function restore(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     *
     * @return mixed
     */
    public function forceDelete(User $user, Location $location)
    {
        //
    }
}
