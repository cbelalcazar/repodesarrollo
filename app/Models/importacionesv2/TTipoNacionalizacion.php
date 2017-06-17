<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TTipoNacionalizacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTipoNacionalizacion extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_tipo_nacionalizacion';

    public $timestamps = true;

    protected $fillable = [
        'tnac_descripcion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];
}
