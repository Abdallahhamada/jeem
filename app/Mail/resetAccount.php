<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $token;

    public function __construct($token,$type,$name)
    {
        $this->token = $token;

        $this->type = $type;

        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails/reset/reset')

            ->subject('Change Password && Jeem Company')

            ->with([
                'token' => $this->token,
                'type' => $this->type,
                'name' => $this->name
            ]);
    }
}
