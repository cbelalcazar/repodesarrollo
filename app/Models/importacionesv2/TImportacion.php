<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TImportacion
 */
class TImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_importacion';

    public $timestamps = true;

    protected $fillable = [
        'imp_consecutivo',
        'imp_proveedor',
        'imp_puerto_embarque',
        'imp_iconterm',
        'imp_moneda_negociacion',
        'imp_fecha_entrega_total',
        'imp_observaciones',
        'imp_estado_proceso'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}