<?php

namespace App\Providers;

use App\Enum\UserRoles;
use App\Listeners\LogAuthenticationActivity;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Summary of listen
     * @var array
     */
    protected $listen = [
        Login::class => [
            LogAuthenticationActivity
            ::class . '@handleLogin',
        ],
        Logout::class => [
            LogAuthenticationActivity::class . '@handleLogout',
        ],
    ];
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
        Gate::define('access-admin', function (User $user) {
            return $user->hasRole(UserRoles::SuperAdmin);
        });
    }
}
