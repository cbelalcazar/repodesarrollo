<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TImportacion
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
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

    public function estado()
    {
        return $this->hasOne('App\Models\Importacionesv2\TEstado', 'id', 'imp_estado_proceso');
    }

    public function proveedor()
    {
        return $this->hasOne('App\Models\Genericas\Tercero', 'nitTercero', 'imp_proveedor');
    }

    public function puerto_embarque()
    {
        return $this->hasOne('App\Models\Importacionesv2\TPuertoEmbarque', 'id', 'imp_puerto_embarque');
    }

     public function inconterm()
    {
        return $this->hasOne('App\Models\Importacionesv2\TIconterm', 'id', 'imp_iconterm');
    }


    public function productoimportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TProductoImportacion', 'id', 'pdim_importacion');
    }

    public function origenMercancia()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TOrigenMercanciaImportacion', 'id', 'omeim_importacion');
    }
    

    public function embarqueimportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TEmbarqueImportacion', 'id', 'emim_importacion');
    }

    public function pagosimportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TPagoImportacion', 'id', 'pag_importacion');
    }

    public function nacionalizacionimportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TNacionalizacionImportacion', 'id', 'naco_importacion');
    }

}
