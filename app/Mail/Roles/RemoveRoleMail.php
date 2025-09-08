<?php

namespace App\Mail\Roles;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RemoveRoleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

     public function build(){
        return $this->subject("Roles")
        ->view('emails.Roles.remove-role')
        ->with(['user'=>$this->user]);
     }
}
