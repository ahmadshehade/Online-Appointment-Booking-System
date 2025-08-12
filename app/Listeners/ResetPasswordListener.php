<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ResetPasswordListener implements ShouldQueue
{


    /**
     * Handle the event.
     */
    public function handle(ResetPasswordEvent $event): void
    {
        Mail::to($event->user->email)->send(new ResetPasswordMail($event->resetLink));
    }
}
