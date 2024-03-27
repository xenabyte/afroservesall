<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;

class PaymentCheckout extends Notification{

    /**
     * @var Notification
     *
     * Send email notificaton to users for successful transaction
     */

    use Queueable;
    private $message;


     public function __construct($message){
        $this->message = $message;
     }

     /**
     * Get the notification's delivery channels.
     *
     *@param  mixed  $notifiable
     * @return array

     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){
        return (new MailMessage)
        ->line($this->message['greetings'])->line($this->message['text'])->line($this->message['details'])->line($this->message['finalText']);
    }
}
