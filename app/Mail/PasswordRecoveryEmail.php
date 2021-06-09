<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRecoveryEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $data;
    public $token;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $data, $token, $email)
    {
        $this->type = $type;
        $this->data = $data;
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailSendNow = $this->subject(env('APP_NAME').' - Password Reset Link')->view('email-templates.password-reset')
        ->with([
            'type' => $this->type,
            'data' => $this->data,
            'token' => $this->token,
            'email' => $this->email
        ]);
        return $emailSendNow;
    }
}
