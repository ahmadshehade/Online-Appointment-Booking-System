<?php

namespace App\Listeners\Roles;

use App\Events\Roles\AssignRoleEvent;
use App\Mail\Roles\AssignRoleMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssignRoleListener
{


    /**
     * Handle the event.
     */
    public function handle(AssignRoleEvent $event): void
    {
        try {
            Mail::to($event->user->email)->send(new AssignRoleMail($event->user));
        } catch (\Exception $e) {
            Log::error('Filed To Send Mail In Role <=> Assign Roles  To User.'.$e->getMessage());
        }
    }
}
