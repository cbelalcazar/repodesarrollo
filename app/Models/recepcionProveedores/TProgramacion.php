<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TProgramacion
 */
class TProgramacion extends Model
{
    use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_programacion';

    public $timestamps = true;

    protected $fillable = [
        'prg_num_orden_compra',
        'prg_tipo_doc_oc',
        'prg_referencia',
        'prg_nit_proveedor',
        'prg_fecha_programada',
        'prg_cant_programada',
        'prg_cant_solicitada_oc',
        'prg_cant_entregada_oc',
        'prg_cant_pendiente_oc',
        'prg_unidad_empaque',
        'prg_cant_embalaje',
        'prg_prioridad',
        'prg_estado',
        'prg_observacion',
        'prg_tipo_programacion',
        'prg_fecha_ordenCompra',
        'prg_consecutivoRefOc'
    ];

    protected $guarded = [];

        
}