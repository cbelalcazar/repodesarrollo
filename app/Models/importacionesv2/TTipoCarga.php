<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoCarga
 */
class TTipoCarga extends Model
{
    protected $table = 't_tipo_carga';

    public $timestamps = true;

    protected $fillable = [
        'tcar_descripcion'
    ];

     protected $connection = 'importacionesV2';

}
