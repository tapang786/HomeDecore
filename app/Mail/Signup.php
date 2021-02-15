<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Signup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $signupdata;
    public function __construct($signupdata)
    {
        $this->signupdata=$signupdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->signupdata['fromemail'],$this->signupdata['name'])
        ->subject($this->signupdata['subject'])
        ->markdown('emails.user.signup');
    }
}
