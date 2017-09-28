<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class notifProvCita extends Mailable
{
    use Queueable, SerializesModels;
    public $agrupado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agrupado)
    {
       $this->agrupado = $agrupado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $style = ['body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;'];
       $titulo = 'Notificación - Solicitar cita a bodega';
       $agrupado = $this->agrupado;
       $nombre = $agrupado[0]['prg_razonSocialTercero'];
       $fecha = Carbon::parse($agrupado[0]['prg_fecha_ordenCompra'])->format('d-m-Y');
       $programaciones = collect($agrupado);
       $programaciones = $programaciones->groupBy('prg_num_orden_compra');

        return $this->subject('Solicitud confirmación de cita Belleza Express')
                    ->view('emails.recepcionProveedores.notifSolicCitaProv')
                    ->with(compact('style', 'titulo', 'nombre', 'fecha', 'hora', 'programaciones'));
    }
}
