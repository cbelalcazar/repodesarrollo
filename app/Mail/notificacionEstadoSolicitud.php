<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notificacionEstadoSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $dataSolicitud;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataSolicitud)
    {
        $this->dataSolicitud = $dataSolicitud;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $style = ['body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;'];
        $titulo = 'Solicitud de Muestras y Obsequios';
        $dataSolicitud = $this->dataSolicitud;

        $arrayLineas = [];

        foreach ($dataSolicitud['solicitud']['clientes'] as $cliente) {
          foreach ($cliente['clientesReferencias'] as $refe) {
            if(count($arrayLineas) == 0){
              array_push($arrayLineas, $refe['referencia']['LineaItemCriterio']['LineasProducto']);
            }else{

              $filter = [];
              $filter = collect($arrayLineas)->filter(function($linea) use($refe){
                return $linea['CodLinea'] == $refe['referencia']['LineaItemCriterio']['LineasProducto']['CodLinea'];
              })->all();

              if(count($filter) == 0){
                array_push($arrayLineas, $refe['referencia']['LineaItemCriterio']['LineasProducto']);
              }

            }
          }
        }

        $dataSolicitud['lineasCorreo'] = $arrayLineas;

        return $this->subject('Solicitudes Obsequios y Muestras')
        ->view('emails.controlinversion.notificacionEstadoSolicitud')
        ->with(compact('style', 'titulo', 'dataSolicitud'));

    }
}
