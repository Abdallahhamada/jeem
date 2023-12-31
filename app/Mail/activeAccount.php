<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class activeAccount extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails/active/active')

            ->subject('Active Account && Jeem Company')

            ->with([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'otp_email' => $this->user['otp_email'],
                'type' => $this->user['type']
            ]);
    }
}
