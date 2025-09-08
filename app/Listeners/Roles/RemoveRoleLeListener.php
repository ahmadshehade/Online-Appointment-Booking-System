<?php

namespace App\Listeners\Roles;

use App\Events\RemoveRoleEvent;
use App\Events\Roles\AssignRoleEvent;
use App\Mail\Roles\RemoveRoleMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RemoveRoleLeListener
{


    /**
     * Handle the event.
     */
    public function handle(RemoveRoleEvent $event): void
    {
        try {
            Mail::to($event->user->email)->send(new RemoveRoleMail($event->user));
        } catch (\Exception $e) {
            Log::error("Filed TO Remove Role From User" . $e->getMessage());
        }
    }
}
