<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TProductoImportacion
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TProductoImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_producto_importacion';

    public $timestamps = true;

    protected $fillable = [
        'pdim_producto',
        'pdim_importacion',
        'pdim_fech_req_declaracion_anticipado',
        'pdim_fech_cierre_declaracion_anticipado',
        'pdim_fech_requ_registro_importacion',
        'pdim_fech_cierre_registro_importacion',
        'pdim_alerta',
        'pdim_numero_licencia_importacion',
        'pdim_fecha_anticipado'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function importacion()
    {
        return $this->hasMany('App\Models\Importacionesv2\TImportacion', 'id', 'pdim_importacion');
    }

}
