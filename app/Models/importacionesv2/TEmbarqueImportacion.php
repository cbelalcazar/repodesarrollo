<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TEmbarqueImportacion
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TEmbarqueImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_embarque_importacion';

    public $timestamps = true;

    protected $fillable = [
        'emim_importacion',
        'emim_embarcador',
        'emim_linea_maritima',
        'emim_tipo_carga',
        'emim_fecha_etd',
        'emim_fecha_eta',
        'emim_documento_transporte',
        'emim_valor_flete',
        'emim_fecha_recibido_documentos_ori',
        'emim_fecha_envio_aduana',
        'emim_fecha_envio_ficha_tecnica',
        'emim_fecha_envio_lista_empaque',
        'emim_aduana',
        'emim_transportador',
        'emim_fecha_solicitud_reserva',
        'emim_fecha_confirm_reserva'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];


}
