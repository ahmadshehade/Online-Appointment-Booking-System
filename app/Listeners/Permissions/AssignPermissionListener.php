<?php

namespace App\Listeners\Permissions;

use App\Events\Permissions\AssignPermissionEvent;
use App\Mail\Permissions\AssignPermissionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssignPermissionListener
{

    /**
     * Handle the event.
     */
    public function handle(AssignPermissionEvent $event): void
    {
        try {
            Mail::to($event->user->email)->send(new AssignPermissionMail($event->user));
        } catch (\Exception $exception) {
            Log::error('Fail To Send Mail To New Permission <=> AssignPermission.' . $exception->getMessage());
        }
    }
}
