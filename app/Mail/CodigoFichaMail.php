<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoFichaMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $codigo;

    public function __construct(int $codigo)
    {
        $this->codigo = $codigo;
    }

    public function build()
    {
        return $this
            ->subject('Código de verificación - Ficha de Prácticas')
            ->view('emails.codigo-ficha');
    }
}
