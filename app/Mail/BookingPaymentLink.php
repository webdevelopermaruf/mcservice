<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingPaymentLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $invoice;
    public $paymentUrl;
    public function __construct($invoice, $paymentUrl)
    {
        $this->invoice = $invoice;
        $this->paymentUrl = $paymentUrl;
    }
    public function build()
    {
        return $this->subject('Complete Your Booking Payment')
            ->view('emails.paylink');
    }
}
