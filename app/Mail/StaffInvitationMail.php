<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffInvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $staffID;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $staffID)
    {
        $this->name = $name;
        $this->email = $email;
        $this->staffID = $staffID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailSendNow = $this->subject('Invitation - '.env('APP_NAME').'')->view('email-templates.staff_invitation')
        ->with([
            'name' => $this->name,
            'email' => $this->email,
            'staffID' => $this->staffID
        ]);
        return $emailSendNow;
    }
}
