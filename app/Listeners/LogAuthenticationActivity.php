<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\User; 

use function activity;

class LogAuthenticationActivity
{
    public function handleLogin(Login $event): void
    {
        /** @var User $user */
        $user = $event->user; 

        activity('auth')
            ->causedBy($user) 
            ->withProperties([
                'ip' => request()->ip(),
                'agent' => request()->userAgent(),
            ])
            ->log('Successfully Login');
    }

    public function handleLogout(Logout $event): void
    {
        /** @var User $user */
        $user = $event->user;

        activity('auth')
            ->causedBy($user)
            ->withProperties([
                'ip' => request()->ip(),
                'agent' => request()->userAgent(),
            ])
            ->log('Successfully Logout');
    }
}
