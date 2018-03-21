<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class citaProveedor extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cita)
    {
        $this->cita = $cita;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
       $style = ['body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;'];
       $titulo = 'Solicitud confirmación de cita Belleza Express';
       $cita = $this->cita;
       $nombre = $cita['cit_nombreproveedor'];
       $fecha = Carbon::parse($cita['cit_fechainicio'])->format('d-m-Y');
       $hora = Carbon::parse($cita['cit_fechainicio'])->format('h:i:s A');
       $programaciones = collect($cita['programaciones']);
       $programaciones = $programaciones->groupBy('prg_num_orden_compra');

        return $this->subject('Solicitud confirmación de cita Belleza Express')
                    ->view('emails.recepcionProveedores.citaProveedor')
                    ->with(compact('style', 'titulo', 'nombre', 'fecha', 'hora', 'programaciones'));
    }
}
