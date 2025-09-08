<?php

namespace App\Mail\Permissions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignPermissionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
      public  $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

   
    /**
     * Summary of build
     * @return AssignPermissionMail
     */
    public function build(){
      return $this->subject('Permission')
      ->view('emails.Permissions.assign-permission')
      ->with(['user'=>$this->user]);
    }
}
