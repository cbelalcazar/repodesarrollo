<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TNacionalizacionImportacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TNacionalizacionImportacion extends Model
{
    use SoftDeletes;
    use Auditable;

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

     protected $dates = ['deleted_at'];

    public function importacion()
    {
        return $this->hasOne('App\Models\Importacionesv2\TImportacion', 'id', 'naco_importacion');
    }

    public function tiponacionalizacion()
    {
        return $this->hasOne('App\Models\Importacionesv2\TTipoNacionalizacion', 'id', 'naco_tipo_nacionalizacion');
    }

    public function declaracion()
    {
        return $this->hasMany('App\Models\Importacionesv2\TDeclaracion', 'decl_nacionalizacion', 'id');
    }
}
