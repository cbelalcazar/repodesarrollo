<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoNacionalizacion
 */
class TTipoNacionalizacion extends Model
{
    protected $table = 't_tipo_nacionalizacion';

    public $timestamps = true;

    protected $fillable = [
        'tnac_descripcion'
    ];

     protected $connection = 'importacionesV2';
}
