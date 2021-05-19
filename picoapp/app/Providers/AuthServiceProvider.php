<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public static $permissions = [
        'view-users' => ['admin'],
        'create-user' => ['admin'],
        'store-user' => ['admin'],
        'edit-user' => ['admin'],
        'update-user' => ['admin'],
        'delete-user' => ['admin'],

        'view-deployments' => ['admin', 'monitor'],
        'view-deployment' => ['admin', 'monitor'],
        'create-deployment' => ['admin'],
        'store-deployment' => ['admin'],
        'seeinfo-deployment' => ['admin', 'monitor'],
        'check-deployment' => ['admin'],
        'deploy-deployment' => ['admin'],
        'destroy-deployment' => ['admin'],
        'delete-deployment' => ['admin'],

        'view-configfiles' => ['admin', 'monitor'],
        'create-configfile' => ['admin'],
        'store-configfile' => ['admin'],
        'edit-configfile' => ['admin'],
        'update-configfile' => ['monitor'],
        'show-configfile' => ['admin', 'monitor'],
        'delete-configfile' => ['admin'],

        'view-dashboard' => ['admin', 'monitor'],

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability) {
                if ($user->role === 'admin') {
                    return true;
                }
            }
        );

        foreach (self::$permissions as $action => $roles) {
            Gate::define(
                $action,
                function (User $user) use ($roles) {
                    if (in_array($user->role, $roles)) {
                        return true;
                    }
                }
            );
        };

        # enable user to edit its own profile 
        Gate::define('edit-user', function (User $user, User $edited) {

            if ($user->id == $edited->id) {
                return true;
            }
            else {
                return false;
            }
        });
    }
}
