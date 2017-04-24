<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;


/**
 * @resource TTipoImportacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTipoImportacion extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_tipo_importacion';

    public $timestamps = true;

    protected $fillable = [
        'timp_nombre'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
