<?php

namespace App\Listeners\Permissions;

use App\Events\Permissions\RemovePermissionEvent;
use App\Mail\Permissions\RemovePermissionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RemovePermissionListener
{


    /**
     * Handle the event.
     */
    public function handle(RemovePermissionEvent $event): void
    {
        try {
            Mail::to($event->user->email)->send(new RemovePermissionMail($event->user));
        } catch (\Exception $e) {
            Log::error('Fail To Sent Mail To Permission <=> RemovePermission' . $e->getMessage());
        }
    }
}
