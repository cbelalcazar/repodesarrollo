<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TEstado
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TEstado extends Model
{

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

