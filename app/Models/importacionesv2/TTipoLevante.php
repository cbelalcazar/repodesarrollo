<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTipoLevante
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TTipoLevante extends Model
{
    use SoftDeletes;

    protected $table = 't_tipo_levante';

    public $timestamps = true;

    protected $fillable = [
        'tlev_nombre'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
