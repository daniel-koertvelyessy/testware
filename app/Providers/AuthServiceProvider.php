<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('use_installer', function (User $user){
            return $user->role_id === 1;
        });

        Gate::define('isSysAdmin', function ($user){
            if($user->role_id === 1){
                return true ;
            }
            return false;
        });

        /**/

/*
        Gate::before(function ($user, $ability){
            if($user->role_id === 1 && in_array($ability,['use_installer', 'isSysAdmin'])){
                return true ;
            }
        });
*/

    }
}
