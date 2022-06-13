<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitud de Cotización')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->to(config('mail.to.address'), config('mail.to.name'))
            ->view('correos.cotizacion')
            ->with('mailData', $this->mailData);
    }
}
