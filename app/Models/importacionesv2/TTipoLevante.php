<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoLevante
 */
class TTipoLevante extends Model
{
    protected $table = 't_tipo_levante';

    public $timestamps = true;

    protected $fillable = [
        'tlev_nombre'
    ];

     protected $connection = 'importacionesV2';

}
