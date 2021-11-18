<?php

namespace App\Jobs;

use App\Mail\resetAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class resetPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $token;

     protected $email;

     protected $type;

     protected $name;

    public function __construct($type,$token,$email,$name)
    {
        $this->token = $token;

        $this->type = $type;

        $this->email = $email;

        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new resetAccount($this->token,$this->type,$this->name));
    }
}
