<?php

namespace App\Providers;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin',function(User $user){
            return $user->hasRole(UserRoles::SuperAdmin);
        });
    }
}
