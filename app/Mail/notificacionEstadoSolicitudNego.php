<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notificacionEstadoSolicitudNego extends Mailable
{
    use Queueable, SerializesModels;

    public $objTSolEnvioNego;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($objTSolEnvioNego)
    {
        $this->objTSolEnvioNego = $objTSolEnvioNego;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $style = ['body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;'];
        $titulo = 'NEGOCIACIONES';
        $objTSolEnvioNego = $this->objTSolEnvioNego;

        return $this->subject('NEGOCIACIONES - Administración Electronica de Negociaciones')
        ->view('emails.negociaciones.notificacionEstadoSolicitud')
        ->with(compact('style', 'titulo', 'objTSolEnvioNego'));

    }
}