<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $order;
    public $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $order, $attachment = null)
    {
        $this->customer = $customer;
        $this->order = $order;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = env('APP_NAME').' - Payment Succesful';
        $message = $this->subject($subject)
            ->view('mail.notification.paymentSuccesful');

        if(!empty($this->attachment)){
            $message->attach($this->attachment);
        }
        
        return $message;
    }
}
