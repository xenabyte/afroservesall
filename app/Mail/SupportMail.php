<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notificationType;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notificationType, $data = null)
    {
        $this->notificationType = $notificationType;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = env('APP_NAME').' - '. $this->notificationType;
        $message = $this->subject($subject)
            ->view('mail.notification.supportMail');

        return $message;
    }
}
