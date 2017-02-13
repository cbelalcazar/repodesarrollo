<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TPagoImportacion
 */
class TPagoImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_pago_importacion';

    public $timestamps = true;

    protected $fillable = [
        'pag_importacion',
        'pag_valor_anticipo',
        'pag_valor_saldo',
        'pag_valor_comision',
        'pag_valor_total',
        'pag_valor_fob',
        'pag_fecha_factura',
        'trm_liquidacion_factura',
        'pag_fecha_envio_contabilidad'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}