<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\App;

class NewUserWelcome extends Mailable
{
    use Queueable, SerializesModels;
    public $userName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailSendNow = $this->subject('Welcome to - '.env('APP_NAME').'')->view('email-templates.welcome')
        ->with([
            'userName' => $this->userName
        ]);
        return $emailSendNow;
    }
}
