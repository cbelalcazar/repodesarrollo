<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNacionalizacionImportacion
 */
class TNacionalizacionImportacion extends Model
{
    protected $table = 't_nacionalizacion_importacion';

    public $timestamps = true;

    protected $fillable = [
        'naco_importacion',
        'naco_tipo_importacion',
        'naco_anticipo_aduana',
        'naco_fecha_anticipo_aduana',
        'naco_preinscripcion',
        'naco_control_posterior',
        'naco_fecha_recibo_fact_be',
        'naco_fecha_entrega_fact_cont',
        'naco_fecha_entrega_docu_transp',
        'naco_fecha_retiro_puert',
        'naco_fecha_envio_comex',
        'naco_fecha_llegada_be',
        'naco_fecha_recep_list_empaq',
        'naco_fecha_envi_liqu_costeo',
        'naco_fecha_entrada_sistema',
        'naco_sobrante',
        'naco_faltante',
        'naco_factor_dolar_porc',
        'naco_factor_dolar_tasa',
        'naco_factor_logist_porc',
        'naco_factor_logist_tasa',
        'naco_factor_arancel_porc',
        'naco_tipo_nacionalizacion'
    ];

     protected $connection = 'importacionesV2';
}
