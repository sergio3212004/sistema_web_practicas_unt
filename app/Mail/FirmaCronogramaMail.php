<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirmaCronogramaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;

    /**
     * Create a new message instance.
     */
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $asunto = $this->datos['tipo'] === 'jefe'
            ? 'Solicitud de Firma - Plan de Prácticas'
            : 'Solicitud de Firma - Plan de Prácticas (Profesor)';

        return $this->subject($asunto)
            ->view('emails.firma-cronograma');
    }
}
