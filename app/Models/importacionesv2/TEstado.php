<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TEstado
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TEstado extends Model
{
    use Auditable;
    protected $table = 't_estados';

    public $timestamps = true;

    protected $fillable = [
        'est_nombre'
    ];

     protected $connection = 'importacionesV2';

      public function importacion()
   {
       return $this->belongsTo('App\Models\Importacionesv2\TCausalesDemora', 'imp_estado_proceso', 'id');
   }
}

