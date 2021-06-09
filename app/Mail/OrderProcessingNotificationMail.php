<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderProcessingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $userData;
    public $orderData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData, $orderData)
    {
        $this->userData = $userData;
        $this->orderData = $orderData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailSendNow = $this->subject('Update about your order - '.env('APP_NAME').'')->view('email-templates.order_updates')
        ->with([
            'userData' => $this->userData,
            'orderData' => $this->orderData,
        ]);
        return $emailSendNow;
    }
}
