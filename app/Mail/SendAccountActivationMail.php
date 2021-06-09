<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $userData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailSendNow = $this->subject('Account Activation - '.env('APP_NAME').'')->view('email-templates.account_activated')
        ->with([
            'userData' => $this->userData
        ]);
        return $emailSendNow;
    }
}
